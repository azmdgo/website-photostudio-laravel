<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $reportTitle }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f8f9fa;
            color: #333;
        }
        .report-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .report-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .report-header p {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .studio-info {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-left: 4px solid #667eea;
        }
        .studio-info h2 {
            color: #667eea;
            margin: 0 0 15px 0;
            font-size: 20px;
        }
        .studio-info p {
            margin: 5px 0;
            color: #666;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #e9ecef;
            padding: 12px 15px;
            text-align: left;
        }
        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 12px;
        }
        td {
            font-size: 14px;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #e3f2fd;
        }
        .section-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            padding: 15px 20px;
            margin: 30px 0 0 0;
            border-radius: 8px 8px 0 0;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .summary {
            background: white;
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .summary h2 {
            color: #667eea;
            margin: 0 0 20px 0;
            font-size: 22px;
            text-align: center;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .summary-item {
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px solid #e9ecef;
        }
        .summary-item h3 {
            color: #667eea;
            margin: 0 0 8px 0;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .summary-item .value {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin: 0;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-confirmed {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .status-in_progress {
            background-color: #cfe2ff;
            color: #084298;
        }
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .footer h3 {
            color: #667eea;
            margin: 0 0 10px 0;
        }
        .footer p {
            color: #666;
            margin: 5px 0;
            font-size: 14px;
        }
        .highlight {
            background: linear-gradient(135deg, #667eea20, #764ba220);
            border: 1px solid #667eea40;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="report-header">
        <h1>📊 {{ $reportTitle }}</h1>
        <p>Laporan Komprehensif Kinerja Bisnis | 📅 {{ $generatedAt }}</p>
    </div>
    
    <div class="studio-info">
        <h2>📸 Yujin Foto Studio</h2>
        <p><strong>📍 Alamat:</strong> Jl. Fotografi No. 123, Kota Kreatif</p>
        <p><strong>📞 Telepon:</strong> (021) 1234-5678 | <strong>✉️ Email:</strong> info@yujinfoto.com</p>
        <p><strong>🌐 Website:</strong> www.yujinfotostudio.com</p>
    </div>
    
    <div class="summary">
        <h2>📊 Ringkasan Eksekutif</h2>
        <div class="highlight">
            <p style="text-align: center; font-size: 16px; color: #667eea; margin-bottom: 20px;">
                <strong>Periode Laporan:</strong> {{ now()->subMonths(12)->format('M Y') }} - {{ now()->format('M Y') }}
            </p>
        </div>
        <table>
            <tr>
                <th style="width: 50%;">📈 Metrik Kinerja</th>
                <th style="width: 30%;">Nilai</th>
                <th style="width: 20%;">Status</th>
            </tr>
            <tr>
                <td><strong>💰 Total Pendapatan</strong></td>
                <td><strong>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong></td>
                <td style="color: #28a745;">✅ Excellent</td>
            </tr>
            <tr>
                <td>👥 Total Pelanggan</td>
                <td>{{ number_format($totalCustomers, 0, ',', '.') }} orang</td>
                <td style="color: #17a2b8;">📊 Growing</td>
            </tr>
            <tr>
                <td>📅 Total Booking</td>
                <td>{{ number_format($totalBookings, 0, ',', '.') }} order</td>
                <td style="color: #ffc107;">⚡ Active</td>
            </tr>
            <tr>
                <td>🎨 Total Layanan</td>
                <td>{{ number_format($totalServices, 0, ',', '.') }} service</td>
                <td style="color: #6f42c1;">🎯 Complete</td>
            </tr>
            <tr style="background: #e8f4f8;">
                <td><strong>📊 Pendapatan Bulan Ini</strong></td>
                <td><strong>Rp {{ number_format($thisMonthRevenue, 0, ',', '.') }}</strong></td>
                <td style="color: {{ $revenueGrowth >= 0 ? '#28a745' : '#dc3545' }};">{{ $revenueGrowth >= 0 ? '📈 UP' : '📉 DOWN' }}</td>
            </tr>
            <tr>
                <td>📋 Pendapatan Bulan Lalu</td>
                <td>Rp {{ number_format($lastMonthRevenue, 0, ',', '.') }}</td>
                <td style="color: #6c757d;">📝 Reference</td>
            </tr>
            <tr style="background: {{ $revenueGrowth >= 0 ? '#d4edda' : '#f8d7da' }};">
                <td><strong>🎯 Pertumbuhan Pendapatan</strong></td>
                <td><strong>{{ $revenueGrowth >= 0 ? '+' : '' }}{{ $revenueGrowth }}%</strong></td>
                <td style="color: {{ $revenueGrowth >= 0 ? '#28a745' : '#dc3545' }};">{{ $revenueGrowth >= 0 ? '🚀 Positive' : '⚠️ Negative' }}</td>
            </tr>
            <tr>
                <td>💳 Rata-rata Nilai Booking</td>
                <td>Rp {{ number_format($averageBookingValue, 0, ',', '.') }}</td>
                <td style="color: #fd7e14;">💎 Premium</td>
            </tr>
            <tr>
                <td>🎯 Tingkat Konversi</td>
                <td>{{ $conversionRate }}%</td>
                <td style="color: {{ $conversionRate >= 50 ? '#28a745' : '#ffc107' }};">{{ $conversionRate >= 50 ? '⭐ Excellent' : '🔥 Good' }}</td>
            </tr>
        </table>
    </div>
    
    <div class="section-title">🎨 Popularitas Layanan</div>
    <table>
        <thead>
            <tr>
                <th style="width: 40%;">Layanan</th>
                <th style="width: 20%;">Total Booking</th>
                <th style="width: 20%;">Booking Selesai</th>
                <th style="width: 20%;">Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($servicePopularity as $service)
            <tr>
                <td>🎨 {{ $service->name }}</td>
                <td>{{ $service->bookings_count }} order</td>
                <td>{{ $service->completed_bookings_count }} selesai</td>
                <td>Rp {{ number_format($service->bookings_sum_total_price ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="section-title">Distribusi Status Booking</div>
    <table>
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
                </td>
                <td>{{ $status->count }}</td>
                <td>{{ $totalBookingsByStatus > 0 ? round(($status->count / $totalBookingsByStatus) * 100, 1) : 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="section-title">Pendapatan per Kategori Layanan</div>
    <table>
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
    
    <div class="section-title">Booking Terbaru</div>
    <table>
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
                </td>
                <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="section-title">Tren Pendapatan Bulanan (12 Bulan Terakhir)</div>
    <table>
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
    
    <div class="section-title">📈 Pertumbuhan Pelanggan (12 Bulan Terakhir)</div>
    <table>
        <thead>
            <tr>
                <th style="width: 50%;">Bulan</th>
                <th style="width: 30%;">Pelanggan Baru</th>
                <th style="width: 20%;">Trend</th>
            </tr>
        </thead>
        <tbody>
            @php
                $previousCount = 0;
            @endphp
            @foreach($customerGrowth as $index => $growth)
            <tr>
                <td>📅 {{ $growth->month }}/{{ $growth->year }}</td>
                <td>{{ $growth->count }} orang</td>
                <td style="color: {{ $growth->count > $previousCount ? '#28a745' : ($growth->count < $previousCount ? '#dc3545' : '#6c757d') }};">
                    {{ $growth->count > $previousCount ? '📈 UP' : ($growth->count < $previousCount ? '📉 DOWN' : '➡️ STABLE') }}
                </td>
                @php
                    $previousCount = $growth->count;
                @endphp
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Charts Analysis Section -->
    <div class="section-title">📉 Analisis Grafik & Visualisasi</div>
    <div class="summary">
        <h2>📊 Dashboard Analytics Summary</h2>
        <div class="highlight">
            <p><strong>Grafik yang tersedia di Dashboard Business Intelligence:</strong></p>
            <ul style="margin: 15px 0; padding-left: 30px;">
                <li>📈 <strong>Revenue Trend Chart</strong> - Menampilkan tren pendapatan bulanan</li>
                <li>📅 <strong>Customer Growth Chart</strong> - Menampilkan pertumbuhan pelanggan baru</li>
                <li>🎨 <strong>Service Category Chart</strong> - Menampilkan perbandingan kategori layanan</li>
                <li>📊 <strong>Booking Status Distribution</strong> - Menampilkan distribusi status booking</li>
                <li>🕰 <strong>Service Popularity Chart</strong> - Menampilkan popularitas layanan</li>
            </ul>
        </div>
    </div>
    
    <!-- Revenue Analysis Chart Data -->
    <div class="section-title">💰 Data Analisis Pendapatan</div>
    <table>
        <thead>
            <tr>
                <th style="width: 25%;">Bulan</th>
                <th style="width: 25%;">Pendapatan</th>
                <th style="width: 25%;">Persentase dari Total</th>
                <th style="width: 25%;">Growth Rate</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalRevenue = $monthlyRevenue->sum('revenue');
                $previousRevenue = 0;
            @endphp
            @foreach($monthlyRevenue as $index => $revenue)
            @php
                $percentage = $totalRevenue > 0 ? round(($revenue->revenue / $totalRevenue) * 100, 2) : 0;
                $growthRate = $previousRevenue > 0 ? round((($revenue->revenue - $previousRevenue) / $previousRevenue) * 100, 2) : 0;
            @endphp
            <tr>
                <td>📅 {{ $revenue->month }}/{{ $revenue->year }}</td>
                <td>Rp {{ number_format($revenue->revenue, 0, ',', '.') }}</td>
                <td>{{ $percentage }}%</td>
                <td style="color: {{ $growthRate > 0 ? '#28a745' : ($growthRate < 0 ? '#dc3545' : '#6c757d') }};">
                    {{ $growthRate > 0 ? '+' : '' }}{{ $growthRate }}%
                </td>
                @php
                    $previousRevenue = $revenue->revenue;
                @endphp
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Booking Status Analysis -->
    <div class="section-title">📊 Analisis Status Booking</div>
    <table>
        <thead>
            <tr>
                <th style="width: 40%;">Status</th>
                <th style="width: 20%;">Jumlah</th>
                <th style="width: 20%;">Persentase</th>
                <th style="width: 20%;">Insight</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalBookingsByStatus = $bookingsByStatus->sum('count');
            @endphp
            @foreach($bookingsByStatus as $status)
            @php
                $percentage = $totalBookingsByStatus > 0 ? round(($status->count / $totalBookingsByStatus) * 100, 1) : 0;
            @endphp
            <tr>
                <td>
                    <span class="status-badge status-{{ $status->status }}">
                        @switch($status->status)
                            @case('pending')
                                ⏳ Menunggu
                                @break
                            @case('confirmed')
                                ✅ Dikonfirmasi
                                @break
                            @case('in_progress')
                                ♾️ Sedang Berlangsung
                                @break
                            @case('completed')
                                ✓ Selesai
                                @break
                            @case('cancelled')
                                ❌ Dibatalkan
                                @break
                            @default
                                {{ ucfirst($status->status) }}
                        @endswitch
                    </span>
                </td>
                <td>{{ $status->count }} order</td>
                <td>{{ $percentage }}%</td>
                <td>
                    @if($status->status == 'completed')
                        🎆 Sukses!
                    @elseif($status->status == 'pending')
                        ⏰ Perlu Tindak Lanjut
                    @elseif($status->status == 'cancelled')
                        ⚠️ Perlu Analisis
                    @else
                        📊 Normal
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <h3>🏢 Yujin Foto Studio</h3>
        <p><strong>Laporan Analisis Bisnis</strong></p>
        <p>📅 Periode: {{ now()->subMonths(12)->format('M Y') }} - {{ now()->format('M Y') }}</p>
        <p>⏰ Dibuat pada: {{ $generatedAt }}</p>
        <div style="margin-top: 20px; padding-top: 15px; border-top: 2px solid #667eea;">
            <p><strong>📞 Kontak:</strong></p>
            <p>📞 (021) 1234-5678 | ✉️ info@yujinfoto.com | 🌐 www.yujinfotostudio.com</p>
            <p style="font-size: 12px; color: #999; margin-top: 15px;">
                © {{ date('Y') }} Yujin Foto Studio. Semua hak cipta dilindungi.<br>
                Laporan ini dibuat secara otomatis oleh sistem manajemen bisnis.<br>
                ⚠️ <em>Dokumen ini bersifat rahasia dan hanya untuk keperluan internal perusahaan.</em>
            </p>
        </div>
    </div>
</body>
</html>
