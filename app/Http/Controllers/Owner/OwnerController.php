<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Http\Controllers\Admin\SimpleExcelWriter;

class OwnerController extends Controller
{
    /**
     * Display the owner dashboard.
     */
    public function dashboard()
    {
        // Statistics
        $totalUsers = User::where('role', 'customer')->count();
        $totalBookings = Booking::count();
        $totalServices = Service::count();
        $totalRevenue = Booking::where('status', 'completed')->sum('total_price');
        
        // Recent bookings
        $recentBookings = Booking::with(['user', 'service.category'])
                                ->latest()
                                ->take(5)
                                ->get();
        
        // Booking status statistics
        $bookingStats = Booking::select('status', DB::raw('count(*) as count'))
                              ->groupBy('status')
                              ->get();
        
        // Monthly revenue chart data (last 12 months)
        $monthlyRevenue = Booking::select(
                DB::raw('MONTH(booking_date) as month'),
                DB::raw('YEAR(booking_date) as year'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->where('status', 'completed')
            ->where('booking_date', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        return view('owner.dashboard', compact(
            'totalUsers',
            'totalBookings', 
            'totalServices',
            'totalRevenue',
            'recentBookings',
            'bookingStats',
            'monthlyRevenue'
        ));
    }
    
    /**
     * Display Business Intelligence dashboard.
     */
    public function businessIntelligence()
    {
        // Revenue Analytics
        $totalRevenue = Booking::where('status', 'completed')->sum('total_price');
        $monthlyRevenue = Booking::where('status', 'completed')
            ->where('booking_date', '>=', now()->subMonths(12))
            ->selectRaw('MONTH(booking_date) as month, YEAR(booking_date) as year, SUM(total_price) as revenue')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        $dailyRevenue = Booking::where('status', 'completed')
            ->where('booking_date', '>=', now()->subDays(30))
            ->selectRaw('DATE(booking_date) as date, SUM(total_price) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Customer Analytics
        $totalCustomers = User::where('role', 'customer')->count();
        $newCustomersThisMonth = User::where('role', 'customer')
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();
        
        $customerRetention = User::where('role', 'customer')
            ->withCount([
                'bookings',
                'bookings as completed_bookings_count' => function($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->having('bookings_count', '>', 1)
            ->count();
        
        $customerGrowth = User::where('role', 'customer')
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        // Service Performance
        $servicePopularity = Service::withCount([
                'bookings',
                'bookings as completed_bookings_count' => function($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->withSum('bookings', 'total_price')
            ->orderBy('bookings_count', 'desc')
            ->take(10)
            ->get();
        
        // Add default data if no services exist
        if ($servicePopularity->isEmpty()) {
            $servicePopularity = collect([
                (object) ['name' => 'Wedding Photography', 'bookings_count' => 0],
                (object) ['name' => 'Portrait Session', 'bookings_count' => 0],
                (object) ['name' => 'Event Photography', 'bookings_count' => 0],
            ]);
        }
        
        $categoryRevenue = ServiceCategory::with('services.bookings')
            ->get()
            ->map(function($category) {
                $totalRevenue = $category->services->sum(function($service) {
                    return $service->bookings->where('status', 'completed')->sum('total_price');
                });
                $totalBookings = $category->services->sum(function($service) {
                    return $service->bookings->count();
                });
                $category->total_revenue = $totalRevenue;
                $category->total_bookings = $totalBookings;
                return $category;
            })
            ->sortByDesc('total_revenue');
        
        // Booking Analytics - Default to 12 months for consistency
        $bookingsByStatus = Booking::selectRaw('status, COUNT(*) as count')
            ->where('booking_date', '>=', now()->subMonths(12))
            ->groupBy('status')
            ->get();
        
        // Add default data if no bookings exist
        if ($bookingsByStatus->isEmpty()) {
            $bookingsByStatus = collect([
                (object) ['status' => 'pending', 'count' => 0],
                (object) ['status' => 'confirmed', 'count' => 0],
                (object) ['status' => 'completed', 'count' => 0],
                (object) ['status' => 'cancelled', 'count' => 0],
            ]);
        }
        
        $bookingTrends = Booking::selectRaw('DATE(booking_date) as date, COUNT(*) as count')
            ->where('booking_date', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        $averageBookingValue = Booking::where('status', 'completed')
            ->avg('total_price');
        
        $conversionRate = $totalCustomers > 0 
            ? round((Booking::distinct('user_id')->count() / $totalCustomers) * 100, 2)
            : 0;
        
        // Peak Hours Analysis
        $peakHours = Booking::selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(3))
            ->groupBy('hour')
            ->orderBy('count', 'desc')
            ->get();
        
        // Geographical Analysis (if you have customer locations)
        $topLocations = collect(); // Empty collection for now
        
        // Financial KPIs
        $thisMonthRevenue = Booking::where('status', 'completed')
            ->whereMonth('booking_date', now()->month)
            ->whereYear('booking_date', now()->year)
            ->sum('total_price');
        
        $lastMonthRevenue = Booking::where('status', 'completed')
            ->whereMonth('booking_date', now()->subMonth()->month)
            ->whereYear('booking_date', now()->subMonth()->year)
            ->sum('total_price');
        
        $revenueGrowth = $lastMonthRevenue > 0 
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 2)
            : 0;
        
        // Customer Satisfaction (mock data - you can implement real satisfaction tracking)
        $customerSatisfaction = 92.3;
        
        // Service Category Data for charts - Real data from database (default 12 months)
        $serviceCategoryData = $this->getServiceCategoryDataForPeriod(12);
        
        // AI Insights - Generate dynamic insights based on real data
        $aiInsights = $this->generateAIInsights([
            'totalRevenue' => $totalRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'totalCustomers' => $totalCustomers,
            'newCustomersThisMonth' => $newCustomersThisMonth,
            'customerRetention' => $customerRetention,
            'servicePopularity' => $servicePopularity,
            'bookingsByStatus' => $bookingsByStatus,
            'conversionRate' => $conversionRate,
            'revenueGrowth' => $revenueGrowth,
            'averageBookingValue' => $averageBookingValue,
            'peakHours' => $peakHours,
            'thisMonthRevenue' => $thisMonthRevenue,
            'lastMonthRevenue' => $lastMonthRevenue
        ]);
        
        return view('owner.business-intelligence.index', compact(
            'totalRevenue',
            'monthlyRevenue', 
            'dailyRevenue',
            'totalCustomers',
            'newCustomersThisMonth',
            'customerRetention',
            'customerGrowth',
            'servicePopularity',
            'categoryRevenue',
            'bookingsByStatus',
            'bookingTrends',
            'averageBookingValue',
            'conversionRate',
            'peakHours',
            'topLocations',
            'thisMonthRevenue',
            'lastMonthRevenue',
            'revenueGrowth',
            'customerSatisfaction',
            'serviceCategoryData',
            'aiInsights'
        ));
    }

    /**
     * Generate AI insights based on business metrics.
     */
    private function generateAIInsights($metrics)
    {
        $insights = [];

        // Analyze revenue trends
        if ($metrics['revenueGrowth'] > 0) {
            $insights[] = 'Revenue is growing. Maintain your current strategies and explore opportunities to scale further!';
        } else {
            $insights[] = 'Revenue is declining. Consider revisiting your marketing strategies and service offerings.';
        }

        // Evaluate conversion rates
        if ($metrics['conversionRate'] > 50) {
            $insights[] = 'High conversion rate achieved. Excellent customer engagement!';
        } else {
            $insights[] = 'Conversion rate is below desired levels. Optimize your conversion funnel for better results.';
        }

        // Examine new customer counts
        if ($metrics['newCustomersThisMonth'] > 10) {
            $insights[] = 'Strong new customer growth this month. Leverage this by promoting customer loyalty programs.';
        } else {
            $insights[] = 'New customer acquisition has been slow. Consider targeted promotions to attract new clients.';
        }

        // Highlight peak booking hours
        if (isset($metrics['peakHours'][0])) {
            $insights[] = 'Peak booking hours are around ' . $metrics['peakHours'][0]->hour . ':00. Consider staffing accordingly.';
        }

        // Assess service popularity
        if (!empty($metrics['servicePopularity'])) {
            $mostPopularService = $metrics['servicePopularity']->first();
            $insights[] = 'Most popular service is ' . $mostPopularService->name . '. Focus marketing efforts here.';
        }

        return $insights;
    }

    /**
     * Get service category data for specific time period (AJAX)
     */
    public function getServiceCategoryData(Request $request)
    {
        $months = $request->get('months', 12); // Default to 12 months
        
        // Get service category data for specified period
        $serviceCategoryData = $this->getServiceCategoryDataForPeriod($months);
        
        return response()->json($serviceCategoryData);
    }
    
    /**
     * Get revenue data for specific time period (AJAX)
     */
    public function getRevenueData(Request $request)
    {
        $months = $request->get('months', 12); // Default to 12 months
        
        // Get revenue data for specified period
        $revenueData = Booking::where('status', 'completed')
            ->where('booking_date', '>=', now()->subMonths($months))
            ->selectRaw('MONTH(booking_date) as month, YEAR(booking_date) as year, SUM(total_price) as revenue')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        return response()->json($revenueData);
    }
    
    /**
     * Get customer growth data for specific time period (AJAX)
     */
    public function getCustomerGrowthData(Request $request)
    {
        $months = $request->get('months', 12); // Default to 12 months
        
        // Get customer growth data for specified period
        $customerGrowthData = User::where('role', 'customer')
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths($months))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        return response()->json($customerGrowthData);
    }

    /**
     * Get service category data for specified period
     */
    private function getServiceCategoryDataForPeriod($months = 12)
    {
        $serviceCategoryData = [];
        
        // Get service categories
        $categories = ServiceCategory::where('is_active', true)->get();
        
        foreach ($categories as $category) {
            // Get bookings for this category in the specified period
            $categoryBookings = Booking::join('services', 'bookings.service_id', '=', 'services.id')
                ->join('service_categories', 'services.service_category_id', '=', 'service_categories.id')
                ->where('service_categories.id', $category->id)
                ->where('bookings.booking_date', '>=', now()->subMonths($months))
                ->selectRaw('MONTH(bookings.booking_date) as month, YEAR(bookings.booking_date) as year, COUNT(bookings.id) as quantity')
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();
            
            // Convert to month names for chart
            $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            $chartData = [];
            
            // Fill data for specified number of months
            for ($i = $months - 1; $i >= 0; $i--) {
                $targetDate = now()->subMonths($i);
                $targetMonth = $targetDate->month;
                $targetYear = $targetDate->year;
                
                $booking = $categoryBookings->where('month', $targetMonth)->where('year', $targetYear)->first();
                $quantity = $booking ? $booking->quantity : 0;
                
                $chartData[] = [
                    'month' => $monthNames[$targetMonth - 1],
                    'quantity' => $quantity
                ];
            }
            
            // Use lowercase category name as key
            $serviceCategoryData[strtolower($category->name)] = $chartData;
        }
        
        // Add default data if no categories exist
        if (empty($serviceCategoryData)) {
            $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            $defaultData = [];
            
            for ($i = $months - 1; $i >= 0; $i--) {
                $targetDate = now()->subMonths($i);
                $targetMonth = $targetDate->month;
                
                $defaultData[] = [
                    'month' => $monthNames[$targetMonth - 1],
                    'quantity' => 0
                ];
            }
            
            $serviceCategoryData = [
                'outdoor' => $defaultData,
                'indoor' => $defaultData
            ];
        }
        
        return $serviceCategoryData;
    }
    
    /**
     * Get AI insights for business intelligence (AJAX)
     */
    public function getAIInsights(Request $request)
    {
        try {
            \Log::info('AI Insights: Starting calculation');
            
            // Collect all the metrics needed for AI insights
            $totalRevenue = Booking::where('status', 'completed')->sum('total_price');
            \Log::info('AI Insights: Total revenue calculated', ['totalRevenue' => $totalRevenue]);
            
            $totalCustomers = User::where('role', 'customer')->count();
            \Log::info('AI Insights: Total customers calculated', ['totalCustomers' => $totalCustomers]);
            
            $newCustomersThisMonth = User::where('role', 'customer')
                ->where('created_at', '>=', now()->startOfMonth())
                ->count();
            \Log::info('AI Insights: New customers this month calculated', ['newCustomersThisMonth' => $newCustomersThisMonth]);
            
            $customerRetention = User::where('role', 'customer')
                ->withCount([
                    'bookings',
                    'bookings as completed_bookings_count' => function($query) {
                        $query->where('status', 'completed');
                    }
                ])
                ->having('bookings_count', '>', 1)
                ->count();
            \Log::info('AI Insights: Customer retention calculated', ['customerRetention' => $customerRetention]);
            
            $servicePopularity = Service::withCount([
                    'bookings',
                    'bookings as completed_bookings_count' => function($query) {
                        $query->where('status', 'completed');
                    }
                ])
                ->withSum('bookings', 'total_price')
                ->orderBy('bookings_count', 'desc')
                ->take(10)
                ->get();
            \Log::info('AI Insights: Service popularity calculated', ['servicePopularity' => $servicePopularity]);
            
            $bookingsByStatus = Booking::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get();
            \Log::info('AI Insights: Bookings by status calculated', ['bookingsByStatus' => $bookingsByStatus]);
            
            $averageBookingValue = Booking::where('status', 'completed')
                ->avg('total_price');
            \Log::info('AI Insights: Average booking value calculated', ['averageBookingValue' => $averageBookingValue]);
            
            $conversionRate = $totalCustomers > 0 
                ? round((Booking::distinct('user_id')->count() / $totalCustomers) * 100, 2)
                : 0;
            \Log::info('AI Insights: Conversion rate calculated', ['conversionRate' => $conversionRate]);
            
            $peakHours = Booking::selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
                ->where('created_at', '>=', now()->subMonths(3))
                ->groupBy('hour')
                ->orderBy('count', 'desc')
                ->get();
            \Log::info('AI Insights: Peak hours calculated', ['peakHours' => $peakHours]);
            
            // Financial KPIs
            $thisMonthRevenue = Booking::where('status', 'completed')
                ->whereMonth('booking_date', now()->month)
                ->whereYear('booking_date', now()->year)
                ->sum('total_price');
            \Log::info('AI Insights: This month revenue calculated', ['thisMonthRevenue' => $thisMonthRevenue]);
            
            $lastMonthRevenue = Booking::where('status', 'completed')
                ->whereMonth('booking_date', now()->subMonth()->month)
                ->whereYear('booking_date', now()->subMonth()->year)
                ->sum('total_price');
            \Log::info('AI Insights: Last month revenue calculated', ['lastMonthRevenue' => $lastMonthRevenue]);
            
            $revenueGrowth = $lastMonthRevenue > 0 
                ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 2)
                : 0;
            \Log::info('AI Insights: Revenue growth calculated', ['revenueGrowth' => $revenueGrowth]);
            
            // Generate AI insights using the existing method
            $aiInsights = $this->generateAIInsights([
                'totalRevenue' => $totalRevenue,
                'totalCustomers' => $totalCustomers,
                'newCustomersThisMonth' => $newCustomersThisMonth,
                'customerRetention' => $customerRetention,
                'servicePopularity' => $servicePopularity,
                'bookingsByStatus' => $bookingsByStatus,
                'conversionRate' => $conversionRate,
                'revenueGrowth' => $revenueGrowth,
                'averageBookingValue' => $averageBookingValue,
                'peakHours' => $peakHours,
                'thisMonthRevenue' => $thisMonthRevenue,
                'lastMonthRevenue' => $lastMonthRevenue
            ]);
            \Log::info('AI Insights: Generated insights', ['aiInsights' => $aiInsights]);
            
            // Generate calculation details for weighted average
            $calculationDetails = $this->generateCalculationDetails([
                'thisMonthRevenue' => $thisMonthRevenue,
                'lastMonthRevenue' => $lastMonthRevenue,
                'revenueGrowth' => $revenueGrowth,
                'averageBookingValue' => $averageBookingValue,
                'conversionRate' => $conversionRate,
                'customerRetention' => $customerRetention,
                'newCustomersThisMonth' => $newCustomersThisMonth
            ]);
            \Log::info('AI Insights: Generated calculation details', ['calculationDetails' => $calculationDetails]);
            
            // Calculate predictions for next month using weighted average results
            $predictions = $this->calculatePredictions([
                'thisMonthRevenue' => $thisMonthRevenue,
                'lastMonthRevenue' => $lastMonthRevenue,
                'revenueGrowth' => $revenueGrowth,
                'averageBookingValue' => $averageBookingValue,
                'totalCustomers' => $totalCustomers,
                'newCustomersThisMonth' => $newCustomersThisMonth,
                'conversionRate' => $conversionRate,
                'servicePopularity' => $servicePopularity,
                'bookingsByStatus' => $bookingsByStatus
            ], $calculationDetails);
            \Log::info('AI Insights: Generated predictions', ['predictions' => $predictions]);
            
            return response()->json([
                'success' => true,
                'insights' => $aiInsights,
                'metrics' => [
                    'totalRevenue' => $totalRevenue,
                    'totalCustomers' => $totalCustomers,
                    'newCustomersThisMonth' => $newCustomersThisMonth,
                    'conversionRate' => $conversionRate,
                    'revenueGrowth' => $revenueGrowth,
                    'averageBookingValue' => round($averageBookingValue, 2),
                    'customerRetention' => $customerRetention
                ],
                'predictions' => $predictions,
                'calculationDetails' => $calculationDetails,
                'timestamp' => now()->format('Y-m-d H:i:s')
            ]);
            
        } catch (\Exception $e) {
            \Log::error('AI Insights: Error generating insights', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'error' => 'Failed to generate AI insights: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get service data for specific time period (AJAX)
     */
    public function getServiceData(Request $request)
    {
        $months = $request->get('months', 12); // Default to 12 months
        
        // Get service popularity data for specified period
        $serviceData = Service::withCount([
                'bookings' => function($query) use ($months) {
                    $query->where('booking_date', '>=', now()->subMonths($months));
                },
                'bookings as completed_bookings_count' => function($query) use ($months) {
                    $query->where('status', 'completed')
                          ->where('booking_date', '>=', now()->subMonths($months));
                }
            ])
            ->withSum(['bookings' => function($query) use ($months) {
                $query->where('booking_date', '>=', now()->subMonths($months));
            }], 'total_price')
            ->orderBy('bookings_count', 'desc')
            ->take(10)
            ->get();
        
        // Add default data if no services exist
        if ($serviceData->isEmpty()) {
            $serviceData = collect([
                (object) ['name' => 'Wedding Photography', 'bookings_count' => 0],
                (object) ['name' => 'Portrait Session', 'bookings_count' => 0],
                (object) ['name' => 'Event Photography', 'bookings_count' => 0],
            ]);
        }
        
        return response()->json($serviceData);
    }
    
    /**
     * Get booking status data for specific time period (AJAX)
     */
    public function getStatusData(Request $request)
    {
        $months = $request->get('months', 12); // Default to 12 months
        
        // Get booking status data for specified period
        $statusData = Booking::selectRaw('status, COUNT(*) as count')
            ->where('booking_date', '>=', now()->subMonths($months))
            ->groupBy('status')
            ->get();
        
        // Add default data if no bookings exist
        if ($statusData->isEmpty()) {
            $statusData = collect([
                (object) ['status' => 'pending', 'count' => 0],
                (object) ['status' => 'confirmed', 'count' => 0],
                (object) ['status' => 'completed', 'count' => 0],
                (object) ['status' => 'cancelled', 'count' => 0],
            ]);
        }
        
        return response()->json($statusData);
    }
    
    /**
     * Get cancellation reason data for specific time period (AJAX)
     */
    public function getCancellationReasonData(Request $request)
    {
        $months = $request->get('months', 12); // Default to 12 months
        
        // Get total cancelled bookings for the specified period
        $totalCancelledBookings = Booking::where('status', 'cancelled')
            ->where('booking_date', '>=', now()->subMonths($months))
            ->count();
        
        // Define cancellation reasons with probabilistic distribution
        $cancellationReasons = [
            'Terlalu Mahal' => 0.35,
            'Produk Kurang Jelas' => 0.25,
            'Jadwal Tidak Sesuai' => 0.20,
            'Lokasi Terlalu Jauh' => 0.10,
            'Perubahan Rencana' => 0.10
        ];
        
        // Calculate estimated counts based on probability
        $reasonData = [];
        $totalAllocated = 0;
        
        if ($totalCancelledBookings > 0) {
            foreach ($cancellationReasons as $reason => $probability) {
                $estimatedCount = round($totalCancelledBookings * $probability);
                $totalAllocated += $estimatedCount;
                $reasonData[] = [
                    'reason' => $reason,
                    'count' => $estimatedCount,
                    'percentage' => round($probability * 100, 1)
                ];
            }
            
            // Adjust the last item if there's rounding difference
            $difference = $totalCancelledBookings - $totalAllocated;
            if ($difference != 0 && count($reasonData) > 0) {
                $lastIndex = count($reasonData) - 1;
                $reasonData[$lastIndex]['count'] += $difference;
            }
        } else {
            // If no cancelled bookings, return zero data but maintain structure
            foreach ($cancellationReasons as $reason => $probability) {
                $reasonData[] = [
                    'reason' => $reason,
                    'count' => 0,
                    'percentage' => round($probability * 100, 1)
                ];
            }
        }
        
        // Filter out zero counts for cleaner display (optional)
        $reasonData = array_filter($reasonData, function($item) {
            return $item['count'] > 0;
        });
        
        // Re-index array to ensure sequential indices
        $reasonData = array_values($reasonData);
        
        return response()->json([
            'total_cancelled' => $totalCancelledBookings,
            'reasons' => $reasonData,
            'period_months' => $months,
            'has_data' => count($reasonData) > 0
        ]);
    }
    
    /**
     * Calculate predictions for next month based on current metrics
     */
    private function calculatePredictions($metrics, $calculationDetails = null)
    {
        // Get calculation details if not provided
        if (!$calculationDetails) {
            $calculationDetails = $this->generateCalculationDetails($metrics);
        }
        
        // Use the weighted average predictions from calculation details
        $predictedRevenue = $calculationDetails['revenue']['prediction'];
        $predictedCustomers = $calculationDetails['customers']['prediction'];
        $predictedBookings = $calculationDetails['bookings']['prediction'];
        
        // Service demand prediction based on popularity
        $mostPopularService = $metrics['servicePopularity']->first();
        $predictedTopService = $mostPopularService ? $mostPopularService->name : 'Wedding Photography';
        
        return [
            'revenue' => round($predictedRevenue, 2),
            'customers' => $predictedCustomers,
            'bookings' => $predictedBookings,
            'topService' => $predictedTopService,
            'confidence' => 85.5, // Mock confidence score
            'revenueGrowthTrend' => $metrics['revenueGrowth'] // Add growth trend
        ];
    }
    
    /**
     * Generate calculation details for weighted average methodology
     */
    private function generateCalculationDetails($metrics)
    {
        // Get monthly revenue data for the last 6 months
        $monthlyRevenue = Booking::where('status', 'completed')
            ->where('booking_date', '>=', now()->subMonths(6))
            ->selectRaw('MONTH(booking_date) as month, YEAR(booking_date) as year, SUM(total_price) as revenue')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        // Get monthly customer data for the last 6 months
        $monthlyCustomers = User::where('role', 'customer')
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(id) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        // Get monthly booking data for the last 6 months
        $monthlyBookings = Booking::where('booking_date', '>=', now()->subMonths(6))
            ->selectRaw('MONTH(booking_date) as month, YEAR(booking_date) as year, COUNT(id) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        // Prepare revenue calculation details
        $revenueBreakdown = [];
        $totalWeightedRevenue = 0;
        $totalWeights = 0;
        
        for ($i = 5; $i >= 0; $i--) {
            $targetDate = now()->subMonths($i);
            $weight = 6 - $i; // Weight from 1 to 6 (most recent gets highest weight)
            
            // Find revenue for this month
            $monthRevenue = $monthlyRevenue->where('month', $targetDate->month)
                ->where('year', $targetDate->year)
                ->first();
            
            $revenue = $monthRevenue ? $monthRevenue->revenue : 0;
            $weightedValue = $revenue * $weight;
            $totalWeightedRevenue += $weightedValue;
            $totalWeights += $weight;
            
            $revenueBreakdown[] = [
                'month' => $monthNames[$targetDate->month - 1] . ' ' . $targetDate->year,
                'value' => number_format($revenue, 0, ',', '.'),
                'raw_value' => $revenue, // Store raw value for formula
                'weight' => $weight,
                'weighted_value' => number_format($weightedValue, 0, ',', '.'),
                'percentage' => round(($weight / 21) * 100, 1) // 21 is sum of weights (1+2+3+4+5+6)
            ];
        }
        
        // Prepare customer calculation details
        $customerBreakdown = [];
        $totalWeightedCustomers = 0;
        $totalCustomerWeights = 0;
        
        for ($i = 5; $i >= 0; $i--) {
            $targetDate = now()->subMonths($i);
            $weight = 6 - $i;
            
            // Find customers for this month
            $monthCustomers = $monthlyCustomers->where('month', $targetDate->month)
                ->where('year', $targetDate->year)
                ->first();
            
            $customers = $monthCustomers ? $monthCustomers->count : 0;
            $weightedValue = $customers * $weight;
            $totalWeightedCustomers += $weightedValue;
            $totalCustomerWeights += $weight;
            
            $customerBreakdown[] = [
                'month' => $monthNames[$targetDate->month - 1] . ' ' . $targetDate->year,
                'value' => number_format($customers, 0, ',', '.'),
                'raw_value' => $customers, // Store raw value for formula
                'weight' => $weight,
                'weighted_value' => number_format($weightedValue, 0, ',', '.'),
                'percentage' => round(($weight / 21) * 100, 1)
            ];
        }
        
        // Prepare booking calculation details
        $bookingBreakdown = [];
        $totalWeightedBookings = 0;
        $totalBookingWeights = 0;
        
        for ($i = 5; $i >= 0; $i--) {
            $targetDate = now()->subMonths($i);
            $weight = 6 - $i;
            
            // Find bookings for this month
            $monthBookings = $monthlyBookings->where('month', $targetDate->month)
                ->where('year', $targetDate->year)
                ->first();
            
            $bookings = $monthBookings ? $monthBookings->count : 0;
            $weightedValue = $bookings * $weight;
            $totalWeightedBookings += $weightedValue;
            $totalBookingWeights += $weight;
            
            $bookingBreakdown[] = [
                'month' => $monthNames[$targetDate->month - 1] . ' ' . $targetDate->year,
                'value' => number_format($bookings, 0, ',', '.'),
                'raw_value' => $bookings, // Store raw value for formula
                'weight' => $weight,
                'weighted_value' => number_format($weightedValue, 0, ',', '.'),
                'percentage' => round(($weight / 21) * 100, 1)
            ];
        }
        
        // Calculate predictions
        $predictedRevenue = $totalWeights > 0 ? $totalWeightedRevenue / $totalWeights : 0;
        $predictedCustomers = $totalCustomerWeights > 0 ? $totalWeightedCustomers / $totalCustomerWeights : 0;
        $predictedBookings = $totalBookingWeights > 0 ? $totalWeightedBookings / $totalBookingWeights : 0;
        
        return [
            'revenue' => [
                'type' => 'Prediksi Pendapatan',
                'breakdown' => $revenueBreakdown,
                'formula' => sprintf('((%s) ÷ %d)', 
                    implode(' + ', array_map(function($item) {
                        return 'Rp ' . number_format($item['raw_value'], 0, ',', '.') . '×' . $item['weight'];
                    }, $revenueBreakdown)), 
                    $totalWeights
                ),
                'prediction' => round($predictedRevenue)
            ],
            'customers' => [
                'type' => 'Prediksi Pelanggan Baru',
                'breakdown' => $customerBreakdown,
                'formula' => sprintf('((%s) ÷ %d)', 
                    implode(' + ', array_map(function($item) {
                        return number_format($item['raw_value']) . ' pelanggan×' . $item['weight'];
                    }, $customerBreakdown)), 
                    $totalCustomerWeights
                ),
                'prediction' => round($predictedCustomers)
            ],
            'bookings' => [
                'type' => 'Prediksi Pemesanan',
                'breakdown' => $bookingBreakdown,
                'formula' => sprintf('((%s) ÷ %d)', 
                    implode(' + ', array_map(function($item) {
                        return number_format($item['raw_value']) . ' pemesanan×' . $item['weight'];
                    }, $bookingBreakdown)), 
                    $totalBookingWeights
                ),
                'prediction' => round($predictedBookings)
            ]
        ];
    }
    
    /**
     * Get performance level based on weighted score
     */
    private function getPerformanceLevel($score)
    {
        if ($score >= 80) {
            return 'Excellent';
        } elseif ($score >= 60) {
            return 'Good';
        } elseif ($score >= 40) {
            return 'Average';
        } else {
            return 'Needs Improvement';
        }
    }

    /**
     * Export business report as PDF or Excel.
     */
    public function exportBusinessReport($format = 'pdf')
    {
        // For now, return a simple response indicating the feature is available
        // You can implement actual PDF/Excel generation later
        return response()->json([
            'success' => true,
            'message' => 'Export feature will be implemented soon',
            'format' => $format
        ]);
    }
}
