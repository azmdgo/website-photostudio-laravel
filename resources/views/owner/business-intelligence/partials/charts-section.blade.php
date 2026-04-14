<!-- Charts Section -->
<div class="chart-grid">
    <div class="chart-card fade-in">
        <div class="chart-header">
            <div class="chart-title">
                <i class="fas fa-chart-line"></i>
                Tren Pendapatan
            </div>
            <div class="chart-actions">
                <select id="revenueChartFilter" class="form-select form-select-sm" style="width: auto;" onchange="updateRevenueChart()">
                    <option value="1">1 Bulan Terakhir</option>
                    <option value="3">3 Bulan Terakhir</option>
                    <option value="6">6 Bulan Terakhir</option>
                    <option value="12" selected>12 Bulan Terakhir</option>
                </select>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <div class="chart-card fade-in">
        <div class="chart-header">
            <div class="chart-title">
                <i class="fas fa-chart-column"></i>
                Pertumbuhan Pelanggan
            </div>
            <div class="chart-actions">
                <select id="customerGrowthChartFilter" class="form-select form-select-sm" style="width: auto;" onchange="updateCustomerGrowthChart()">
                    <option value="1">1 Bulan Terakhir</option>
                    <option value="3">3 Bulan Terakhir</option>
                    <option value="6">6 Bulan Terakhir</option>
                    <option value="12" selected>12 Bulan Terakhir</option>
                </select>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="bookingsChart"></canvas>
        </div>
    </div>

    <div class="chart-card fade-in">
        <div class="chart-header">
            <div class="chart-title">
                <i class="fas fa-chart-bar"></i>
                Distribusi Layanan
            </div>
            <div class="chart-actions">
                <select id="serviceChartFilter" class="form-select form-select-sm" style="width: auto;" onchange="updateServiceChart()">
                    <option value="1">1 Bulan Terakhir</option>
                    <option value="3">3 Bulan Terakhir</option>
                    <option value="6">6 Bulan Terakhir</option>
                    <option value="12" selected>12 Bulan Terakhir</option>
                </select>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="serviceChart"></canvas>
        </div>
    </div>

    <div class="chart-card fade-in">
        <div class="chart-header">
            <div class="chart-title">
                <i class="fas fa-chart-pie"></i>
                Status Pemesanan
            </div>
            <div class="chart-actions">
                <select id="statusChartFilter" class="form-select form-select-sm" style="width: auto;" onchange="updateStatusChart()">
                    <option value="1">1 Bulan Terakhir</option>
                    <option value="3">3 Bulan Terakhir</option>
                    <option value="6">6 Bulan Terakhir</option>
                    <option value="12" selected>12 Bulan Terakhir</option>
                </select>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="customerSegmentChart"></canvas>
        </div>
    </div>

    <div class="chart-card fade-in">
        <div class="chart-header">
            <div class="chart-title">
                <i class="fas fa-chart-area"></i>
                Tren Pemesanan Kategori Layanan
            </div>
            <div class="chart-actions">
                <select id="categoryChartFilter" class="form-select form-select-sm" style="width: auto;" onchange="updateCategoryChart()">
                    <option value="1">1 Bulan Terakhir</option>
                    <option value="3">3 Bulan Terakhir</option>
                    <option value="6">6 Bulan Terakhir</option>
                    <option value="12" selected>12 Bulan Terakhir</option>
                </select>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="serviceCategoryChart"></canvas>
        </div>
    </div>

    <div class="chart-card fade-in">
        <div class="chart-header">
            <div class="chart-title">
                <i class="fas fa-chart-pie"></i>
                Alasan Pesanan Dibatalkan
            </div>
            <div class="chart-actions">
                <select id="cancellationReasonChartFilter" class="form-select form-select-sm" style="width: auto;" onchange="updateCancellationReasonChart()">
                    <option value="1">1 Bulan Terakhir</option>
                    <option value="3">3 Bulan Terakhir</option>
                    <option value="6">6 Bulan Terakhir</option>
                    <option value="12" selected>12 Bulan Terakhir</option>
                </select>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="cancellationReasonChart"></canvas>
        </div>
        <div class="chart-info mt-3">
            <div class="info-item">
                <i class="fas fa-info-circle text-info"></i>
                <small class="text-muted">Data berdasarkan analisis probabilitas dari pesanan yang dibatalkan</small>
            </div>
        </div>
    </div>
</div>
