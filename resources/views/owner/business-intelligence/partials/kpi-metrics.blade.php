<!-- KPI Metrics -->
<div class="metric-grid">
    <div class="kpi-card fade-in">
        <div class="kpi-icon" style="color: var(--primary-color);">
            <i class="fas fa-users" style="font-size: 2rem;"></i>
        </div>
        <div class="kpi-title">Total Pelanggan</div>
        <div class="kpi-value">{{ number_format($totalCustomers ?? 1250) }}</div>
        <div class="kpi-change positive">
            <i class="fas fa-arrow-up"></i>
            <span>+{{ $newCustomersThisMonth ?? 47 }} bulan ini</span>
        </div>
    </div>

    <div class="kpi-card fade-in">
        <div class="kpi-icon" style="color: var(--success-color);">
            <i class="fas fa-chart-line" style="font-size: 2rem;"></i>
        </div>
        <div class="kpi-title">Pendapatan Bulanan</div>
        <div class="kpi-value">Rp {{ number_format($thisMonthRevenue ?? 12500000, 0, ',', '.') }}</div>
        <div class="kpi-change positive">
            <i class="fas fa-arrow-up"></i>
            <span>+8.5% dari bulan lalu</span>
        </div>
    </div>

    <div class="kpi-card fade-in">
        <div class="kpi-icon" style="color: var(--warning-color);">
            <i class="fas fa-percentage" style="font-size: 2rem;"></i>
        </div>
        <div class="kpi-title">Tingkat Konversi</div>
        <div class="kpi-value">{{ number_format($conversionRate ?? 28.5, 1) }}%</div>
        <div class="kpi-change negative">
            <i class="fas fa-arrow-down"></i>
            <span>-2.1% dari bulan lalu</span>
        </div>
    </div>

    <div class="kpi-card fade-in">
        <div class="kpi-icon" style="color: var(--info-color);">
            <i class="fas fa-heart" style="font-size: 2rem;"></i>
        </div>
        <div class="kpi-title">Kepuasan Pelanggan</div>
        <div class="kpi-value">{{ number_format($customerSatisfaction ?? 92.3, 1) }}%</div>
        <div class="kpi-change positive">
            <i class="fas fa-arrow-up"></i>
            <span>+3.2% dari bulan lalu</span>
        </div>
    </div>
</div>
