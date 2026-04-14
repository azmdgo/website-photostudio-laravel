<!-- Chart.js and Custom Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Register the datalabels plugin globally
    Chart.register(ChartDataLabels);
    
    // Chart.js default configuration
    Chart.defaults.font.family = "'Inter', 'Segoe UI', sans-serif";
    Chart.defaults.font.size = 12;
    Chart.defaults.color = '#6B7280';
    
    // Disable datalabels globally by default
    Chart.defaults.plugins.datalabels = {
        display: false
    };

    const colors = {
        primary: '#4F46E5',
        secondary: '#6366F1',
        success: '#10B981',
        warning: '#F59E0B',
        danger: '#EF4444',
        info: '#3B82F6',
        light: '#F8FAFC',
        dark: '#1F2937'
    };

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const monthlyRevenueData = @json($monthlyRevenue ?? []);
    
    // Initialize revenue chart with consistent 12 months data
    revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: [],
                borderColor: colors.primary,
                backgroundColor: colors.primary + '20',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colors.primary,
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Revenue: Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000) + 'Jt';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Bookings Chart (Customer Growth)
    const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
    const customerGrowthData = @json($customerGrowth ?? []);
    
    // Initialize customer growth chart with empty data
    customerGrowthChart = new Chart(bookingsCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Pelanggan Baru',
                data: [],
                backgroundColor: colors.success,
                borderColor: colors.success,
                borderWidth: 1,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Service Distribution Chart
    const serviceCtx = document.getElementById('serviceChart').getContext('2d');
    const initialServicePopularityData = @json($servicePopularity ?? []);
    
    // Initialize the service chart with initial data
    updateServiceChartData(initialServicePopularityData);

    // Customer Segment Chart (Booking Status)
    const customerSegmentCtx = document.getElementById('customerSegmentChart').getContext('2d');
    const initialBookingStatusData = @json($bookingsByStatus ?? []);
    
    // Initialize the status chart with initial data
    updateStatusChartData(initialBookingStatusData);

    // Service Category Comparison Chart - Dynamic Categories
    const initialServiceCategoryData = @json($serviceCategoryData ?? []);
    
    // Debug: Log service category data
    console.log('Initial Service Category Data:', initialServiceCategoryData);
    
    // Initialize the service category chart with initial data
    updateServiceCategoryChart(initialServiceCategoryData);
    
    // Initialize revenue chart with backend data using consistent logic
    updateRevenueChartData(monthlyRevenueData, 12);
    
    // Initialize customer growth chart with backend data using consistent logic
    updateCustomerGrowthChartData(customerGrowthData);
    
    // Initialize cancellation reason chart
    updateCancellationReasonChart();
});

// Function to update cancellation reason chart
function updateCancellationReasonChart() {
    const filterSelect = document.getElementById('cancellationReasonChartFilter');
    const months = filterSelect.value;

    // Show loading state
    const chartContainer = document.querySelector('#cancellationReasonChart').parentElement;
    const originalContent = chartContainer.innerHTML;
    chartContainer.innerHTML = `
        <div class="d-flex justify-content-center align-items-center" style="height: 400px;">
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2">Memuat data...</div>
            </div>
        </div>
    `;

    // Fetch new data via AJAX
    fetch(`{{ route('admin.business-intelligence.cancellation-reason-data') }}?months=${months}`)
        .then(response => response.json())
        .then(data => {
            console.log('Updated Cancellation Reason Data:', data);

            // Restore original content
            chartContainer.innerHTML = originalContent;

            // Update the chart with new data
            updateCancellationReasonChartData(data);

            // Show success notification
            showNotification(`Cancellation reason chart updated for ${months} month${months > 1 ? 's' : ''} period`, 'success');
        })
        .catch(error => {
            console.error('Error fetching cancellation reason data:', error);
            
            // Restore original content
            chartContainer.innerHTML = originalContent;
            
            // Show error notification
            showNotification('Error updating cancellation reason chart data', 'danger');
        });
}

