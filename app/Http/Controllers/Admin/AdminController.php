<?php

namespace App\Http\Controllers\Admin;

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

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
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
        
        return view('admin.dashboard', compact(
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
     * Display admin settings.
     */
    public function settings()
    {
        return view('admin.settings');
    }
    
    /**
     * Update admin settings.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'site_phone' => 'nullable|string|max:255',
            'site_address' => 'nullable|string|max:500',
            'business_hours' => 'nullable|string|max:500',
            'booking_advance_days' => 'required|integer|min:1|max:365',
            'max_bookings_per_day' => 'required|integer|min:1|max:50',
            'auto_confirm_bookings' => 'boolean',
            'email_notifications' => 'boolean',
            'maintenance_mode' => 'boolean',
        ]);
        
        // Handle boolean fields that might not be sent in the request
        $settings = [
            'site_name' => $request->site_name,
            'site_email' => $request->site_email,
            'site_phone' => $request->site_phone,
            'site_address' => $request->site_address,
            'business_hours' => $request->business_hours,
            'booking_advance_days' => $request->booking_advance_days,
            'max_bookings_per_day' => $request->max_bookings_per_day,
            'auto_confirm_bookings' => $request->has('auto_confirm_bookings'),
            'email_notifications' => $request->has('email_notifications'),
            'maintenance_mode' => $request->has('maintenance_mode'),
        ];
        
        // Save settings to database using Setting model
        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
        
        return redirect()->route('admin.settings')
                        ->with('success', 'Settings updated successfully!');
    }
    
    /**
     * Display users management.
     */
    public function users(Request $request)
    {
        $query = User::query();
        
        // Get total statistics (not filtered) for display
        $totalUsers = User::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalStudioStaff = User::where('role', 'studio_staff')->count();
        
        // Apply search filter if provided
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%')
                  ->orWhere('phone', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Apply role filter if provided
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Get users with pagination (10 per page)
        $users = $query->withCount('bookings')
                      ->latest()
                      ->paginate(10)
                      ->withQueryString(); // Maintain search parameters in pagination links
        
        return view('admin.users', compact('users', 'totalUsers', 'totalCustomers', 'totalAdmins', 'totalStudioStaff'));
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
        
        // Booking Analytics
        $bookingsByStatus = Booking::selectRaw('status, COUNT(*) as count')
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
        // Note: Commented out until 'city' column is added to users table
        // $topLocations = User::where('role', 'customer')
        //     ->whereNotNull('city')
        //     ->selectRaw('city, COUNT(*) as count')
        //     ->groupBy('city')
        //     ->orderBy('count', 'desc')
        //     ->take(10)
        //     ->get();
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
        
        return view('admin.business-intelligence.index', compact(
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

        // Generate predictions using Weighted Average
        $predictions = $this->generateWeightedAveragePredictions();
        
        // Revenue prediction insight
        if ($predictions['nextMonthRevenue'] > 0) {
            $insights[] = 'AI Prediksi: Pendapatan bulan depan diprediksi sebesar Rp ' . number_format($predictions['nextMonthRevenue'], 0, ',', '.') . ' berdasarkan analisis weighted average dari 6 bulan terakhir.';
        }
        
        // Booking prediction insight
        if ($predictions['nextMonthBookings'] > 0) {
            $insights[] = 'AI Prediksi: Jumlah pemesanan bulan depan diprediksi sebanyak ' . round($predictions['nextMonthBookings']) . ' pemesanan berdasarkan tren historical.';
        }
        
        // Customer prediction insight
        if ($predictions['nextMonthCustomers'] > 0) {
            $insights[] = 'AI Prediksi: Pelanggan baru bulan depan diprediksi sebanyak ' . round($predictions['nextMonthCustomers']) . ' pelanggan berdasarkan pola pertumbuhan.';
        }
        
        // Growth trend analysis
        if ($predictions['revenueGrowthTrend'] > 0) {
            $insights[] = 'Tren positif: Pendapatan menunjukkan pertumbuhan ' . round($predictions['revenueGrowthTrend'], 2) . '% berdasarkan weighted average analysis.';
        } else {
            $insights[] = 'Perhatian: Pendapatan menunjukkan penurunan ' . abs(round($predictions['revenueGrowthTrend'], 2)) . '%. Perlu strategi perbaikan.';
        }

        // Analyze revenue trends
        if ($metrics['revenueGrowth'] > 0) {
            $insights[] = 'Pendapatan sedang tumbuh. Pertahankan strategi saat ini dan jelajahi peluang untuk berkembang lebih jauh!';
        } else {
            $insights[] = 'Pendapatan sedang menurun. Pertimbangkan untuk meninjau kembali strategi pemasaran dan penawaran layanan.';
        }

        // Evaluate conversion rates
        if ($metrics['conversionRate'] > 50) {
            $insights[] = 'Tingkat konversi tinggi telah dicapai. Keterlibatan pelanggan yang luar biasa!';
        } else {
            $insights[] = 'Tingkat konversi di bawah level yang diinginkan. Optimalkan saluran konversi untuk hasil yang lebih baik.';
        }

        // Examine new customer counts
        if ($metrics['newCustomersThisMonth'] > 10) {
            $insights[] = 'Pertumbuhan pelanggan baru yang kuat bulan ini. Manfaatkan ini dengan mempromosikan program loyalitas pelanggan.';
        } else {
            $insights[] = 'Akuisisi pelanggan baru telah melambat. Pertimbangkan promosi yang ditargetkan untuk menarik klien baru.';
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
     * Generate predictions using Weighted Average method
     */
    private function generateWeightedAveragePredictions()
    {
        // Get historical data for the last 6 months
        $historicalData = $this->getHistoricalDataForPrediction(6);
        
        // Calculate weighted average predictions with details
        $revenueDetails = $this->calculateWeightedAverageWithDetails($historicalData['revenue'], 'Pendapatan');
        $bookingDetails = $this->calculateWeightedAverageWithDetails($historicalData['bookings'], 'Pemesanan');
        $customerDetails = $this->calculateWeightedAverageWithDetails($historicalData['customers'], 'Pelanggan Baru');
        
        // Calculate growth trend
        $revenueGrowthTrend = $this->calculateGrowthTrend($historicalData['revenue']);
        
        return [
            'nextMonthRevenue' => $revenueDetails['prediction'],
            'nextMonthBookings' => $bookingDetails['prediction'],
            'nextMonthCustomers' => $customerDetails['prediction'],
            'revenueGrowthTrend' => $revenueGrowthTrend,
            'calculationDetails' => [
                'revenue' => $revenueDetails['details'],
                'bookings' => $bookingDetails['details'],
                'customers' => $customerDetails['details']
            ]
        ];
    }
    
    /**
     * Get historical data for prediction analysis
     */
    private function getHistoricalDataForPrediction($months = 6)
    {
        // Get the start date for the query
        $startDate = now()->subMonths($months)->startOfMonth();
        
        // Initialize arrays to store data for each month
        $revenueData = [];
        $bookingData = [];
        $customerData = [];
        
        // Get data for each month in the period (dari yang terlama ke terbaru)
        for ($i = $months - 1; $i >= 0; $i--) {
            $monthStart = now()->subMonths($i)->startOfMonth();
            $monthEnd = now()->subMonths($i)->endOfMonth();
            
            // Revenue data for this month
            $monthRevenue = Booking::where('status', 'completed')
                ->whereBetween('booking_date', [$monthStart, $monthEnd])
                ->sum('total_price');
            $revenueData[] = floatval($monthRevenue ?: 0);
            
            // Booking count data for this month
            $monthBookings = Booking::whereBetween('booking_date', [$monthStart, $monthEnd])
                ->count();
            $bookingData[] = intval($monthBookings ?: 0);
            
            // Customer data for this month
            $monthCustomers = User::where('role', 'customer')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();
            $customerData[] = intval($monthCustomers ?: 0);
        }
        
        // Debug: Log the data with month details
        $monthDetails = [];
        for ($i = 0; $i < $months; $i++) {
            $monthStart = now()->subMonths($months - 1 - $i)->startOfMonth();
            $monthEnd = now()->subMonths($months - 1 - $i)->endOfMonth();
            $monthDetails[] = [
                'index' => $i,
                'month' => $monthStart->format('Y-m'),
                'month_name' => $monthStart->format('M'),
                'start' => $monthStart->format('Y-m-d'),
                'end' => $monthEnd->format('Y-m-d'),
                'revenue' => $revenueData[$i] ?? 0,
                'bookings' => $bookingData[$i] ?? 0,
                'customers' => $customerData[$i] ?? 0
            ];
        }
        
        \Log::info('Historical Data Debug:', [
            'months' => $months,
            'start_date' => $startDate->format('Y-m-d'),
            'current_month' => now()->format('Y-m'),
            'revenue_count' => count($revenueData),
            'bookings_count' => count($bookingData),
            'customers_count' => count($customerData),
            'revenue_data' => $revenueData,
            'bookings_data' => $bookingData,
            'customers_data' => $customerData,
            'month_details' => $monthDetails
        ]);
        
        return [
            'revenue' => $revenueData,
            'bookings' => $bookingData,
            'customers' => $customerData
        ];
    }
    
    /**
     * Calculate weighted average with recent months having higher weight
     */
    private function calculateWeightedAverage($data)
    {
        if (empty($data)) {
            return 0;
        }
        
        $weights = [];
        $count = count($data);
        
        // Generate weights: recent months have higher weight
        // Example: for 6 months, weights = [1, 2, 3, 4, 5, 6] (most recent = 6)
        for ($i = 1; $i <= $count; $i++) {
            $weights[] = $i;
        }
        
        $weightedSum = 0;
        $totalWeight = 0;
        
        for ($i = 0; $i < $count; $i++) {
            $weightedSum += $data[$i] * $weights[$i];
            $totalWeight += $weights[$i];
        }
        
        return $totalWeight > 0 ? $weightedSum / $totalWeight : 0;
    }
    
    /**
     * Calculate weighted average with detailed breakdown
     */
    private function calculateWeightedAverageWithDetails($data, $type = 'Value')
    {
        if (empty($data)) {
            return [
                'prediction' => 0,
                'details' => [
                    'type' => $type,
                    'total_weight' => 0,
                    'weighted_sum' => 0,
                    'breakdown' => [],
                    'formula' => 'No data available'
                ]
            ];
        }
        
        $weights = [];
        $count = count($data);
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        // Generate weights: recent months have higher weight
        for ($i = 1; $i <= $count; $i++) {
            $weights[] = $i;
        }
        
        $weightedSum = 0;
        $totalWeight = 0;
        $breakdown = [];
        
        // Get the current month and calculate proper month names
        $currentMonth = now()->month;
        
        for ($i = 0; $i < $count; $i++) {
            $value = floatval($data[$i] ?? 0); // Ensure it's a float
            $weight = $weights[$i];
            $weightedValue = $value * $weight;
            
            // Calculate the actual month for this data point
            // Data sudah diurutkan dari terlama ke terbaru (6 bulan lalu sampai bulan ini)
            $monthsBack = $count - 1 - $i;
            $targetDate = now()->subMonths($monthsBack);
            $targetMonth = $targetDate->month;
            
            $monthName = $monthNames[$targetMonth - 1]; // Adjust for 0-based array
            
            $breakdown[] = [
                'month' => $monthName,
                'value' => $value,
                'weight' => $weight,
                'weighted_value' => $weightedValue,
                'percentage' => $weight
            ];
            
            $weightedSum += $weightedValue;
            $totalWeight += $weight;
        }
        
        // Calculate percentage contribution for each month
        foreach ($breakdown as &$item) {
            $item['percentage'] = $totalWeight > 0 ? round(($item['weight'] / $totalWeight) * 100, 1) : 0;
        }
        
        $prediction = $totalWeight > 0 ? $weightedSum / $totalWeight : 0;
        
        // Log debug information
        \Log::info('Weighted Average Calculation:', [
            'type' => $type,
            'data' => $data,
            'weighted_sum' => $weightedSum,
            'total_weight' => $totalWeight,
            'prediction' => $prediction,
            'breakdown' => $breakdown
        ]);
        
        return [
            'prediction' => $prediction,
            'details' => [
                'type' => $type,
                'total_weight' => $totalWeight,
                'weighted_sum' => $weightedSum,
                'breakdown' => $breakdown,
                'formula' => $this->generateFormulaString($breakdown, $totalWeight),
                'prediction' => $prediction // Add prediction to details for display
            ]
        ];
    }
    
    /**
     * Generate formula string for weighted average calculation
     */
    private function generateFormulaString($breakdown, $totalWeight)
    {
        if (empty($breakdown)) {
            return 'Formula tidak tersedia';
        }
        
        $numerator = [];
        foreach ($breakdown as $item) {
            $value = isset($item['value']) ? number_format($item['value'], 0) : '0';
            $weight = isset($item['weight']) ? $item['weight'] : '0';
            $numerator[] = $value . '×' . $weight;
        }
        
        $formula = '(' . implode(' + ', $numerator) . ') ÷ ' . $totalWeight;
        return $formula;
    }
    
    /**
     * Calculate growth trend percentage
     */
    private function calculateGrowthTrend($data)
    {
        if (count($data) < 2) {
            return 0;
        }
        
        // Compare recent 3 months average with previous 3 months average
        $recentAvg = array_sum(array_slice($data, -3)) / 3;
        $previousAvg = array_sum(array_slice($data, -6, 3)) / 3;
        
        if ($previousAvg > 0) {
            return (($recentAvg - $previousAvg) / $previousAvg) * 100;
        }
        
        return 0;
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
            
            // Get prediction details for calculation table
            $predictions = $this->generateWeightedAveragePredictions();
            
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
                'predictions' => [
                    'nextMonthRevenue' => $predictions['nextMonthRevenue'] ?? 0,
                    'nextMonthBookings' => $predictions['nextMonthBookings'] ?? 0,
                    'nextMonthCustomers' => $predictions['nextMonthCustomers'] ?? 0,
                    'revenueGrowthTrend' => $predictions['revenueGrowthTrend'] ?? 0
                ],
                'calculationDetails' => $predictions['calculationDetails'] ?? null,
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
     * Export business report as PDF or Excel.
     */
    public function exportBusinessReport($format = 'pdf')
    {
        // Collect comprehensive business data
        $totalRevenue = Booking::where('status', 'completed')->sum('total_price');
        $totalCustomers = User::where('role', 'customer')->count();
        $totalBookings = Booking::count();
        $totalServices = Service::count();
        
        // Monthly revenue data
        $monthlyRevenue = Booking::where('status', 'completed')
            ->where('booking_date', '>=', now()->subMonths(12))
            ->selectRaw('MONTH(booking_date) as month, YEAR(booking_date) as year, SUM(total_price) as revenue')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        // Customer growth data
        $customerGrowth = User::where('role', 'customer')
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        // Service popularity
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
        
        // Booking status distribution
        $bookingsByStatus = Booking::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();
        
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
            
        $averageBookingValue = Booking::where('status', 'completed')
            ->avg('total_price');
            
        $conversionRate = $totalCustomers > 0 
            ? round((Booking::distinct('user_id')->count() / $totalCustomers) * 100, 2)
            : 0;
        
        // Recent bookings
        $recentBookings = Booking::with(['user', 'service.category'])
            ->latest()
            ->take(10)
            ->get();
        
        // Service category revenue
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

        $data = [
            'reportTitle' => 'Laporan Bisnis Yujin Foto Studio',
            'generatedAt' => now()->format('d/m/Y H:i:s'),
            'totalRevenue' => $totalRevenue,
            'totalCustomers' => $totalCustomers,
            'totalBookings' => $totalBookings,
            'totalServices' => $totalServices,
            'monthlyRevenue' => $monthlyRevenue,
            'customerGrowth' => $customerGrowth,
            'servicePopularity' => $servicePopularity,
            'bookingsByStatus' => $bookingsByStatus,
            'thisMonthRevenue' => $thisMonthRevenue,
            'lastMonthRevenue' => $lastMonthRevenue,
            'revenueGrowth' => $revenueGrowth,
            'averageBookingValue' => $averageBookingValue,
            'conversionRate' => $conversionRate,
            'recentBookings' => $recentBookings,
            'categoryRevenue' => $categoryRevenue,
        ];

        if ($format === 'excel') {
            $exportFormat = request('export_format', 'excel');
            
            if ($exportFormat === 'csv') {
                // CSV Export
                $fileName = 'Laporan_Bisnis_' . now()->format('Y_m_d') . '.csv';
                $csvContent = $this->generateBusinessReportCSV($data);
                
                $headers = [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                    'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                    'Expires' => '0'
                ];
                
                return response($csvContent, 200, $headers);
            } else {
                // Excel Export
                $fileName = 'Laporan_Bisnis_' . now()->format('Y_m_d') . '.xls';
                $excelWriter = new SimpleExcelWriter($data);
                $excelContent = $excelWriter->generateExcel();
                
                $headers = [
                    'Content-Type' => 'application/vnd.ms-excel',
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                    'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                    'Expires' => '0'
                ];
                
                return response($excelContent, 200, $headers);
            }
        } else {
            $pdf = PDF::loadView('admin.reports.pdf', $data)
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'dpi' => 150, 
                    'defaultFont' => 'DejaVu Sans',
                    'fontSubstitution' => true,
                    'isUnicode' => true,
                    'isHtml5ParserEnabled' => true,
                    'isPhpEnabled' => true
                ]);
            return $pdf->download('Laporan_Bisnis_' . now()->format('Y_m_d') . '.pdf');
        }
    }
    
    private function generateBusinessReportCSV($data)
    {
        $output = fopen('php://temp', 'w');
        
        // Add BOM for UTF-8 encoding
        fwrite($output, "\xEF\xBB\xBF");
        
        // Header with company info
        fputcsv($output, ['===========================================']);
        fputcsv($output, ['🏢 YUJIN FOTO STUDIO']);
        fputcsv($output, ['📊 LAPORAN ANALISIS BISNIS']);
        fputcsv($output, ['===========================================']);
        fputcsv($output, ['📅 Dibuat pada: ' . $data['generatedAt']]);
        fputcsv($output, ['===========================================']);
        fputcsv($output, []); // Empty row
        
        // Executive Summary
        fputcsv($output, ['📈 RINGKASAN EKSEKUTIF']);
        fputcsv($output, ['===========================================']);
        fputcsv($output, ['Metrik', 'Nilai']);
        fputcsv($output, ['💰 Total Pendapatan', 'Rp ' . number_format($data['totalRevenue'], 0, ',', '.')]);
        fputcsv($output, ['👥 Total Pelanggan', number_format($data['totalCustomers'], 0, ',', '.')]);
        fputcsv($output, ['📋 Total Pemesanan', number_format($data['totalBookings'], 0, ',', '.')]);
        fputcsv($output, ['🎯 Total Layanan', number_format($data['totalServices'], 0, ',', '.')]);
        fputcsv($output, ['']);
        
        // Monthly Performance
        fputcsv($output, ['📊 PERFORMA BULANAN']);
        fputcsv($output, ['===========================================']);
        fputcsv($output, ['📅 Pendapatan Bulan Ini', 'Rp ' . number_format($data['thisMonthRevenue'], 0, ',', '.')]);
        fputcsv($output, ['📅 Pendapatan Bulan Lalu', 'Rp ' . number_format($data['lastMonthRevenue'], 0, ',', '.')]);
        fputcsv($output, ['📈 Pertumbuhan Pendapatan', $data['revenueGrowth'] . '%']);
        fputcsv($output, ['💎 Rata-rata Nilai Pemesanan', 'Rp ' . number_format($data['averageBookingValue'], 0, ',', '.')]);
        fputcsv($output, ['🎯 Tingkat Konversi', $data['conversionRate'] . '%']);
        fputcsv($output, []);
        
        // Monthly Revenue Trend
        fputcsv($output, ['📊 TREN PENDAPATAN BULANAN']);
        fputcsv($output, ['===========================================']);
        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        fputcsv($output, ['📅 Bulan', '📅 Tahun', '💰 Pendapatan']);
        foreach ($data['monthlyRevenue'] as $revenue) {
            fputcsv($output, [
                $monthNames[$revenue->month] ?? 'Bulan ' . $revenue->month,
                $revenue->year,
                'Rp ' . number_format($revenue->revenue, 0, ',', '.')
            ]);
        }
        fputcsv($output, []);
        
        // Service Popularity
        fputcsv($output, ['🏆 POPULARITAS LAYANAN']);
        fputcsv($output, ['===========================================']);
        fputcsv($output, ['🎯 Nama Layanan', '📂 Kategori', '📊 Total Pemesanan', '✅ Pemesanan Selesai', '💰 Total Pendapatan']);
        foreach ($data['servicePopularity'] as $service) {
            fputcsv($output, [
                $service->name,
                $service->category->name ?? 'Tidak Ada',
                number_format($service->bookings_count, 0, ',', '.'),
                number_format($service->completed_bookings_count, 0, ',', '.'),
                'Rp ' . number_format($service->bookings_sum_total_price ?? 0, 0, ',', '.')
            ]);
        }
        fputcsv($output, []);
        
        // Booking Status Distribution
        fputcsv($output, ['📋 DISTRIBUSI STATUS PEMESANAN']);
        fputcsv($output, ['===========================================']);
        fputcsv($output, ['🏷️ Status', '📊 Jumlah']);
        $statusTranslations = [
            'pending' => '⏳ Menunggu',
            'confirmed' => '✅ Dikonfirmasi',
            'completed' => '🎉 Selesai',
            'cancelled' => '❌ Dibatalkan',
            'rejected' => '🚫 Ditolak'
        ];
        foreach ($data['bookingsByStatus'] as $status) {
            fputcsv($output, [
                $statusTranslations[$status->status] ?? ucfirst($status->status),
                number_format($status->count, 0, ',', '.')
            ]);
        }
        fputcsv($output, []);
        
        // Recent Bookings
        fputcsv($output, ['🕐 PEMESANAN TERBARU']);
        fputcsv($output, ['===========================================']);
        fputcsv($output, ['👤 Nama Pelanggan', '🎯 Layanan', '📂 Kategori', '📅 Tanggal Pemesanan', '🏷️ Status', '💰 Total Harga']);
        foreach ($data['recentBookings'] as $booking) {
            $statusIcon = [
                'pending' => '⏳',
                'confirmed' => '✅',
                'completed' => '🎉',
                'cancelled' => '❌',
                'rejected' => '🚫'
            ];
            fputcsv($output, [
                $booking->user->name ?? 'Tidak Ada',
                $booking->service->name ?? 'Tidak Ada',
                $booking->service->category->name ?? 'Tidak Ada',
                date('d/m/Y', strtotime($booking->booking_date)),
                ($statusIcon[$booking->status] ?? '') . ' ' . ($statusTranslations[$booking->status] ?? ucfirst($booking->status)),
                'Rp ' . number_format($booking->total_price, 0, ',', '.')
            ]);
        }
        fputcsv($output, []);
        
        // Category Revenue
        fputcsv($output, ['📂 PENDAPATAN PER KATEGORI']);
        fputcsv($output, ['===========================================']);
        fputcsv($output, ['📂 Kategori', '💰 Total Pendapatan', '📊 Total Pemesanan']);
        foreach ($data['categoryRevenue'] as $category) {
            fputcsv($output, [
                $category->name,
                'Rp ' . number_format($category->total_revenue, 0, ',', '.'),
                number_format($category->total_bookings, 0, ',', '.')
            ]);
        }
        fputcsv($output, []);
        
        // Footer
        fputcsv($output, ['===========================================']);
        fputcsv($output, ['📞 Hubungi Kami:']);
        fputcsv($output, ['🏢 Yujin Foto Studio']);
        fputcsv($output, ['📧 Email: info@yujinfotostudio.com']);
        fputcsv($output, ['📱 Telepon: (021) 123-4567']);
        fputcsv($output, ['🌐 Website: www.yujinfotostudio.com']);
        fputcsv($output, ['===========================================']);
        fputcsv($output, ['© ' . date('Y') . ' Yujin Foto Studio - Semua Hak Dilindungi']);
        fputcsv($output, ['Laporan dibuat oleh Sistem Manajemen Bisnis']);
        fputcsv($output, ['===========================================']);
        
        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);
        
        return $csvContent;
    }
    
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
                ->where('bookings.created_at', '>=', now()->subMonths($months))
                ->selectRaw('MONTH(bookings.created_at) as month, YEAR(bookings.created_at) as year, COUNT(bookings.id) as quantity')
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
}
