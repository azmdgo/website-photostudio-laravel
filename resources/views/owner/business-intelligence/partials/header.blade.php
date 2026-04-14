<!-- Dashboard Header -->
<div class="dashboard-header fade-in">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1>Dashboard Business Intelligence</h1>
            <p>Analitik komprehensif dan wawasan bisnis untuk Yujin Foto Studio</p>
        </div>
        <div class="col-md-4">
            <div class="dashboard-actions">
                <button type="button" class="btn btn-light" onclick="refreshDashboard()">
                    <i class="fas fa-sync-alt me-2"></i>Perbarui
                </button>
                <button type="button" class="btn btn-light" onclick="exportReport()">
                    <i class="fas fa-download me-2"></i>Ekspor
                </button>
            </div>
            <div class="mt-3">
                <small class="text-white-50">Terakhir diperbarui: <span id="lastUpdated">{{ date('d/m/Y H:i') }}</span></small>
            </div>
        </div>
    </div>
</div>