// Function to update cancellation reason chart with new data
function updateCancellationReasonChartData(cancellationReasonData) {
    const cancellationReasonCtx = document.getElementById('cancellationReasonChart').getContext('2d');

    // Destroy existing chart if it exists
    if (cancellationReasonChart) {
        cancellationReasonChart.destroy();
        cancellationReasonChart = null;
    }

    const colors = [
        '#4F46E5', // Indigo
        '#10B981', // Emerald
        '#F59E0B', // Amber
        '#EF4444', // Red
        '#3B82F6'  // Blue
    ];

    // Check if there's data to display
    if (!cancellationReasonData.reasons || cancellationReasonData.reasons.length === 0 || !cancellationReasonData.has_data) {
        // Create empty state chart
        cancellationReasonChart = new Chart(cancellationReasonCtx, {
            type: 'pie',
            data: {
                labels: ['Tidak Ada Data Pembatalan'],
                datasets: [{
                    data: [1],
                    backgroundColor: ['#E5E7EB'],
                    borderColor: '#ffffff',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function() {
                                return 'Tidak ada pesanan dibatalkan pada periode ini';
                            }
                        }
                    },
                    datalabels: {
                        display: false
                    }
                }
            }
        });
        return;
    }

    // Store data globally for access in callbacks
    window.currentCancellationData = cancellationReasonData;
    
    // Debug logging
    console.log('Cancellation Reason Data:', cancellationReasonData);
    console.log('Reasons array:', cancellationReasonData.reasons);

    // Create new chart
    cancellationReasonChart = new Chart(cancellationReasonCtx, {
        type: 'pie',
        data: {
            labels: cancellationReasonData.reasons.map(item => item.reason),
            datasets: [{
                data: cancellationReasonData.reasons.map(item => item.count),
                backgroundColor: colors.slice(0, cancellationReasonData.reasons.length),
                borderColor: '#ffffff',
                borderWidth: 2,
            }]
        },
        plugins: [ChartDataLabels],
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        generateLabels: function(chart) {
                            const data = chart.data;
                            if (data.labels.length && data.datasets.length && window.currentCancellationData) {
                                // Calculate total of displayed data
                                const totalDisplayed = data.datasets[0].data.reduce((sum, value) => sum + value, 0);
                                
                                return data.labels.map((label, i) => {
                                    const value = data.datasets[0].data[i];
                                    // Calculate actual percentage based on displayed data
                                    const actualPercentage = totalDisplayed > 0 ? ((value / totalDisplayed) * 100).toFixed(1) : 0;
                                    
                                    return {
                                        text: `${label} (${actualPercentage}%)`,
                                        fillStyle: data.datasets[0].backgroundColor[i],
                                        strokeStyle: data.datasets[0].borderColor,
                                        lineWidth: data.datasets[0].borderWidth,
                                        pointStyle: 'circle',
                                        hidden: false,
                                        index: i
                                    };
                                });
                            }
                            return [];
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const count = context.raw;
                            
                            // Calculate actual percentage from displayed data
                            const dataset = context.dataset;
                            const total = dataset.data.reduce((sum, value) => sum + value, 0);
                            const percentage = total > 0 ? ((count / total) * 100).toFixed(1) : 0;
                            
                            return `${label}: ${count} pesanan (${percentage}%)`;
                        }
                    }
                },
                datalabels: {
                    display: true, // Explicitly enable for this chart
                    color: '#fff',
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    formatter: function(value, ctx) {
                        // Calculate actual percentage from displayed data
                        const dataset = ctx.dataset;
                        const total = dataset.data.reduce((sum, val) => sum + val, 0);
                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        
                        return percentage + '%';
                    },
                    textStrokeColor: '#000',
                    textStrokeWidth: 1
                }
            }
        }
    });
}

// Function to update service chart based on filter
function updateServiceChart() {
    const filterSelect = document.getElementById('serviceChartFilter');
    const months = filterSelect.value;
    
    // Show loading state
    const chartContainer = document.querySelector('#serviceChart').parentElement;
    const originalContent = chartContainer.innerHTML;
    chartContainer.innerHTML = `
        <div class="d-flex justify-content-center align-items-center" style="height: 400px;">
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2">Memuat data...</div>
            </div>
        </div>
    `;
    
    // Fetch new data via AJAX
    fetch(`{{ route('admin.business-intelligence.service-data') }}?months=${months}`)
        .then(response => response.json())
        .then(data => {
            console.log('Updated Service Data:', data);
            
            // Restore original content
            chartContainer.innerHTML = originalContent;
            
            // Update the chart with new data
            updateServiceChartData(data);
            
            // Show success notification
            showNotification(`Service chart updated for ${months} month${months > 1 ? 's' : ''} period`, 'success');
        })
        .catch(error => {
            console.error('Error fetching service data:', error);
            
            // Restore original content
            chartContainer.innerHTML = originalContent;
            
            // Show error notification
            showNotification('Error updating service chart data', 'danger');
        });
}

