<style>
    :root {
        --primary-color: #667eea;
        --secondary-color: #764ba2;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --info-color: #3B82F6;
        --light-color: #F8FAFC;
        --dark-color: #1F2937;
        --owner-color: #667eea;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    body {
        background-color: var(--light-color);
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--dark-color);
    }

    .dashboard-header {
        background: linear-gradient(135deg, var(--owner-color), var(--secondary-color));
        color: white;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
    }

    .dashboard-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .dashboard-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    .dashboard-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .dashboard-actions .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .dashboard-actions .btn-light {
        background: rgba(255, 255, 255, 0.95);
        color: var(--owner-color);
    }

    .dashboard-actions .btn-light:hover {
        background: white;
        color: var(--owner-color);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .kpi-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        border: 1px solid rgba(102, 126, 234, 0.1);
        border-left: 4px solid var(--owner-color);
    }

    .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-left-color: var(--owner-color);
        border-color: rgba(102, 126, 234, 0.2);
    }

    .kpi-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        position: relative;
        overflow: hidden;
        margin: 0 auto 1rem auto;
        color: var(--owner-color);
    }

    .kpi-icon::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, currentColor, currentColor);
        opacity: 0.1;
        border-radius: 16px;
    }

    .kpi-icon i {
        position: relative;
        z-index: 1;
        font-size: 1.8rem;
        display: block;
    }

    /* Fallback for missing icons */
    .kpi-icon i::before {
        display: inline-block;
        font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "bootstrap-icons";
        font-weight: 900;
        font-style: normal;
        font-variant: normal;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
    }

    /* Ensure icons are visible */
    .kpi-icon i {
        min-width: 1em;
        min-height: 1em;
        line-height: 1;
        text-align: center;
    }

    /* FontAwesome backup */
    .fas, .far, .fal, .fab {
        font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "FontAwesome" !important;
        font-weight: 900;
        font-style: normal;
    }

    /* Bootstrap Icons backup */
    .bi {
        font-family: "bootstrap-icons" !important;
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
    }

    .kpi-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .kpi-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .kpi-change {
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .kpi-change.positive {
        color: var(--success-color);
    }

    .kpi-change.negative {
        color: var(--danger-color);
    }

    .chart-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
        border: 1px solid rgba(102, 126, 234, 0.1);
        border-top: 3px solid var(--owner-color);
        transition: all 0.3s ease;
    }

    .chart-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(102, 126, 234, 0.2);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #E5E7EB;
    }

    .chart-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark-color);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .chart-title i {
        color: var(--dark-color);
    }
    
    .chart-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .chart-actions .form-select {
        border: 1px solid #E5E7EB;
        border-radius: 6px;
        padding: 0.375rem 2rem 0.375rem 0.75rem;
        font-size: 0.875rem;
        background-color: white;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .chart-actions .form-select:focus {
        border-color: var(--owner-color);
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .chart-actions .form-select:hover {
        border-color: #D1D5DB;
    }

    .chart-container {
        position: relative;
        height: 400px;
        margin-bottom: 1rem;
    }

    .chart-container canvas {
        border-radius: 8px;
    }
    
    .chart-info {
        border-top: 1px solid #E5E7EB;
        padding-top: 1rem;
    }
    
    .chart-info .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .chart-info .info-item i {
        font-size: 0.875rem;
        flex-shrink: 0;
    }
    
    .chart-info .info-item small {
        font-size: 0.75rem;
        line-height: 1.4;
    }

    .insights-section {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
        border: 1px solid rgba(102, 126, 234, 0.1);
        border-left: 4px solid var(--owner-color);
    }

    .insights-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .insights-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--dark-color);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .insights-title i {
        color: var(--dark-color);
    }

    .insight-item {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        border-left: 4px solid;
        transition: all 0.3s ease;
    }

    .insight-item:hover {
        transform: translateX(4px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .insight-item.critical {
        border-left-color: var(--danger-color);
        background: rgba(239, 68, 68, 0.05);
    }

    .insight-item.warning {
        border-left-color: var(--warning-color);
        background: rgba(245, 158, 11, 0.05);
    }

    .insight-item.success {
        border-left-color: var(--success-color);
        background: rgba(16, 185, 129, 0.05);
    }

    .insight-item.info {
        border-left-color: var(--info-color);
        background: rgba(59, 130, 246, 0.05);
    }

    .insight-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark-color);
    }

    .insight-description {
        color: #6B7280;
        font-size: 0.875rem;
        line-height: 1.5;
    }

    .metric-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .chart-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Timeline Styles */
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }

    .timeline-marker {
        position: absolute;
        left: -23px;
        top: 5px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 0 0 2px #e5e7eb;
    }

    .timeline-content {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid #e5e7eb;
    }

    .timeline-content h6 {
        color: var(--dark-color);
        margin-bottom: 0.5rem;
    }

    .timeline-content p {
        margin-bottom: 0.5rem;
        color: #6B7280;
    }

    /* AI Confidence Indicators */
    .ai-confidence {
        background: rgba(0, 0, 0, 0.02);
        padding: 0.5rem;
        border-radius: 6px;
        margin-top: 1rem;
    }

    .ai-status .spinner-border {
        width: 1rem;
        height: 1rem;
    }

    /* Enhanced insight items */
    .insight-item {
        margin-bottom: 0;
    }

    .insight-item .insight-title {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .insight-item .insight-description {
        font-size: 0.8rem;
        line-height: 1.4;
    }

    /* Enhanced Prediction Cards */
    .prediction-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    .prediction-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        border-color: rgba(102, 126, 234, 0.2);
    }
    
    .prediction-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--owner-color);
        border-radius: 16px 16px 0 0;
    }
    
    .prediction-number {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 32px;
        height: 32px;
        background: var(--owner-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        z-index: 10;
    }
    
    .prediction-content {
        text-align: center;
        position: relative;
        z-index: 1;
    }
    
    .prediction-icon-wrapper {
        width: 60px;
        height: 60px;
        margin: 0 auto 1rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: 2px solid rgba(102, 126, 234, 0.2);
        transition: all 0.3s ease;
    }
    
    .prediction-card:hover .prediction-icon-wrapper {
        transform: scale(1.1);
        background: transparent;
    }
    
    .prediction-icon-wrapper i {
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .prediction-value {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .prediction-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .prediction-description {
        font-size: 0.75rem;
        color: #6B7280;
        line-height: 1.4;
        margin-bottom: 0;
    }
    
    /* Purple header for prediction section */
    .bg-gradient-primary {
        background: var(--owner-color) !important;
    }
    
    .prediction-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }
    
    /* Status indicator */
    .prediction-status-indicator {
        position: relative;
    }
    
    #predictionSpinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    
    #predictionIcon {
        transition: all 0.3s ease;
    }
    
    #predictionIcon.success {
        color: var(--success-color) !important;
    }
    
    /* Value color transitions */
    .prediction-value.text-primary {
        color: var(--primary-color) !important;
    }
    
    .prediction-value.text-success {
        color: var(--success-color) !important;
    }
    
    .prediction-value.text-warning {
        color: var(--warning-color) !important;
    }
    
    .prediction-value.text-info {
        color: var(--info-color) !important;
    }
    
    .prediction-value.text-danger {
        color: var(--danger-color) !important;
    }
    
    /* Card number colors - All purple */
    .prediction-card:nth-child(1) .prediction-number {
        background: var(--owner-color);
    }
    
    .prediction-card:nth-child(2) .prediction-number {
        background: var(--owner-color);
    }
    
    .prediction-card:nth-child(3) .prediction-number {
        background: var(--owner-color);
    }
    
    .prediction-card:nth-child(4) .prediction-number {
        background: var(--owner-color);
    }
    
    /* Enhanced Calculation Table Styling */
    .calculation-table-wrapper {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .calculation-table {
        margin: 0;
        border: none;
        font-size: 0.9rem;
    }
    
    .calculation-table thead {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }
    
    .calculation-table th {
        border: none;
        padding: 1rem 0.75rem;
        font-weight: 600;
        color: #374151;
        text-align: center;
        vertical-align: middle;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .calculation-table td {
        border: none;
        padding: 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        text-align: center;
    }
    
    .calculation-table tbody tr:hover {
        background-color: #f8fafc;
        transition: background-color 0.3s ease;
    }
    
    .calculation-table tbody tr:nth-child(even) {
        background-color: #fafbfc;
    }
    
    .calculation-table tbody tr:nth-child(even):hover {
        background-color: #f1f5f9;
    }
    
    /* Column specific styling */
    .calculation-table .number-col {
        width: 60px;
        text-align: center;
    }
    
    .calculation-table .metric-col {
        width: 120px;
        text-align: left;
    }
    
    .calculation-table .month-col {
        width: 80px;
        text-align: center;
    }
    
    .calculation-table .value-col {
        width: 150px;
        text-align: right;
    }
    
    .calculation-table .weight-col {
        width: 80px;
        text-align: center;
    }
    
    .calculation-table .weighted-col {
        width: 150px;
        text-align: right;
    }
    
    .calculation-table .contribution-col {
        width: 100px;
        text-align: center;
    }
    
    /* Row number styling */
    .row-number {
        display: inline-block;
        width: 24px;
        height: 24px;
        background: var(--owner-color);
        color: white;
        border-radius: 50%;
        line-height: 24px;
        font-size: 0.8rem;
        font-weight: 600;
        text-align: center;
    }
    
    /* Header content alignment */
    .th-content {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .th-content i {
        font-size: 0.9rem;
    }
    
    /* Calculation section styling */
    .calculation-title {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .calculation-icon-wrapper {
        width: 48px;
        height: 48px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--owner-color);
        font-size: 1.5rem;
    }
    
    /* Explanation styling */
    .calculation-explanation {
        margin-top: 2rem;
    }
    
    .explanation-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .explanation-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 1.1rem;
        color: #374151;
    }
    
    .explanation-content {
        color: #6b7280;
        line-height: 1.6;
    }
    
    .highlight {
        background: rgba(220, 38, 38, 0.1);
        color: #DC2626;
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        font-weight: 600;
    }
    
    .example-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .example-list li {
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .weight-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        color: white;
    }
    
    .weight-badge.newest {
        background: #10b981;
    }
    
    .weight-badge.middle {
        background: #f59e0b;
    }
    
    .weight-badge.oldest {
        background: #ef4444;
    }
    
    .formula-section {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }
    
    .formula-box {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 0.5rem;
    }
    
    .formula-code {
        background: none;
        color: #374151;
        font-size: 0.9rem;
        padding: 0;
        border: none;
        font-family: 'Courier New', monospace;
    }
    
    /* Text purple class */
    .text-purple {
        color: #8b5cf6 !important;
    }
    
    /* Contribution percentage styling */
    .contribution-percentage {
        display: inline-block;
        background: rgba(139, 92, 246, 0.1);
        color: #8b5cf6;
        padding: 0.3rem 0.6rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        min-width: 50px;
        text-align: center;
    }
    
    /* Separator row styling */
    .calculation-table .table-primary {
        background: linear-gradient(135deg, #667eea, #764ba2) !important;
        color: white !important;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.5rem;
        }
        
        .dashboard-header h1 {
            font-size: 2rem;
        }
        
        .kpi-card {
            padding: 1.5rem;
        }
        
        .chart-container {
            height: 300px;
        }
        
        .chart-grid {
            grid-template-columns: 1fr;
        }

        .timeline {
            padding-left: 20px;
        }

        .timeline-marker {
            left: -18px;
        }
        
        .prediction-card {
            padding: 1.25rem;
        }
        
        .prediction-value {
            font-size: 1.5rem;
        }
        
        .prediction-icon-wrapper {
            width: 50px;
            height: 50px;
        }
        
        .prediction-icon-wrapper i {
            font-size: 1.25rem;
        }
    }
</style>

