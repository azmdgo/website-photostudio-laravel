<table>
    <tr>
        <th colspan="4" style="background-color: #4F46E5; color: white; font-weight: bold; padding: 10px;">
            {{ $reportTitle }} - {{ $generatedAt }}
        </th>
    </tr>
    <tr>
        <td colspan="4" style="padding: 5px;"></td>
    </tr>
    <tr>
        <th style="background-color: #667eea; color: white; font-weight: bold;">Metrik</th>
        <th style="background-color: #667eea; color: white; font-weight: bold;">Nilai</th>
        <th style="background-color: #667eea; color: white; font-weight: bold;">Status</th>
        <th style="background-color: #667eea; color: white; font-weight: bold;">Trend</th>
    </tr>
    <tr>
        <td>Total Pendapatan</td>
        <td>{{ number_format($totalRevenue, 0, ',', '.') }}</td>
        <td>Excellent</td>
        <td>{{ $revenueGrowth >= 0 ? 'UP' : 'DOWN' }}</td>
    </tr>
    <tr>
        <td>Total Pelanggan</td>
        <td>{{ number_format($totalCustomers, 0, ',', '.') }}</td>
        <td>Growing</td>
        <td>STABLE</td>
    </tr>
    <tr>
        <td>Total Booking</td>
        <td>{{ number_format($totalBookings, 0, ',', '.') }}</td>
        <td>Active</td>
        <td>UP</td>
    </tr>
    <tr>
        <td>Tingkat Konversi</td>
        <td>{{ $conversionRate }}%</td>
        <td>{{ $conversionRate >= 50 ? 'Excellent' : 'Good' }}</td>
        <td>{{ $conversionRate >= 50 ? 'UP' : 'STABLE' }}</td>
    </tr>
    <tr>
        <td colspan="4" style="padding: 10px;"></td>
    </tr>
    <tr>
        <th colspan="4" style="background-color: #28a745; color: white; font-weight: bold;">
            REVENUE CHART DATA
        </th>
    </tr>
    <tr>
        <th>Bulan</th>
        <th>Pendapatan</th>
        <th>Persentase</th>
        <th>Growth Rate</th>
    </tr>
    @php
        $totalMonthlyRevenue = $monthlyRevenue->sum('revenue');
        $previousRevenue = 0;
    @endphp
    @foreach($monthlyRevenue as $revenue)
    @php
        $percentage = $totalMonthlyRevenue > 0 ? round(($revenue->revenue / $totalMonthlyRevenue) * 100, 2) : 0;
        $growthRate = $previousRevenue > 0 ? round((($revenue->revenue - $previousRevenue) / $previousRevenue) * 100, 2) : 0;
    @endphp
    <tr>
        <td>{{ $revenue->month }}/{{ $revenue->year }}</td>
        <td>{{ number_format($revenue->revenue, 0, ',', '.') }}</td>
        <td>{{ $percentage }}%</td>
        <td>{{ $growthRate > 0 ? '+' : '' }}{{ $growthRate }}%</td>
    </tr>
    @php
        $previousRevenue = $revenue->revenue;
    @endphp
    @endforeach
    <tr>
        <td colspan="4" style="padding: 10px;"></td>
    </tr>
    <tr>
        <th colspan="4" style="background-color: #fd7e14; color: white; font-weight: bold;">
            SERVICE POPULARITY CHART DATA
        </th>
    </tr>
    <tr>
        <th>Layanan</th>
        <th>Total Booking</th>
        <th>Booking Selesai</th>
        <th>Total Pendapatan</th>
    </tr>
    @foreach($servicePopularity as $service)
    <tr>
        <td>{{ $service->name }}</td>
        <td>{{ $service->bookings_count }}</td>
        <td>{{ $service->completed_bookings_count }}</td>
        <td>{{ number_format($service->bookings_sum_total_price ?? 0, 0, ',', '.') }}</td>
    </tr>
    @endforeach
    <tr>
        <td colspan="4" style="padding: 10px;"></td>
    </tr>
    <tr>
        <th colspan="4" style="background-color: #6f42c1; color: white; font-weight: bold;">
            BOOKING STATUS DISTRIBUTION
        </th>
    </tr>
    <tr>
        <th>Status</th>
        <th>Jumlah</th>
        <th>Persentase</th>
        <th>Insight</th>
    </tr>
    @php
        $totalBookingsByStatus = $bookingsByStatus->sum('count');
    @endphp
    @foreach($bookingsByStatus as $status)
    @php
        $percentage = $totalBookingsByStatus > 0 ? round(($status->count / $totalBookingsByStatus) * 100, 1) : 0;
    @endphp
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
        <td>{{ $percentage }}%</td>
        <td>
            @if($status->status == 'completed')
                Sukses
            @elseif($status->status == 'pending')
                Perlu Tindak Lanjut
            @elseif($status->status == 'cancelled')
                Perlu Analisis
            @else
                Normal
            @endif
        </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="4" style="padding: 10px;"></td>
    </tr>
    <tr>
        <th colspan="4" style="background-color: #17a2b8; color: white; font-weight: bold;">
            CUSTOMER GROWTH DATA
        </th>
    </tr>
    <tr>
        <th>Bulan</th>
        <th>Pelanggan Baru</th>
        <th>Trend</th>
        <th>Status</th>
    </tr>
    @php
        $previousCount = 0;
    @endphp
    @foreach($customerGrowth as $growth)
    <tr>
        <td>{{ $growth->month }}/{{ $growth->year }}</td>
        <td>{{ $growth->count }}</td>
        <td>{{ $growth->count > $previousCount ? 'UP' : ($growth->count < $previousCount ? 'DOWN' : 'STABLE') }}</td>
        <td>{{ $growth->count > 5 ? 'Good' : 'Need Improvement' }}</td>
    </tr>
    @php
        $previousCount = $growth->count;
    @endphp
    @endforeach
    <tr>
        <td colspan="4" style="padding: 15px;"></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center; font-weight: bold; background-color: #f8f9fa; padding: 10px;">
            Yujin Foto Studio - Business Intelligence Report
        </td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center; font-size: 12px; color: #666; padding: 5px;">
            Generated on {{ $generatedAt }}
        </td>
    </tr>
</table>