// Function to update service chart with new data
function updateServiceChartData(servicePopularityData) {
    const serviceCtx = document.getElementById('serviceChart').getContext('2d');
    
    // Destroy existing chart if it exists
    if (serviceChart) {
        serviceChart.destroy();
    }
    
    // Create new chart
    serviceChart = new Chart(serviceCtx, {
        type: 'bar',
        data: {
            labels: servicePopularityData.length > 0 ? servicePopularityData.map(item => item.name) : ['No Data'],
            datasets: [{
                label: 'Jumlah Layanan',
                data: servicePopularityData.length > 0 ? servicePopularityData.map(item => item.bookings_count) : [1],
                backgroundColor: [
                    '#4F46E5', // Indigo
                    '#10B981', // Emerald
                    '#F59E0B', // Amber
                    '#EF4444', // Red
                    '#8B5CF6', // Purple
                    '#06B6D4', // Cyan
                    '#84CC16', // Lime
                    '#F97316', // Orange
                    '#EC4899', // Pink
                    '#6366F1'  // Violet
                ],
                borderWidth: 2,
                borderColor: '#ffffff',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y', // This makes it horizontal
            plugins: {
                legend: {
                    display: false // Hide legend for horizontal bar chart
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.x + ' pemesanan';
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        callback: function(value) {
                            return value + ' pemesanan';
                        }
                    }
                },
                y: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// Global variables to store chart instances
let serviceCategoryChart = null;
let revenueChart = null;
let customerGrowthChart = null;
let serviceChart = null;
let statusChart = null;
let cancellationReasonChart = null;

// Function to update category chart based on filter
function updateCategoryChart() {
    const filterSelect = document.getElementById('categoryChartFilter');
    const months = filterSelect.value;
    
    // Show loading state
    const chartContainer = document.querySelector('#serviceCategoryChart').parentElement;
    const originalContent = chartContainer.innerHTML;
    chartContainer.innerHTML = `
        <div class="d-flex justify-content-center align-items-center" style="height: 400px;">
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2">Memuat data...</div>
            </div>
        </div>
    `;
    
    // Fetch new data via AJAX
    fetch(`{{ route('admin.business-intelligence.service-category-data') }}?months=${months}`)
        .then(response => response.json())
        .then(data => {
            console.log('Updated Service Category Data:', data);
            
            // Restore original content
            chartContainer.innerHTML = originalContent;
            
            // Update the chart with new data
            updateServiceCategoryChart(data);
            
            // Show success notification
            showNotification(`Chart updated for ${months} month${months > 1 ? 's' : ''} period`, 'success');
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            
            // Restore original content
            chartContainer.innerHTML = originalContent;
            
            // Show error notification
            showNotification('Error updating chart data', 'danger');
        });
}

// Function to update the service category chart with new data
function updateServiceCategoryChart(serviceCategoryData) {
    const serviceCategoryCtx = document.getElementById('serviceCategoryChart').getContext('2d');
    
    // Destroy existing chart if it exists
    if (serviceCategoryChart) {
        serviceCategoryChart.destroy();
    }
    
    // Dynamic color palette for categories
    const categoryColors = [
        { border: '#DC2626', background: '#DC262640' }, // Red
        { border: '#2563EB', background: '#2563EB40' }, // Blue  
        { border: '#10B981', background: '#10B98140' }, // Green
        { border: '#F59E0B', background: '#F59E0B40' }, // Yellow
        { border: '#8B5CF6', background: '#8B5CF640' }, // Purple
        { border: '#EC4899', background: '#EC489940' }, // Pink
        { border: '#06B6D4', background: '#06B6D440' }, // Cyan
        { border: '#84CC16', background: '#84CC1640' }  // Lime
    ];
    
    // Prepare datasets dynamically
    const datasets = [];
    const categoryNames = Object.keys(serviceCategoryData);
    let chartLabels = [];
    
    if (categoryNames.length > 0) {
        // Get labels from first category
        chartLabels = serviceCategoryData[categoryNames[0]].map(item => item.month);
        
        // Create dataset for each category
        categoryNames.forEach((categoryName, index) => {
            const colorIndex = index % categoryColors.length;
            const color = categoryColors[colorIndex];
            
            datasets.push({
                label: categoryName.charAt(0).toUpperCase() + categoryName.slice(1),
                data: serviceCategoryData[categoryName].map(item => item.quantity),
                borderColor: color.border,
                backgroundColor: color.background,
                borderWidth: 3,
                fill: index === 0 ? 'origin' : '-1',
                tension: 0.4,
                pointBackgroundColor: color.border,
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            });
        });
    }
    
    // Fallback if no data
    if (datasets.length === 0) {
        chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        datasets.push({
            label: 'No Data',
            data: new Array(12).fill(0),
            borderColor: '#9CA3AF',
            backgroundColor: '#9CA3AF40',
            borderWidth: 3,
            fill: 'origin',
            tension: 0.4
        });
    }
    
    // Create new chart
    serviceCategoryChart = new Chart(serviceCategoryCtx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' pemesanan';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        callback: function(value) {
                            return value + ' pemesanan';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            elements: {
                line: {
                    borderCapStyle: 'round',
                    borderJoinStyle: 'round'
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
}

// Function to update status chart based on filter
function updateStatusChart() {
    const filterSelect = document.getElementById('statusChartFilter');
    const months = filterSelect.value;
    
    // Show loading state
    const chartContainer = document.querySelector('#customerSegmentChart').parentElement;
    const originalContent = chartContainer.innerHTML;
    chartContainer.innerHTML = `
        <div class="d-flex justify-content-center align-items-center" style="height: 400px;">
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2">Memuat data...</div>
            </div>
        </div>
    `;
    
    // Fetch new data via AJAX
    fetch(`{{ route('admin.business-intelligence.status-data') }}?months=${months}`)
        .then(response => response.json())
        .then(data => {
            console.log('Updated Status Data:', data);
            
            // Restore original content
            chartContainer.innerHTML = originalContent;
            
            // Update the chart with new data
            updateStatusChartData(data);
            
            // Show success notification
            showNotification(`Status chart updated for ${months} month${months > 1 ? 's' : ''} period`, 'success');
        })
        .catch(error => {
            console.error('Error fetching status data:', error);
            
            // Restore original content
            chartContainer.innerHTML = originalContent;
            
            // Show error notification
            showNotification('Error updating status chart data', 'danger');
        });
}

// Function to update status chart with new data
function updateStatusChartData(bookingStatusData) {
    const customerSegmentCtx = document.getElementById('customerSegmentChart').getContext('2d');
    
    // Destroy existing chart if it exists
    if (statusChart) {
        statusChart.destroy();
    }
    
    // Status color mapping to match admin/bookings colors
    const statusColorMap = {
        'pending': { bg: '#F59E0B80', border: '#F59E0B' },        // warning - kuning
        'confirmed': { bg: '#3B82F680', border: '#3B82F6' },      // info - biru muda  
        'in_progress': { bg: '#4F46E580', border: '#4F46E5' },    // primary - biru
        'completed': { bg: '#10B98180', border: '#10B981' },      // success - hijau
        'cancelled': { bg: '#EF444480', border: '#EF4444' }       // danger - merah
    };
    
    // Prepare colors based on actual status data
    const chartBackgroundColors = [];
    const chartBorderColors = [];
    const chartLabels = [];
    
    if (bookingStatusData.length > 0) {
        bookingStatusData.forEach(item => {
            const status = item.status;
            const statusConfig = statusColorMap[status] || { bg: '#9CA3AF80', border: '#9CA3AF' };
            
            chartBackgroundColors.push(statusConfig.bg);
            chartBorderColors.push(statusConfig.border);
            
            // Format label sesuai dengan admin/bookings
            const statusLabels = {
                'pending': 'Menunggu',
                'confirmed': 'Dikonfirmasi',
                'in_progress': 'Sedang Berlangsung',
                'completed': 'Selesai',
                'cancelled': 'Dibatalkan'
            };
            chartLabels.push(statusLabels[status] || status.charAt(0).toUpperCase() + status.slice(1));
        });
    } else {
        chartLabels.push('No Data');
        chartBackgroundColors.push('#9CA3AF80');
        chartBorderColors.push('#9CA3AF');
    }
    
    // Create new chart
    statusChart = new Chart(customerSegmentCtx, {
        type: 'polarArea',
        data: {
            labels: chartLabels,
            datasets: [{
                data: bookingStatusData.length > 0 ? bookingStatusData.map(item => item.count) : [1],
                backgroundColor: chartBackgroundColors,
                borderColor: chartBorderColors,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.r + ' pemesanan';
                        }
                    }
                }
            },
            scales: {
                r: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            }
        }
    });
}

// Function to update category chart based on filter
function updateRevenueChart() {
    const filterSelect = document.getElementById('revenueChartFilter');
    const months = parseInt(filterSelect.value);
    
    // Show loading state
    const chartContainer = document.querySelector('#revenueChart').parentElement;
    const originalContent = chartContainer.innerHTML;
    chartContainer.innerHTML = `
        <div class="d-flex justify-content-center align-items-center" style="height: 400px;">
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2">Memuat data...</div>
            </div>
        </div>
    `;
    
    // Fetch new data via AJAX
    fetch(`{{ route('admin.business-intelligence.revenue-data') }}?months=${months}`)
        .then(response => response.json())
        .then(data => {
            console.log('Updated Revenue Data:', data);
            
            // Restore original content
            chartContainer.innerHTML = originalContent;
            
            // Update the chart with new data (pass months parameter)
            updateRevenueChartData(data, months);
            
            // Show success notification
            showNotification(`Revenue chart updated for ${months} month${months > 1 ? 's' : ''} period`, 'success');
        })
        .catch(error => {
            console.error('Error fetching revenue data:', error);
            
            // Restore original content
            chartContainer.innerHTML = originalContent;
            
            // Show error notification
            showNotification('Error updating revenue chart data', 'danger');
        });
}

// Function to update revenue chart with new data
function updateRevenueChartData(monthlyRevenueData, monthsToShow = 12) {
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    
    // Destroy existing chart if it exists
    if (revenueChart) {
        revenueChart.destroy();
    }
    
    const colors = {
        primary: '#4F46E5',
        secondary: '#6366F1',
        success: '#10B981',
        warning: '#F59E0B',
        danger: '#EF4444',
        info: '#3B82F6',
        light: '#F8FAFC',
        dark: '#1F2937'
    };
    
    // Prepare data for specified number of months to ensure all months are displayed
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const chartLabels = [];
    const chartData = [];
    
    // Generate last N months labels and data based on monthsToShow parameter
    for (let i = monthsToShow - 1; i >= 0; i--) {
        const date = new Date();
        date.setMonth(date.getMonth() - i);
        const month = date.getMonth() + 1;
        const year = date.getFullYear();
        
        const label = monthNames[month - 1] + ' ' + year;
        chartLabels.push(label);
        
        // Find data for this month
        const monthData = monthlyRevenueData.find(item => 
            item.month === month && item.year === year
        );
        
        chartData.push(monthData ? parseFloat(monthData.revenue) : 0);
    }
    
    // Create new chart
    revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: chartData,
                borderColor: colors.primary,
                backgroundColor: colors.primary + '20',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colors.primary,
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Revenue: Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000) + 'Jt';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// Function to update customer growth chart based on filter
function updateCustomerGrowthChart() {
    const filterSelect = document.getElementById('customerGrowthChartFilter');
    const months = parseInt(filterSelect.value);
    
    // Show loading state
    const chartContainer = document.querySelector('#bookingsChart').parentElement;
    const originalContent = chartContainer.innerHTML;
    chartContainer.innerHTML = `
        <div class="d-flex justify-content-center align-items-center" style="height: 400px;">
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2">Memuat data...</div>
            </div>
        </div>
    `;
    
    // Fetch new data via AJAX
    fetch(`{{ route('admin.business-intelligence.customer-growth-data') }}?months=${months}`)
        .then(response => response.json())
        .then(data => {
            console.log('Updated Customer Growth Data:', data);
            
            // Restore original content
            chartContainer.innerHTML = originalContent;
            
            // Update the chart with new data (pass months parameter)
            updateCustomerGrowthChartData(data, months);
            
            // Show success notification
            showNotification(`Customer growth chart updated for ${months} month${months > 1 ? 's' : ''} period`, 'success');
        })
        .catch(error => {
            console.error('Error fetching customer growth data:', error);
            
            // Restore original content
            chartContainer.innerHTML = originalContent;
            
            // Show error notification
            showNotification('Error updating customer growth chart data', 'danger');
        });
}

// Function to update customer growth chart with new data
function updateCustomerGrowthChartData(customerGrowthData) {
    const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
    
    // Destroy existing chart if it exists
    if (customerGrowthChart) {
        customerGrowthChart.destroy();
    }
    
    const colors = {
        primary: '#4F46E5',
        secondary: '#6366F1',
        success: '#10B981',
        warning: '#F59E0B',
        danger: '#EF4444',
        info: '#3B82F6',
        light: '#F8FAFC',
        dark: '#1F2937'
    };
    
    // Create new chart
    customerGrowthChart = new Chart(bookingsCtx, {
        type: 'bar',
        data: {
            labels: customerGrowthData.length > 0 ? customerGrowthData.map(item => {
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                return months[item.month - 1] + ' ' + item.year;
            }) : ['No Data'],
            datasets: [{
                label: 'Pelanggan Baru',
                data: customerGrowthData.length > 0 ? customerGrowthData.map(item => item.count) : [0],
                backgroundColor: colors.success,
                borderColor: colors.success,
                borderWidth: 1,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Pelanggan Baru: ' + context.parsed.y + ' orang';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        callback: function(value) {
                            return value + ' orang';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// Dashboard Functions
function refreshDashboard() {
    showLoadingState();
    
    setTimeout(() => {
        document.getElementById('lastUpdated').textContent = new Date().toLocaleString('id-ID');
        hideLoadingState();
        showNotification('Dashboard berhasil diperbarui!', 'success');
    }, 2000);
}

function exportReport() {
    // Create modal for format selection
    const modalHtml = `
        <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exportModalLabel">
                            <i class="fas fa-download me-2"></i>📊 Ekspor Laporan Bisnis
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <h6 class="text-muted">Pilih format file yang sesuai dengan kebutuhan Anda:</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="export-option-card" onclick="exportToFormat('pdf')">
                                    <div class="export-icon">
                                        <i class="fas fa-file-pdf text-danger"></i>
                                    </div>
                                    <div class="export-details">
                                        <h6>📄 PDF</h6>
                                        <p class="text-muted small mb-0">Format laporan yang siap cetak dengan tampilan profesional</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="export-option-card" onclick="exportToFormat('excel')">
                                    <div class="export-icon">
                                        <i class="fas fa-file-excel text-success"></i>
                                    </div>
                                    <div class="export-details">
                                        <h6>📊 Excel</h6>
                                        <p class="text-muted small mb-0">Format spreadsheet dengan tabel dan grafik yang menarik</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="export-option-card" onclick="exportToFormat('csv')">
                                    <div class="export-icon">
                                        <i class="fas fa-file-csv text-primary"></i>
                                    </div>
                                    <div class="export-details">
                                        <h6>📋 CSV</h6>
                                        <p class="text-muted small mb-0">Format data mentah yang dapat diimpor ke aplikasi lain</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Add modal to body if not exists
    if (!document.getElementById('exportModal')) {
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        // Add CSS for export option cards
        const style = document.createElement('style');
        style.textContent = `
            .export-option-card {
                border: 2px solid #e9ecef;
                border-radius: 8px;
                padding: 20px;
                text-align: center;
                cursor: pointer;
                transition: all 0.3s ease;
                background: #f8f9fa;
            }
            .export-option-card:hover {
                border-color: #4F46E5;
                background: #ffffff;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
            }
            .export-icon {
                font-size: 2.5rem;
                margin-bottom: 15px;
            }
            .export-details h6 {
                margin-bottom: 8px;
                color: #333;
            }
        `;
        document.head.appendChild(style);
    }
    
    // Show modal
    const exportModal = new bootstrap.Modal(document.getElementById('exportModal'));
    exportModal.show();
}

function exportToFormat(format) {
    // Hide modal
    const exportModal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
    exportModal.hide();
    
    // Show loading notification
    showNotification('Mempersiapkan laporan untuk ekspor...', 'info');
    
    // Determine the export URL based on format
    let exportUrl;
    if (format === 'pdf') {
        exportUrl = '{{ route("admin.business-intelligence.export-pdf") }}';
    } else if (format === 'excel') {
        exportUrl = '{{ route("admin.business-intelligence.export-excel") }}';
    } else if (format === 'csv') {
        exportUrl = '{{ route("admin.business-intelligence.export-excel") }}' + '?export_format=csv';
    }
    
    // Create a temporary link and trigger download
    const downloadLink = document.createElement('a');
    downloadLink.href = exportUrl;
    downloadLink.style.display = 'none';
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
    
    // Show success notification
    setTimeout(() => {
        const formatNames = {
            'pdf': 'PDF',
            'excel': 'Excel',
            'csv': 'CSV'
        };
        const formatName = formatNames[format] || format.toUpperCase();
        showNotification(`Laporan ${formatName} berhasil diekspor! 🎉`, 'success');
    }, 1000);
}

function generateAIInsights() {
    const aiStatus = document.getElementById('aiStatus');
    const aiSpinner = document.getElementById('aiSpinner');
    const aiInsightsContainer = document.getElementById('aiInsightsContainer');
    
    // New prediction status elements
    const predictionStatus = document.getElementById('predictionStatus');
    const predictionSpinner = document.getElementById('predictionSpinner');
    const predictionIcon = document.getElementById('predictionIcon');
    
    // Show loading state
    aiSpinner.style.display = 'block';
    aiStatus.textContent = 'AI sedang menganalisis data bisnis...';
    
    // Show prediction loading state
    if (predictionSpinner) predictionSpinner.style.display = 'block';
    if (predictionIcon) predictionIcon.style.display = 'none';
    if (predictionStatus) predictionStatus.textContent = 'AI sedang memproses prediksi...';
    
    // Add visual feedback to prediction cards
    const predictionCards = document.querySelectorAll('.prediction-card');
    predictionCards.forEach(card => {
        card.style.opacity = '0.7';
        card.style.transform = 'scale(0.98)';
    });
    
    // Update status messages with realistic timing
    setTimeout(() => {
        aiStatus.textContent = 'Menganalisis pola pelanggan...';
    }, 1000);
    
    setTimeout(() => {
        aiStatus.textContent = 'Menghitung prediksi revenue...';
    }, 2000);
    
    setTimeout(() => {
        aiStatus.textContent = 'Menggenerate rekomendasi strategis...';
    }, 3000);
    
    // Make AJAX call to fetch AI insights
    fetch('{{ route("admin.business-intelligence.ai-insights") }}', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Hide loading state
        aiSpinner.style.display = 'none';
        
        if (data.success) {
            // Update status
            aiStatus.textContent = 'AI analysis selesai - Rekomendasi baru telah dihasilkan';
            
            // Update prediction status
            if (predictionSpinner) predictionSpinner.style.display = 'none';
            if (predictionIcon) {
                predictionIcon.style.display = 'block';
                predictionIcon.className = 'fas fa-check-circle text-success';
            }
            if (predictionStatus) predictionStatus.textContent = 'Prediksi AI berhasil dihasilkan dengan akurasi tinggi';
            
            // Restore prediction cards visual state
            const predictionCards = document.querySelectorAll('.prediction-card');
            predictionCards.forEach(card => {
                card.style.opacity = '1';
                card.style.transform = 'scale(1)';
            });
            
            // Render AI insights
            renderAIInsights(data.insights, data.metrics, data.calculationDetails);
            
            // Update prediction cards with real data
            updateAIPredictionCards(data);
            
            // Show success notification
            showNotification('AI telah menganalisis data dan memberikan rekomendasi terbaru!', 'success');
        } else {
            throw new Error(data.message || 'Failed to generate AI insights');
        }
    })
    .catch(error => {
        console.error('Error fetching AI insights:', error);
        
        // Hide loading state
        aiSpinner.style.display = 'none';
        aiStatus.textContent = 'Terjadi kesalahan saat menganalisis data';
        
        // Update prediction status for error
        if (predictionSpinner) predictionSpinner.style.display = 'none';
        if (predictionIcon) {
            predictionIcon.style.display = 'block';
            predictionIcon.className = 'fas fa-exclamation-triangle text-danger';
        }
        if (predictionStatus) predictionStatus.textContent = 'Terjadi kesalahan saat memproses prediksi';
        
        // Restore prediction cards visual state
        const predictionCards = document.querySelectorAll('.prediction-card');
        predictionCards.forEach(card => {
            card.style.opacity = '1';
            card.style.transform = 'scale(1)';
        });
        
        // Show error notification
        showNotification('Gagal menghasilkan AI insights. Silakan coba lagi.', 'danger');
    });
}

// Function to render AI insights in the UI
function renderAIInsights(insights, metrics, calculationDetails) {
    const aiInsightsContainer = document.getElementById('aiInsightsContainer');
    
    if (!aiInsightsContainer) {
        console.error('AI insights container not found');
        return;
    }
    
    // Clear existing content
    aiInsightsContainer.innerHTML = '';
    
    // Create insights HTML
    let insightsHtml = `
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="ai-icon me-3">
                                <i class="fas fa-brain text-primary"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">AI Strategic Insights</h5>
                                <p class="text-muted small mb-0">Generated at ${new Date().toLocaleString('id-ID')}</p>
                            </div>
                        </div>
                        
                        <div class="row g-3">
    `;
    
    // Add each insight as a card
    insights.forEach((insight, index) => {
        // Since insights are simple strings, we need to categorize them
        let insightType = 'default';
        let insightTitle = 'Business Insight';
        
        // Categorize based on content
        if (insight.includes('revenue') || insight.includes('Revenue') || insight.includes('Prediksi')) {
            insightType = 'revenue';
            insightTitle = 'AI Prediction';
        } else if (insight.includes('conversion') || insight.includes('Conversion')) {
            insightType = 'conversion';
            insightTitle = 'Conversion Rate';
        } else if (insight.includes('customer') || insight.includes('Customer') || insight.includes('Pelanggan')) {
            insightType = 'customer';
            insightTitle = 'Customer Insights';
        } else if (insight.includes('service') || insight.includes('Service') || insight.includes('pemesanan')) {
            insightType = 'service';
            insightTitle = 'Service Performance';
        } else if (insight.includes('Peak') || insight.includes('hours') || insight.includes('Tren')) {
            insightType = 'operational';
            insightTitle = 'Trend Analysis';
        }
        
        const iconClass = getInsightIcon(insightType);
        const cardColorClass = getInsightCardColor(insightType);
        
        insightsHtml += `
            <div class="col-md-6 col-lg-4">
                <div class="insight-card ${cardColorClass} h-100">
                    <div class="insight-header">
                        <i class="${iconClass} insight-icon"></i>
                        <h6 class="insight-title">${insightTitle}</h6>
                    </div>
                    <div class="insight-content">
                        <p class="insight-description">${insight}</p>
                    </div>
                </div>
            </div>
        `;
    });
    
    insightsHtml += `
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Add summary metrics if available
    if (metrics && Object.keys(metrics).length > 0) {
        insightsHtml += `
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="fas fa-chart-line text-info me-2"></i>
                                Key Metrics Summary
                            </h6>
                            <div class="row g-3">
        `;
        
        Object.entries(metrics).forEach(([key, value]) => {
            insightsHtml += `
                <div class="col-md-3 col-sm-6">
                    <div class="metric-summary-card">
                        <div class="metric-value">${value}</div>
                        <div class="metric-label">${key.replace(/_/g, ' ').toUpperCase()}</div>
                    </div>
                </div>
            `;
        });
        
        insightsHtml += `
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Set the HTML
    aiInsightsContainer.innerHTML = insightsHtml;
    
    // Populate calculation details table if available
    if (calculationDetails) {
        populateCalculationTable(calculationDetails);
    }
    
    // Add fade-in animation
    setTimeout(() => {
        aiInsightsContainer.classList.add('fade-in');
    }, 100);
}

// Function to update AI prediction cards with real data
function updateAIPredictionCards(data) {
    console.log('Updating AI prediction cards with data:', data);
    
    // Update prediction cards if data is available
    if (data && data.success && data.predictions) {
        const predictions = data.predictions;
        console.log('Predictions data:', predictions);
        
        // Update revenue prediction
        if (predictions.nextMonthRevenue !== undefined) {
            const revenueElement = document.getElementById('predictedRevenue');
            if (revenueElement) {
                const formattedRevenue = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(predictions.nextMonthRevenue);
                revenueElement.textContent = formattedRevenue;
                revenueElement.className = 'prediction-value text-primary mb-2'; // Updated class
                console.log('Updated revenue:', formattedRevenue);
            }
        }
        
        // Update bookings prediction
        if (predictions.nextMonthBookings !== undefined) {
            const bookingsElement = document.getElementById('predictedBookings');
            if (bookingsElement) {
                const roundedBookings = Math.round(predictions.nextMonthBookings);
                bookingsElement.textContent = roundedBookings;
                bookingsElement.className = 'prediction-value text-success mb-2'; // Updated class
                console.log('Updated bookings:', roundedBookings);
            }
        }
        
        // Update customers prediction
        if (predictions.nextMonthCustomers !== undefined) {
            const customersElement = document.getElementById('predictedCustomers');
            if (customersElement) {
                const roundedCustomers = Math.round(predictions.nextMonthCustomers);
                customersElement.textContent = roundedCustomers;
                customersElement.className = 'prediction-value text-warning mb-2'; // Updated class
                console.log('Updated customers:', roundedCustomers);
            }
        }
        
        // Update growth trend
        if (predictions.revenueGrowthTrend !== undefined) {
            const trendElement = document.getElementById('growthTrend');
            if (trendElement) {
                const trend = predictions.revenueGrowthTrend;
                trendElement.textContent = (trend >= 0 ? '+' : '') + trend.toFixed(1) + '%';
                
                // Update color based on trend
                trendElement.className = trend >= 0 ? 'prediction-value text-success mb-2' : 'prediction-value text-danger mb-2';
                console.log('Updated growth trend:', trend);
            }
        }
    } else {
        console.log('No predictions data available or data structure invalid');
    }
}

// Function to populate the calculation details table
function populateCalculationTable(calculationDetails) {
    const tableBody = document.getElementById('aiCalculationTable');
    
    if (!tableBody) {
        console.error('AI calculation table not found');
        return;
    }
    
    // Clear existing content
    tableBody.innerHTML = '';
    
    // Check if calculationDetails exists and is valid
    if (!calculationDetails || typeof calculationDetails !== 'object') {
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">Detail perhitungan tidak tersedia</td></tr>';
        return;
    }
    
    // Populate table with calculation details
    let rowNumber = 1;
    Object.entries(calculationDetails).forEach(([key, details]) => {
        if (details && details.breakdown && Array.isArray(details.breakdown)) {
            details.breakdown.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="text-center">
                        <span class="row-number">${rowNumber}</span>
                    </td>
                    <td><strong>${details.type || 'Unknown'}</strong></td>
                    <td>${item.month || 'N/A'}</td>
                    <td>${typeof item.value === 'number' ? item.value.toLocaleString('id-ID') : (item.value || 'N/A')}</td>
                    <td class="text-center">${item.weight || 'N/A'}</td>
                    <td>${typeof item.weighted_value === 'number' ? item.weighted_value.toLocaleString('id-ID', {maximumFractionDigits: 0}) : 'N/A'}</td>
                    <td class="text-center">
                        <span class="contribution-percentage">${item.percentage || 'N/A'}%</span>
                    </td>
                `;
                tableBody.appendChild(row);
                rowNumber++;
            });
            
            // Add separator row with clear formula and result
            const separatorRow = document.createElement('tr');
            const formula = details.formula || 'Tidak tersedia';
            const prediction = typeof details.prediction === 'number' ? details.prediction : 0;
            const formattedPrediction = prediction.toLocaleString('id-ID', {maximumFractionDigits: 0});
            
            separatorRow.innerHTML = `
                <td colspan="7" class="table-primary text-center small">
                    <strong>Formula:</strong> ${formula}<br>
                    <strong>Hasil Prediksi:</strong> ${formattedPrediction} (${details.type})
                </td>
            `;
            tableBody.appendChild(separatorRow);
        }
    });
    
    // If no data was added, show a message
    if (tableBody.children.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">Tidak ada data perhitungan yang tersedia</td></tr>';
    }
}

// Helper function to get appropriate icon for insight type
function getInsightIcon(type) {
    const iconMap = {
        'conversion': 'fas fa-chart-line',
        'operational': 'fas fa-cogs',
        'satisfaction': 'fas fa-smile',
        'growth': 'fas fa-trending-up',
        'revenue': 'fas fa-dollar-sign',
        'customer': 'fas fa-users',
        'service': 'fas fa-concierge-bell',
        'default': 'fas fa-lightbulb'
    };
    
    return iconMap[type] || iconMap['default'];
}

// Helper function to get appropriate card color for insight type
function getInsightCardColor(type) {
    const colorMap = {
        'conversion': 'insight-card-primary',
        'operational': 'insight-card-warning',
        'satisfaction': 'insight-card-success',
        'growth': 'insight-card-info',
        'revenue': 'insight-card-success',
        'customer': 'insight-card-primary',
        'service': 'insight-card-secondary',
        'default': 'insight-card-light'
    };
    
    return colorMap[type] || colorMap['default'];
}


function toggleChartView(chartType) {
    showNotification(`Toggled ${chartType} chart view`, 'info');
}

function showLoadingState() {
    document.querySelectorAll('button').forEach(btn => {
        if (btn.onclick) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
        }
    });
}

function hideLoadingState() {
    setTimeout(() => {
        location.reload();
    }, 500);
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Initialize fade-in animations
document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    });

    document.querySelectorAll('.fade-in').forEach(el => {
        observer.observe(el);
    });
    
    setTimeout(() => {
        checkAndFixIcons();
    }, 500);
});

// Function to check and fix missing icons
function checkAndFixIcons() {
    const iconElements = document.querySelectorAll('.kpi-icon i');
    
    iconElements.forEach(icon => {
        const computedStyle = window.getComputedStyle(icon, ':before');
        if (computedStyle.fontFamily.indexOf('Font Awesome') === -1) {
            if (icon.classList.contains('fa-users')) {
                icon.className = 'bi bi-people-fill';
            } else if (icon.classList.contains('fa-chart-line')) {
                icon.className = 'bi bi-graph-up';
            } else if (icon.classList.contains('fa-percentage')) {
                icon.className = 'bi bi-percent';
            } else if (icon.classList.contains('fa-heart')) {
                icon.className = 'bi bi-heart-fill';
            } else if (icon.classList.contains('fa-arrow-up')) {
                icon.className = 'bi bi-arrow-up';
            } else if (icon.classList.contains('fa-arrow-down')) {
                icon.className = 'bi bi-arrow-down';
            }
        }
    });
    
    const allIcons = document.querySelectorAll('i[class*="fa-"]');
    allIcons.forEach(icon => {
        if (icon.offsetWidth === 0 && icon.offsetHeight === 0) {
            icon.style.display = 'inline-block';
            icon.style.width = '1em';
            icon.style.height = '1em';
            icon.style.fontFamily = 'bootstrap-icons';
        }
    });
}
</script>
