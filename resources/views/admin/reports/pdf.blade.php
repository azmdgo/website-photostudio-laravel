<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reportTitle }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            color: #000;
            line-height: 1.5;
            background: #ffffff;
            font-size: 12px;
        }
        
        /* Simple Letterhead */
        .letterhead {
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
            padding-bottom: 15px;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #000;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }
        
        .company-tagline {
            font-size: 12px;
            color: #666;
            margin: 0 0 10px 0;
        }
        
        .company-details {
            font-size: 9px;
            color: #333;
            line-height: 1.2;
            margin-bottom: 10px;
        }
        
        .document-title {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin: 10px 0 5px 0;
            text-transform: uppercase;
        }
        
        .document-info {
            font-size: 11px;
            color: #666;
        }
        
        /* Simple Summary Cards */
        .summary-section {
            margin-bottom: 20px;
        }
        
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .summary-table td {
            width: 25%;
            background: #f9f9f9;
            padding: 12px;
            text-align: center;
            border: 1px solid #ccc;
            vertical-align: top;
        }
        
        .summary-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .summary-value {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .summary-growth {
            font-size: 10px;
            color: #666;
        }
        /* Section Styles for Landscape */
        .section {
            margin-bottom: 20px;
            background: white;
            border: 1px solid #ccc;
        }
        
        .section-header {
            background: #f0f0f0;
            color: #000;
            padding: 8px 12px;
            margin: 0;
            border-bottom: 1px solid #ccc;
        }
        
        .section-header h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .section-content {
            padding: 12px;
        }
        
        /* Professional Table Styling */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            font-size: 11px;
            border: 1px solid #000;
        }
        
        .table th {
            background: #e0e0e0;
            color: #000;
            padding: 10px 8px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #000;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        .table td {
            padding: 8px;
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            font-size: 11px;
        }
        
        .table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        /* Status Badges */
        .status-badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
            border: 1px solid #000;
        }
        
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d1ecf1; color: #0c5460; }
        .status-in_progress { background: #cfe2ff; color: #084298; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        
        /* Metric Rows for Financial Section */
        .metric-row {
            width: 100%;
            margin-bottom: 6px;
            border-bottom: 1px solid #ddd;
        }
        
        .metric-label {
            width: 60%;
            float: left;
            padding: 6px 0;
            font-weight: bold;
            color: #000;
        }
        
        .metric-value {
            width: 40%;
            float: right;
            padding: 6px 0;
            text-align: right;
            font-weight: bold;
            color: #000;
        }
        
        
        .growth-positive { color: #155724; }
        .growth-negative { color: #721c24; }
        
        /* Highlight Box */
        .highlight-box {
            background: #f9f9f9;
            border: 1px solid #ccc;
            padding: 12px;
            margin: 10px 0;
        }
        
        /* Signature Section */
        .signature-section {
            margin-top: 40px;
            text-align: right;
            width: 100%;
        }
        
        .signature-box {
            width: 200px;
            float: right;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .signature-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 60px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }
        
        .signature-name {
            font-size: 12px;
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        
        /* Footer */
        .footer {
            margin-top: 30px;
            padding: 15px;
            background: #f0f0f0;
            text-align: center;
            border-top: 2px solid #000;
            font-size: 9px;
            clear: both;
        }
        
        .footer .company-name {
            font-size: 12px;
            font-weight: bold;
            color: #000;
            margin: 0 0 8px 0;
        }
        
        .footer .disclaimer {
            color: #666;
            font-size: 8px;
            line-height: 1.3;
        }
        
        /* Page Break */
        .page-break {
            page-break-before: always;
        }
        
        .avoid-break {
            page-break-inside: avoid;
        }
        
        .break-after {
            page-break-after: always;
        }
        
        /* Adjust section margins for better page flow */
        .section {
            page-break-inside: avoid;
            margin-bottom: 15px;
        }
        
        .section.large-content {
            page-break-inside: auto;
        }
    </style>
</head>
<body>
    <!-- Simple Letterhead -->
    <div class="letterhead">
        <h1 class="company-name">YUJIN FOTO STUDIO</h1>
        <p class="company-tagline">Professional Photography Services</p>
        <div class="company-details">
            <strong>Alamat:</strong> Jl. Lintas Sumatera No.135, Sukodadi, Kec. Sukarami, Kota Palembang, Sumatera Selatan 30154<br>
            <strong>No. HP:</strong> +62 081-0822-09109 | <strong>Email:</strong> info@yujinfotostudio.com<br>
            <strong>Website:</strong> www.yujinfotostudio.com
        </div>
        <h2 class="document-title">{{ $reportTitle }}</h2>
        <div class="document-info">
            Tanggal: {{ $generatedAt }} | No. Dokumen: RPT-{{ date('Ymd-His') }}
        </div>
    </div>

    <!-- Executive Summary -->
    <div class="summary-section">
        <table class="summary-table">
            <tr>
                <td>
                    <div class="summary-title">Total Pendapatan</div>
                    <div class="summary-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    <div class="summary-growth">{{ $revenueGrowth >= 0 ? 'Naik' : 'Turun' }} {{ abs($revenueGrowth) }}% dari bulan lalu</div>
                </td>
                <td>
                    <div class="summary-title">Total Pelanggan</div>
                    <div class="summary-value">{{ number_format($totalCustomers, 0, ',', '.') }}</div>
                    <div class="summary-growth">Target: 1000 pelanggan</div>
                </td>
                <td>
                    <div class="summary-title">Total Booking</div>
                    <div class="summary-value">{{ number_format($totalBookings, 0, ',', '.') }}</div>
                    <div class="summary-growth">Konversi: {{ $conversionRate }}%</div>
                </td>
                <td>
                    <div class="summary-title">Total Layanan</div>
                    <div class="summary-value">{{ number_format($totalServices, 0, ',', '.') }}</div>
                    <div class="summary-growth">Portofolio lengkap</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Financial Performance Section -->
    <div class="section avoid-break">
        <div class="section-header">
            <h2>Kinerja Keuangan</h2>
        </div>
        <div class="section-content">
            <table class="table">
                <tr>
                    <td>Pendapatan Bulan Ini</td>
                    <td>Rp {{ number_format($thisMonthRevenue, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Pendapatan Bulan Lalu</td>
                    <td>Rp {{ number_format($lastMonthRevenue, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Pertumbuhan Pendapatan</td>
                    <td>{{ $revenueGrowth >= 0 ? '+' : '' }}{{ $revenueGrowth }}%</td>
                </tr>
                <tr>
                    <td>Rata-rata Nilai Booking</td>
                    <td>Rp {{ number_format($averageBookingValue, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Tingkat Konversi</td>
                    <td>{{ $conversionRate }}%</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="page-break"></div>
    
        <!-- Service Popularity Section -->
        <div class="section large-content">
            <div class="section-header">
                <h2>Popularitas Layanan</h2>
            </div>
            <div class="section-content">
        <table class="table">
            <thead>
                <tr>
                    <th>Layanan</th>
                    <th>Total Booking</th>
                    <th>Booking Selesai</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicePopularity as $service)
                <tr>
                    <td>{{ $service->name }}</td>
                    <td>{{ $service->bookings_count }}</td>
                    <td>{{ $service->completed_bookings_count }}</td>
                    <td>Rp {{ number_format($service->bookings_sum_total_price ?? 0, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
            </div>
        </div>

        <!-- Booking Status Distribution -->
        <div class="section avoid-break">
            <div class="section-header">
                <h2>Distribusi Status Booking</h2>
            </div>
            <div class="section-content">
        <table class="table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Jumlah</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalBookingsByStatus = $bookingsByStatus->sum('count');
                @endphp
                @foreach($bookingsByStatus as $status)
                <tr>
                    <td>
                        <span class="status-badge status-{{ $status->status }}">
                            @switch($status->status)
                                @case('pending')
                                    Menunggu
                                    @break
                                @case('confirmed')
                                    Dikonfirmasi
                                    @break
                                @case('in_progress')
                                    Sedang Berlangsung
                                    @break
                                @case('completed')
                                    Selesai
                                    @break
                                @case('cancelled')
                                    Dibatalkan
                                    @break
                                @default
                                    {{ ucfirst($status->status) }}
                            @endswitch
                        </span>
                    </td>
                    <td>{{ $status->count }}</td>
                    <td>{{ $totalBookingsByStatus > 0 ? round(($status->count / $totalBookingsByStatus) * 100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Category Revenue Section -->
    <div class="section avoid-break">
        <div class="section-header">
            <h2>Pendapatan per Kategori Layanan</h2>
        </div>
        <div class="section-content">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Total Booking</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categoryRevenue as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->total_bookings }}</td>
                        <td>Rp {{ number_format($category->total_revenue, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="page-break"></div>
    
    <!-- Recent Bookings -->
    <div class="section large-content">
        <div class="section-header">
            <h2>Booking Terbaru</h2>
        </div>
        <div class="section-content">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentBookings as $booking)
                    <tr>
                        <td>{{ $booking->booking_date->format('d/m/Y') }}</td>
                        <td>{{ $booking->user->name }}</td>
                        <td>{{ $booking->service->name }}</td>
                        <td>
                            <span class="status-badge status-{{ $booking->status }}">
                                @switch($booking->status)
                                    @case('pending')
                                        Menunggu
                                        @break
                                    @case('confirmed')
                                        Dikonfirmasi
                                        @break
                                    @case('in_progress')
                                        Sedang Berlangsung
                                        @break
                                    @case('completed')
                                        Selesai
                                        @break
                                    @case('cancelled')
                                        Dibatalkan
                                        @break
                                    @default
                                        {{ ucfirst($booking->status) }}
                                @endswitch
                            </span>
                        </td>
                        <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Monthly Revenue Chart Placeholder -->
    <div class="section">
        <h2>Tren Pendapatan Bulanan (12 Bulan Terakhir)</h2>
        <div class="chart-placeholder">
            <p>Grafik Pendapatan Bulanan</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlyRevenue as $revenue)
                    <tr>
                        <td>{{ $revenue->month }}/{{ $revenue->year }}</td>
                        <td>Rp {{ number_format($revenue->revenue, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Customer Growth Chart Placeholder -->
    <div class="section">
        <h2>Pertumbuhan Pelanggan (12 Bulan Terakhir)</h2>
        <div class="chart-placeholder">
            <p>Grafik Pertumbuhan Pelanggan</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Pelanggan Baru</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customerGrowth as $growth)
                    <tr>
                        <td>{{ $growth->month }}/{{ $growth->year }}</td>
                        <td>{{ $growth->count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-title">Palembang, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</div>
            <div class="signature-name">Pemilik Usaha</div>
        </div>
    </div>

    <div class="footer">
        <div class="company-info">
            <p class="company-name">YUJIN FOTO STUDIO</p>
            <p>Jl. Lintas Sumatera No.135, Sukodadi, Kec. Sukarami</p>
            <p>Kota Palembang, Sumatera Selatan 30154</p>
            <p>Telp: +62 081-0822-09109 | Email: info@yujinfotostudio.com</p>
        </div>
        <p class="disclaimer">
            © {{ date('Y') }} Yujin Foto Studio. Laporan ini dibuat secara otomatis pada {{ $generatedAt }}.
            <br>Dokumen ini bersifat rahasia dan hanya untuk keperluan internal perusahaan.
            <br>Untuk informasi lebih lanjut, hubungi manajemen studio.
        </p>
    </div>
</body>
</html>
