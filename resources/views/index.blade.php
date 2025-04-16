<?php $page = 'index'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
        <!-- Greeting Section -->
        <!-- Greeting Section -->
<style>
    /* Dashboard Styles */
.dashboard-container {
    padding: 1.5rem;
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

/* Greeting Section */
.greeting-section {
    background: linear-gradient(135deg,rgb(99, 111, 241),rgb(0, 237, 114));
    color: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.greeting-section h1 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: white;
}

.current-date {
    font-size: 1rem;
    opacity: 0.9;
}

/* Stats Cards */
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1rem;
}

.stat-card {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s, box-shadow 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.5rem;
}

.stat-card:nth-child(1) .stat-icon {
    background: rgba(99, 102, 241, 0.1);
    color: #6366f1;
}

.stat-card:nth-child(2) .stat-icon {
    background: rgba(234, 88, 12, 0.1);
    color: #ea580c;
}

.stat-card:nth-child(3) .stat-icon {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.stat-card:nth-child(4) .stat-icon {
    background: rgba(249, 115, 22, 0.1);
    color: #f97316;
}

.stat-info h3 {
    font-size: 0.875rem;
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

/* Charts Section */
.charts-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
}

.chart-card {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.chart-card h3 {
    font-size: 1.1rem;
    color: #374151;
    margin-bottom: 1.5rem;
    font-weight: 600;
}

.chart-container {
    height: 300px;
    position: relative;
}

/* Recent Transactions */
.recent-section {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.recent-section h2 {
    font-size: 1.25rem;
    color: #1f2937;
    margin-bottom: 1.25rem;
    font-weight: 600;
}

.table-responsive {
    overflow-x: auto;
}

.recent-table {
    width: 100%;
    border-collapse: collapse;
}

.recent-table th {
    text-align: left;
    padding: 0.75rem 1rem;
    background: #f9fafb;
    font-weight: 600;
    color: #4b5563;
    font-size: 0.875rem;
}

.recent-table td {
    padding: 0.75rem 1rem;
    border-top: 1px solid #e5e7eb;
    color: #374151;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-completed {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.status-pending {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

.status-canceled {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .charts-section {
        grid-template-columns: 1fr;
    }

    .stats-container {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
}

@media (max-width: 640px) {
    .stats-container {
        grid-template-columns: 1fr;
    }
}
</style>
    <div class="dashboard-container">
        <!-- Greeting Section -->
        <div class="greeting-section">
            <h1>Welcome, {{ Auth::user()->name ?? 'User' }}!</h1>
            <p class="current-date">{{ now()->format('l, d F Y') }}</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-box"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Products</h3>
                    <p class="stat-value">{{ $totalProducts ?? 0 }}</p> <!-- Updated to count Products -->
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Members</h3> <!-- Changed label from "Total Pelanggan" to "Total Member" -->
                    <p class="stat-value">{{ $totalMembers ?? 0 }}</p> <!-- Updated variable -->
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <div class="chart-card">
                <h3> Number of Products Sold Per Day</h3>
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3>Best Selling Products</h3>
                <div class="chart-container">
                    <canvas id="productsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Sales Chart
                const salesCtx = document.getElementById('salesChart').getContext('2d');
                const salesChart = new Chart(salesCtx, {
                    type: 'line',
                    data: {
                        labels: @json($dayLabels),
                        datasets: [{
                            label: 'Jumlah Produk Terjual',
                            data: @json($salesData),
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value + ' produk';
                                    }
                                }
                            }
                        }
                    }
                });

                // Products Chart
                const productsCtx = document.getElementById('productsChart').getContext('2d');
                const productsChart = new Chart(productsCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($productNames),
                        datasets: [{
                            label: 'Total Terjual',
                            data: @json($productSaless),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(153, 102, 255, 0.7)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            });
        </script>
    @endpush

        </div>
    </div>
@endsection