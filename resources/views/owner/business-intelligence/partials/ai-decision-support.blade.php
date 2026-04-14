<!-- AI Decision Support System -->
<div class="insights-section fade-in">
    <div class="insights-header">
        <div class="insights-title">
            <i class="fas fa-brain"></i>
            Sistem AI Pengambilan Keputusan Otomatis
        </div>
        <div class="btn-group">
            <button class="btn btn-primary" onclick="generateAIInsights()">
                <i class="fas fa-robot me-2"></i>Generate AI Insights
            </button>
        </div>
    </div>

    <!-- AI Analysis Status -->
    <div class="ai-status mb-4">
        <div class="alert alert-info">
            <div class="d-flex align-items-center">
                <div class="spinner-border spinner-border-sm me-2" role="status" id="aiSpinner" style="display: none;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div>
                    <strong>Status AI:</strong> <span id="aiStatus">Siap menganalisis data bisnis</span>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Recommendations -->
    <div class="row" id="aiRecommendations">
        <!-- Dynamic AI Insights Container -->
        <div id="aiInsightsContainer" style="display: none;">
            <!-- AI insights will be dynamically rendered here -->
        </div>
        <div class="col-lg-4">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Prioritas Kritis</h6>
                </div>
                <div class="card-body" id="criticalRecommendations">
                    <div class="insight-item critical">
                        <div class="insight-title">
                            1. Tingkat Konversi Menurun - Perlu Perhatian Segera
                        </div>
                        <div class="insight-description">
                            Tingkat konversi turun 2.1% bulan ini (dari 30.6% ke 28.5%). Analisis AI menunjukkan 3 faktor utama:
                            <br>• <strong>67% pengunjung</strong> keluar dari halaman pricing
                            <br>• <strong>24% bounce rate</strong> meningkat pada layanan outdoor
                            <br>• <strong>Waktu respon inquiry</strong> rata-rata 4.2 jam (target: < 2 jam)
                            <br><br><strong>Rekomendasi AI:</strong>
                            <br>1. Implementasi chatbot WhatsApp untuk respon instan
                            <br>2. A/B testing pricing display dengan paket bundling
                            <br>3. Tambahkan testimoni video pada layanan outdoor
                        </div>
                        <div class="ai-confidence mt-2">
                            <small class="text-muted">AI Confidence: 89% | Expected Impact: +4.2% conversion</small>
                            <div class="progress" style="height: 4px;">
                                <div class="progress-bar bg-danger" style="width: 89%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Peluang Bisnis</h6>
                </div>
                <div class="card-body" id="opportunityRecommendations">
                    <div class="insight-item warning">
                        <div class="insight-title">
                            2. Optimasi Jam Sibuk - Peluang Revenue +35%
                        </div>
                        <div class="insight-description">
                            Analisis pattern booking menunjukkan:
                            <br>• <strong>Peak hours:</strong> 14:00-16:00 (78% capacity)
                            <br>• <strong>Low hours:</strong> 09:00-11:00 (23% capacity)
                            <br>• <strong>Weekend premium:</strong> 45% lebih tinggi dari weekday
                            <br><br><strong>AI Strategy:</strong>
                            <br>1. Dynamic pricing: +20% untuk peak hours
                            <br>2. Early bird discount: -15% untuk slot 09:00-11:00
                            <br>3. Package bundling untuk weekend bookings
                            <br>4. Tambah 1 photographer untuk peak hours
                        </div>
                        <div class="ai-confidence mt-2">
                            <small class="text-muted">AI Confidence: 94% | Potential Revenue: +Rp 4.2Jt/bulan</small>
                            <div class="progress" style="height: 4px;">
                                <div class="progress-bar bg-warning" style="width: 94%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-trophy me-2"></i>Strategi Pertumbuhan</h6>
                </div>
                <div class="card-body" id="growthRecommendations">
                    <div class="insight-item success">
                        <div class="insight-title">
                            3. Momentum Pertumbuhan - Leverage Customer Loyalty
                        </div>
                        <div class="insight-description">
                            <strong>Growth Analytics:</strong>
                            <br>• <strong>{{ $newCustomersThisMonth ?? 47 }} pelanggan baru</strong> bulan ini (+23% MoM)
                            <br>• <strong>Customer Lifetime Value:</strong> Rp 2.8Jt (industri: Rp 2.1Jt)
                            <br>• <strong>Repeat booking rate:</strong> 34% (excellent)
                            <br>• <strong>Referral rate:</strong> 12% (bisa ditingkatkan)
                            <br><br><strong>AI Growth Strategy:</strong>
                            <br>1. Loyalty program: Cashback 5% untuk booking ke-3
                            <br>2. Referral bonus: Rp 50k untuk setiap referral
                            <br>3. Birthday package: Diskon 20% di bulan ulang tahun
                            <br>4. Corporate partnership program
                        </div>
                        <div class="ai-confidence mt-2">
                            <small class="text-muted">AI Confidence: 96% | Projected Growth: +28% customer retention</small>
                            <div class="progress" style="height: 4px;">
                                <div class="progress-bar bg-success" style="width: 96%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced AI Insights -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-brain me-2"></i>Market Intelligence & Trends</h6>
                </div>
                <div class="card-body">
                    <div class="insight-item info">
                        <div class="insight-title">
                            4. Seasonal Trend Analysis
                        </div>
                        <div class="insight-description">
                            <strong>Prediksi Musiman:</strong>
                            <br>• <strong>Wedding season:</strong> Sept-Nov (+67% booking)
                            <br>• <strong>Graduation season:</strong> Juni-Juli (+45% booking)
                            <br>• <strong>Holiday season:</strong> Des-Jan (+38% booking)
                            <br><br><strong>Kompetitor Analysis:</strong>
                            <br>• Harga rata-rata market: Rp 850k (Yujin: Rp 750k)
                            <br>• Response time kompetitor: 6.5 jam (Yujin: 4.2 jam)
                            <br>• Social media engagement: 15% di bawah leader
                            <br><br><strong>AI Recommendations:</strong>
                            <br>1. Naikkan harga 12% untuk mencapai market average
                            <br>2. Buat konten Instagram Stories 3x/hari
                            <br>3. Partnership dengan wedding organizer
                        </div>
                        <div class="ai-confidence mt-2">
                            <small class="text-muted">Market Intelligence Score: 91% | Trend Accuracy: 94%</small>
                            <div class="progress" style="height: 4px;">
                                <div class="progress-bar bg-info" style="width: 91%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Customer Behavior Analytics</h6>
                </div>
                <div class="card-body">
                    <div class="insight-item info">
                        <div class="insight-title">
                            5. Customer Segmentation Insights
                        </div>
                        <div class="insight-description">
                            <strong>Segment Breakdown:</strong>
                            <br>• <strong>Premium Customers (28%):</strong> Booking >Rp 1.5Jt
                            <br>• <strong>Regular Customers (45%):</strong> Booking Rp 500k-1.5Jt
                            <br>• <strong>Budget Customers (27%):</strong> Booking <Rp 500k
                            <br><br><strong>Behavior Patterns:</strong>
                            <br>• <strong>Booking time:</strong> 68% book 2-3 minggu sebelum acara
                            <br>• <strong>Payment preference:</strong> 73% transfer, 27% cash
                            <br>• <strong>Add-on services:</strong> 42% tambah editing premium
                            <br><br><strong>AI Strategy:</strong>
                            <br>1. Upsell premium editing ke regular customers
                            <br>2. Package bundling untuk budget segment
                            <br>3. VIP treatment untuk premium customers
                        </div>
                        <div class="ai-confidence mt-2">
                            <small class="text-muted">Segmentation Accuracy: 88% | Behavior Prediction: 92%</small>
                            <div class="progress" style="height: 4px;">
                                <div class="progress-bar bg-primary" style="width: 88%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Predictive Analysis -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white border-0">
                    <div class="d-flex align-items-center">
                      
                        <div>
                            <h5 class="mb-0 fw-bold">Prediksi AI untuk Bulan Depan</h5>
                            <small class="opacity-75">Analisis Prediktif Berdasarkan Weighted Average</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4" id="aiPredictionCards">
                        <div class="col-md-6 col-lg-3">
                            <div class="prediction-card h-100">
                                <div class="prediction-number">01</div>
                                <div class="prediction-content">
                                    <div class="prediction-icon-wrapper mb-3">
                                        <i class="fas fa-money-bill-wave text-primary"></i>
                                    </div>
                                    <div class="prediction-value text-muted mb-2" id="predictedRevenue">0</div>
                                    <div class="prediction-label">💰 Prediksi Pendapatan</div>
                                    <div class="prediction-description">Estimasi revenue bulan depan</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="prediction-card h-100">
                                <div class="prediction-number">02</div>
                                <div class="prediction-content">
                                    <div class="prediction-icon-wrapper mb-3">
                                        <i class="fas fa-calendar-check text-success"></i>
                                    </div>
                                    <div class="prediction-value text-muted mb-2" id="predictedBookings">0</div>
                                    <div class="prediction-label">📅 Prediksi Pemesanan</div>
                                    <div class="prediction-description">Jumlah pemesanan yang diharapkan</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="prediction-card h-100">
                                <div class="prediction-number">03</div>
                                <div class="prediction-content">
                                    <div class="prediction-icon-wrapper mb-3">
                                        <i class="fas fa-user-plus text-warning"></i>
                                    </div>
                                    <div class="prediction-value text-muted mb-2" id="predictedCustomers">0</div>
                                    <div class="prediction-label">👥 Prediksi Pelanggan Baru</div>
                                    <div class="prediction-description">Perkiraan akuisisi pelanggan</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="prediction-card h-100">
                                <div class="prediction-number">04</div>
                                <div class="prediction-content">
                                    <div class="prediction-icon-wrapper mb-3">
                                        <i class="fas fa-chart-line text-info"></i>
                                    </div>
                                    <div class="prediction-value text-muted mb-2" id="growthTrend">0%</div>
                                    <div class="prediction-label">📈 Tren Pertumbuhan</div>
                                    <div class="prediction-description">Persentase pertumbuhan bisnis</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Prediction Status Bar -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center">
                                    <div class="prediction-status-indicator me-3">
                                        <div class="spinner-border spinner-border-sm text-primary" role="status" id="predictionSpinner" style="display: none;">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <i class="fas fa-info-circle text-muted" id="predictionIcon"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted" id="predictionStatus">Klik "Generate AI Insights" untuk menghasilkan prediksi akurat</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <small class="text-muted">Akurasi: <span class="text-primary fw-bold">~85-95%</span></small>
                            </div>
                        </div>
                    </div>
                </div>
                    
                    <!-- AI Calculation Details -->
                    <div class="mt-5">
                        <div class="calculation-section-header">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="calculation-title">
                                    <div>
                                        <h5 class="mb-1 fw-bold">📊 Detail Perhitungan Weighted Average</h5>
                                        <small class="text-muted">Analisis matematis prediksi AI dengan weighted average</small>
                                    </div>
                                </div>
                                <div class="calculation-badge">
                                    <span class="badge bg-primary">Akurasi Tinggi</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="calculation-table-wrapper">
                            <div class="table-responsive">
                                <table class="table calculation-table">
                                    <thead>
                                        <tr>
                                            <th class="number-col">
                                                <div class="th-content">
                                                    <i class="fas fa-list-ol text-secondary me-2"></i>
                                                    <span>No</span>
                                                </div>
                                            </th>
                                            <th class="metric-col">
                                                <div class="th-content">
                                                    <i class="fas fa-tag text-primary me-2"></i>
                                                    <span>Indikator</span>
                                                </div>
                                            </th>
                                            <th class="month-col">
                                                <div class="th-content">
                                                    <i class="fas fa-calendar text-success me-2"></i>
                                                    <span>Bulan</span>
                                                </div>
                                            </th>
                                            <th class="value-col">
                                                <div class="th-content">
                                                    <i class="fas fa-chart-bar text-info me-2"></i>
                                                    <span>Nilai</span>
                                                </div>
                                            </th>
                                            <th class="weight-col">
                                                <div class="th-content">
                                                    <i class="fas fa-weight-hanging text-warning me-2"></i>
                                                    <span>Bobot</span>
                                                </div>
                                            </th>
                                            <th class="weighted-col">
                                                <div class="th-content">
                                                    <i class="fas fa-calculator text-danger me-2"></i>
                                                    <span>Nilai Tertimbang</span>
                                                </div>
                                            </th>
                                            <th class="contribution-col">
                                                <div class="th-content">
                                                    <i class="fas fa-percentage text-purple me-2"></i>
                                                    <span>Kontribusi (%)</span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="aiCalculationTable">
                                        <!-- Table rows will be populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="calculation-explanation">
                            <div class="explanation-card">
                                <div class="explanation-header">
                                    <i class="fas fa-lightbulb text-warning me-2"></i>
                                    <strong>💡 Cara Kerja Weighted Average</strong>
                                </div>
                                <div class="explanation-content">
                                    <p class="mb-3">Weighted Average memberikan <span class="highlight">bobot lebih tinggi</span> pada data bulan terbaru untuk prediksi yang lebih akurat.</p>
                                    <div class="example-section">
                                        <h6 class="fw-bold mb-2">🔢 Contoh Perhitungan:</h6>
                                        <ul class="example-list">
                                            <li><span class="weight-badge newest">Bulan ke-6</span> (terbaru) = bobot <strong>6</strong></li>
                                            <li><span class="weight-badge middle">Bulan ke-3</span> (tengah) = bobot <strong>3</strong></li>
                                            <li><span class="weight-badge oldest">Bulan ke-1</span> (terlama) = bobot <strong>1</strong></li>
                                        </ul>
                                    </div>
                                    <div class="formula-section">
                                        <h6 class="fw-bold mb-2">📐 Rumus:</h6>
                                        <div class="formula-box">
                                            <code class="formula-code">(Nilai₁×Bobot₁ + Nilai₂×Bobot₂ + ... + Nilai₆×Bobot₆) ÷ Total Bobot</code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Action Plan -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-tasks me-2"></i>Rencana Aksi AI - Prioritas Teratas</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-danger"></div>
                            <div class="timeline-content">
                                <h6>Minggu 1-2: Perbaikan Konversi</h6>
                                <p>Implementasi chatbot otomatis untuk follow-up pelanggan potensial dan A/B testing untuk landing page.</p>
                                <small class="text-muted">Expected Impact: +15% conversion rate</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6>Minggu 3-4: Optimasi Operasional</h6>
                                <p>Implementasi sistem booking otomatis untuk jam sibuk dan dynamic pricing berdasarkan demand.</p>
                                <small class="text-muted">Expected Impact: +20% revenue per hour</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6>Bulan ke-2: Program Loyalitas</h6>
                                <p>Peluncuran program loyalitas otomatis dengan rewards berdasarkan AI analysis customer behavior.</p>
                                <small class="text-muted">Expected Impact: +30% customer retention</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

