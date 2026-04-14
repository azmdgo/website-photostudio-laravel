<?php

namespace App\Http\Controllers\Admin;

class SimpleExcelWriter
{
    private $data;
    
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function generateExcel()
    {
        // Generate a simple XML format that Excel can read
        $xml = '<?xml version="1.0"?>';
        $xml .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"';
        $xml .= ' xmlns:o="urn:schemas-microsoft-com:office:office"';
        $xml .= ' xmlns:x="urn:schemas-microsoft-com:office:excel"';
        $xml .= ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"';
        $xml .= ' xmlns:html="http://www.w3.org/TR/REC-html40">';
        
        $xml .= '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">';
        $xml .= '<Title>Laporan Bisnis Yujin Foto Studio</Title>';
        $xml .= '<Author>Yujin Foto Studio</Author>';
        $xml .= '<Created>' . date('Y-m-d\TH:i:s\Z') . '</Created>';
        $xml .= '</DocumentProperties>';
        
        $xml .= '<Styles>';
        $xml .= '<Style ss:ID="Header">';
        $xml .= '<Font ss:Bold="1" ss:Size="14" ss:Color="#FFFFFF"/>';
        $xml .= '<Interior ss:Color="#4F46E5" ss:Pattern="Solid"/>';
        $xml .= '<Alignment ss:Horizontal="Center" ss:Vertical="Center"/>';
        $xml .= '</Style>';
        
        $xml .= '<Style ss:ID="SectionHeader">';
        $xml .= '<Font ss:Bold="1" ss:Size="12" ss:Color="#4F46E5"/>';
        $xml .= '<Interior ss:Color="#E0E7FF" ss:Pattern="Solid"/>';
        $xml .= '<Alignment ss:Horizontal="Left" ss:Vertical="Center"/>';
        $xml .= '</Style>';
        
        $xml .= '<Style ss:ID="Currency">';
        $xml .= '<NumberFormat ss:Format="&quot;Rp &quot;#,##0"/>';
        $xml .= '</Style>';
        
        $xml .= '<Style ss:ID="Number">';
        $xml .= '<NumberFormat ss:Format="#,##0"/>';
        $xml .= '</Style>';
        
        $xml .= '<Style ss:ID="Date">';
        $xml .= '<NumberFormat ss:Format="dd/mm/yyyy"/>';
        $xml .= '</Style>';
        $xml .= '</Styles>';
        
        $xml .= '<Worksheet ss:Name="Laporan Bisnis">';
        $xml .= '<Table>';
        
        // Header
        $xml .= '<Row ss:Height="25">';
        $xml .= '<Cell ss:StyleID="Header" ss:MergeAcross="5">';
        $xml .= '<Data ss:Type="String">🏢 YUJIN FOTO STUDIO - LAPORAN ANALISIS BISNIS</Data>';
        $xml .= '</Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row ss:Height="20">';
        $xml .= '<Cell ss:MergeAcross="5">';
        $xml .= '<Data ss:Type="String">📅 Dibuat pada: ' . $this->data['generatedAt'] . '</Data>';
        $xml .= '</Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row/>';
        
        // Executive Summary
        $xml .= '<Row>';
        $xml .= '<Cell ss:StyleID="SectionHeader" ss:MergeAcross="1">';
        $xml .= '<Data ss:Type="String">📈 RINGKASAN EKSEKUTIF</Data>';
        $xml .= '</Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">💰 Total Pendapatan</Data></Cell>';
        $xml .= '<Cell ss:StyleID="Currency"><Data ss:Type="Number">' . $this->data['totalRevenue'] . '</Data></Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">👥 Total Pelanggan</Data></Cell>';
        $xml .= '<Cell ss:StyleID="Number"><Data ss:Type="Number">' . $this->data['totalCustomers'] . '</Data></Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">📋 Total Pemesanan</Data></Cell>';
        $xml .= '<Cell ss:StyleID="Number"><Data ss:Type="Number">' . $this->data['totalBookings'] . '</Data></Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">🎯 Total Layanan</Data></Cell>';
        $xml .= '<Cell ss:StyleID="Number"><Data ss:Type="Number">' . $this->data['totalServices'] . '</Data></Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row/>';
        
        // Monthly Performance
        $xml .= '<Row>';
        $xml .= '<Cell ss:StyleID="SectionHeader" ss:MergeAcross="1">';
        $xml .= '<Data ss:Type="String">📊 PERFORMA BULANAN</Data>';
        $xml .= '</Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">📅 Pendapatan Bulan Ini</Data></Cell>';
        $xml .= '<Cell ss:StyleID="Currency"><Data ss:Type="Number">' . $this->data['thisMonthRevenue'] . '</Data></Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">📅 Pendapatan Bulan Lalu</Data></Cell>';
        $xml .= '<Cell ss:StyleID="Currency"><Data ss:Type="Number">' . $this->data['lastMonthRevenue'] . '</Data></Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">📈 Pertumbuhan Pendapatan</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">' . $this->data['revenueGrowth'] . '%</Data></Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">💎 Rata-rata Nilai Pemesanan</Data></Cell>';
        $xml .= '<Cell ss:StyleID="Currency"><Data ss:Type="Number">' . $this->data['averageBookingValue'] . '</Data></Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">🎯 Tingkat Konversi</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">' . $this->data['conversionRate'] . '%</Data></Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row/>';
        
        // Monthly Revenue Trend
        $xml .= '<Row>';
        $xml .= '<Cell ss:StyleID="SectionHeader" ss:MergeAcross="2">';
        $xml .= '<Data ss:Type="String">📊 TREN PENDAPATAN BULANAN</Data>';
        $xml .= '</Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">📅 Bulan</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">📅 Tahun</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">💰 Pendapatan</Data></Cell>';
        $xml .= '</Row>';
        
        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        foreach ($this->data['monthlyRevenue'] as $revenue) {
            $xml .= '<Row>';
            $xml .= '<Cell><Data ss:Type="String">' . ($monthNames[$revenue->month] ?? 'Bulan ' . $revenue->month) . '</Data></Cell>';
            $xml .= '<Cell><Data ss:Type="Number">' . $revenue->year . '</Data></Cell>';
            $xml .= '<Cell ss:StyleID="Currency"><Data ss:Type="Number">' . $revenue->revenue . '</Data></Cell>';
            $xml .= '</Row>';
        }
        
        $xml .= '<Row/>';
        
        // Service Popularity
        $xml .= '<Row>';
        $xml .= '<Cell ss:StyleID="SectionHeader" ss:MergeAcross="4">';
        $xml .= '<Data ss:Type="String">🏆 POPULARITAS LAYANAN</Data>';
        $xml .= '</Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">🎯 Nama Layanan</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">📂 Kategori</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">📊 Total Pemesanan</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">✅ Pemesanan Selesai</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">💰 Total Pendapatan</Data></Cell>';
        $xml .= '</Row>';
        
        foreach ($this->data['servicePopularity'] as $service) {
            $xml .= '<Row>';
            $xml .= '<Cell><Data ss:Type="String">' . htmlspecialchars($service->name) . '</Data></Cell>';
            $xml .= '<Cell><Data ss:Type="String">' . htmlspecialchars($service->category->name ?? 'Tidak Ada') . '</Data></Cell>';
            $xml .= '<Cell ss:StyleID="Number"><Data ss:Type="Number">' . $service->bookings_count . '</Data></Cell>';
            $xml .= '<Cell ss:StyleID="Number"><Data ss:Type="Number">' . $service->completed_bookings_count . '</Data></Cell>';
            $xml .= '<Cell ss:StyleID="Currency"><Data ss:Type="Number">' . ($service->bookings_sum_total_price ?? 0) . '</Data></Cell>';
            $xml .= '</Row>';
        }
        
        $xml .= '<Row/>';
        
        // Recent Bookings
        $xml .= '<Row>';
        $xml .= '<Cell ss:StyleID="SectionHeader" ss:MergeAcross="5">';
        $xml .= '<Data ss:Type="String">🕐 PEMESANAN TERBARU</Data>';
        $xml .= '</Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">👤 Nama Pelanggan</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">🎯 Layanan</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">📂 Kategori</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">📅 Tanggal Pemesanan</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">🏷️ Status</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">💰 Total Harga</Data></Cell>';
        $xml .= '</Row>';
        
        $statusTranslations = [
            'pending' => '⏳ Menunggu',
            'confirmed' => '✅ Dikonfirmasi',
            'completed' => '🎉 Selesai',
            'cancelled' => '❌ Dibatalkan',
            'rejected' => '🚫 Ditolak'
        ];
        
        foreach ($this->data['recentBookings'] as $booking) {
            $xml .= '<Row>';
            $xml .= '<Cell><Data ss:Type="String">' . htmlspecialchars($booking->user->name ?? 'Tidak Ada') . '</Data></Cell>';
            $xml .= '<Cell><Data ss:Type="String">' . htmlspecialchars($booking->service->name ?? 'Tidak Ada') . '</Data></Cell>';
            $xml .= '<Cell><Data ss:Type="String">' . htmlspecialchars($booking->service->category->name ?? 'Tidak Ada') . '</Data></Cell>';
            $xml .= '<Cell ss:StyleID="Date"><Data ss:Type="String">' . date('d/m/Y', strtotime($booking->booking_date)) . '</Data></Cell>';
            $xml .= '<Cell><Data ss:Type="String">' . ($statusTranslations[$booking->status] ?? ucfirst($booking->status)) . '</Data></Cell>';
            $xml .= '<Cell ss:StyleID="Currency"><Data ss:Type="Number">' . $booking->total_price . '</Data></Cell>';
            $xml .= '</Row>';
        }
        
        $xml .= '</Table>';
        $xml .= '</Worksheet>';
        
        // Add Chart Worksheet
        $xml .= '<Worksheet ss:Name="Chart Data">';
        $xml .= '<Table>';
        
        // Chart Title
        $xml .= '<Row ss:Height="30">';
        $xml .= '<Cell ss:StyleID="Header" ss:MergeAcross="3">';
        $xml .= '<Data ss:Type="String">📊 GRAFIK ANALISIS BISNIS</Data>';
        $xml .= '</Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row/>';
        
        // Revenue Chart Data
        $xml .= '<Row>';
        $xml .= '<Cell ss:StyleID="SectionHeader" ss:MergeAcross="3">';
        $xml .= '<Data ss:Type="String">📈 GRAFIK PENDAPATAN BULANAN</Data>';
        $xml .= '</Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">Bulan</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">Tahun</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">Pendapatan</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">Tren</Data></Cell>';
        $xml .= '</Row>';
        
        $previousRevenue = 0;
        foreach ($this->data['monthlyRevenue'] as $revenue) {
            $trend = $previousRevenue > 0 ? 
                ($revenue->revenue > $previousRevenue ? '↗️ Naik' : 
                ($revenue->revenue < $previousRevenue ? '↘️ Turun' : '→ Stabil')) : 
                '→ Baseline';
            
            $xml .= '<Row>';
            $xml .= '<Cell><Data ss:Type="String">' . ($monthNames[$revenue->month] ?? 'Bulan ' . $revenue->month) . '</Data></Cell>';
            $xml .= '<Cell><Data ss:Type="Number">' . $revenue->year . '</Data></Cell>';
            $xml .= '<Cell ss:StyleID="Currency"><Data ss:Type="Number">' . $revenue->revenue . '</Data></Cell>';
            $xml .= '<Cell><Data ss:Type="String">' . $trend . '</Data></Cell>';
            $xml .= '</Row>';
            
            $previousRevenue = $revenue->revenue;
        }
        
        $xml .= '<Row/>';
        
        // Service Performance Chart
        $xml .= '<Row>';
        $xml .= '<Cell ss:StyleID="SectionHeader" ss:MergeAcross="4">';
        $xml .= '<Data ss:Type="String">🎯 GRAFIK PERFORMA LAYANAN</Data>';
        $xml .= '</Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">Layanan</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">Total Booking</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">Tingkat Penyelesaian</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">Total Pendapatan</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">Performance Rating</Data></Cell>';
        $xml .= '</Row>';
        
        foreach ($this->data['servicePopularity'] as $service) {
            $completionRate = $service->bookings_count > 0 ? 
                round(($service->completed_bookings_count / $service->bookings_count) * 100, 1) : 0;
            
            $performanceRating = $completionRate >= 80 ? '⭐⭐⭐⭐⭐ Excellent' : 
                ($completionRate >= 60 ? '⭐⭐⭐⭐ Good' : 
                ($completionRate >= 40 ? '⭐⭐⭐ Average' : 
                ($completionRate >= 20 ? '⭐⭐ Poor' : '⭐ Very Poor')));
            
            $xml .= '<Row>';
            $xml .= '<Cell><Data ss:Type="String">' . htmlspecialchars($service->name) . '</Data></Cell>';
            $xml .= '<Cell ss:StyleID="Number"><Data ss:Type="Number">' . $service->bookings_count . '</Data></Cell>';
            $xml .= '<Cell><Data ss:Type="String">' . $completionRate . '%</Data></Cell>';
            $xml .= '<Cell ss:StyleID="Currency"><Data ss:Type="Number">' . ($service->bookings_sum_total_price ?? 0) . '</Data></Cell>';
            $xml .= '<Cell><Data ss:Type="String">' . $performanceRating . '</Data></Cell>';
            $xml .= '</Row>';
        }
        
        $xml .= '<Row/>';
        
        // Booking Status Distribution Chart
        $xml .= '<Row>';
        $xml .= '<Cell ss:StyleID="SectionHeader" ss:MergeAcross="3">';
        $xml .= '<Data ss:Type="String">📊 DISTRIBUSI STATUS BOOKING</Data>';
        $xml .= '</Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">Status</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">Jumlah</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">Persentase</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">Visual</Data></Cell>';
        $xml .= '</Row>';
        
        $totalBookings = collect($this->data['bookingsByStatus'])->sum('count');
        $statusIcons = [
            'pending' => '⏳',
            'confirmed' => '✅',
            'completed' => '🎉',
            'cancelled' => '❌',
            'rejected' => '🚫'
        ];
        
        $statusTranslations = [
            'pending' => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'rejected' => 'Ditolak'
        ];
        
        foreach ($this->data['bookingsByStatus'] as $status) {
            $percentage = $totalBookings > 0 ? round(($status->count / $totalBookings) * 100, 1) : 0;
            $visualBar = str_repeat('█', intval($percentage / 5)); // Visual bar representation
            
            $xml .= '<Row>';
            $xml .= '<Cell><Data ss:Type="String">' . 
                ($statusIcons[$status->status] ?? '') . ' ' . 
                ($statusTranslations[$status->status] ?? ucfirst($status->status)) . 
                '</Data></Cell>';
            $xml .= '<Cell ss:StyleID="Number"><Data ss:Type="Number">' . $status->count . '</Data></Cell>';
            $xml .= '<Cell><Data ss:Type="String">' . $percentage . '%</Data></Cell>';
            $xml .= '<Cell><Data ss:Type="String">' . $visualBar . '</Data></Cell>';
            $xml .= '</Row>';
        }
        
        $xml .= '<Row/>';
        
        // Performance Summary
        $xml .= '<Row>';
        $xml .= '<Cell ss:StyleID="SectionHeader" ss:MergeAcross="1">';
        $xml .= '<Data ss:Type="String">🎯 RINGKASAN PERFORMA</Data>';
        $xml .= '</Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">📈 Tingkat Pertumbuhan</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">' . 
            ($this->data['revenueGrowth'] > 0 ? '🟢 Positif' : 
            ($this->data['revenueGrowth'] < 0 ? '🔴 Negatif' : '🟡 Stabil')) . 
            ' (' . $this->data['revenueGrowth'] . '%)</Data></Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">🎯 Tingkat Konversi</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">' . 
            ($this->data['conversionRate'] >= 70 ? '🟢 Excellent' : 
            ($this->data['conversionRate'] >= 50 ? '🟡 Good' : 
            ($this->data['conversionRate'] >= 30 ? '🟠 Average' : '🔴 Poor'))) . 
            ' (' . $this->data['conversionRate'] . '%)</Data></Cell>';
        $xml .= '</Row>';
        
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="String">💰 Status Bisnis</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">' . 
            ($this->data['totalRevenue'] > 50000000 ? '🟢 Sangat Baik' : 
            ($this->data['totalRevenue'] > 20000000 ? '🟡 Baik' : 
            ($this->data['totalRevenue'] > 5000000 ? '🟠 Cukup' : '🔴 Perlu Peningkatan'))) . 
            '</Data></Cell>';
        $xml .= '</Row>';
        
        $xml .= '</Table>';
        $xml .= '</Worksheet>';
        $xml .= '</Workbook>';
        
        return $xml;
    }
}
