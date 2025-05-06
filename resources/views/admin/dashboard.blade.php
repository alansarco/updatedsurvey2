@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="mb-4">
            <div class="row">
                <div class="col-xl-5 col-lg-3 col-md-12">
                    <h1 class="h3 mb-0 text-nowrap">Admin Dashboard</h1>
                </div>
                <div class="col-xl-7 col-lg-9 col-md-12">
                    <div class="d-flex">
                        <form method="GET" action="{{ route('admin.dashboard') }}" class="w-100 me-2">
                            @php
                                $currentYear = date('Y');
                                $startYear = 1950;
                                $selectedFromYear = request('year1', $currentYear); // Default to current year
                                $selectedToYear = request('year', $currentYear);   // Default to current year
                            @endphp

                            <div class="d-flex">
                            {{-- From Year --}}
                            <div class="input-group me-2">
                                <span class="input-group-text">From Year</span>
                                <select class="form-control form-control-select" id="yearSelect1" name="year1" onchange="this.form.submit()">
                                    @for ($year = $currentYear; $year >= $startYear; $year--)
                                        <option value="{{ $year }}" {{ $selectedFromYear == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            {{-- To Year --}}
                            <div class="input-group">
                                <span class="input-group-text">To Year</span>
                                <select class="form-control form-control-select" id="yearSelect" name="year" onchange="this.form.submit()">
                                    @for ($year = $currentYear; $year >= $selectedFromYear; $year--)
                                        <option value="{{ $year }}" {{ $selectedToYear == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            </div>

                            
                        </form>

                        <a href="{{ route('admin.export') }}" class="btn btn-success text-nowrap">
                            <i class="bi bi-download"></i> Export CSV
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Graduates</div>
                                <div class="h5 mb-0 font-weight-bold">{{ $totalGraduates }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-people fs-1 text-black-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Employment Rate</div>
                                <div class="h5 mb-0 font-weight-bold">{{ $employmentRate }}%</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-graph-up fs-1 text-black-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New "Is CPE Related?" card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Is CPE Related?</div>
                                <div class="h5 mb-0 font-weight-bold">{{ $cpeRelatedPercentage ?? '0' }}%</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-check-circle fs-1 text-black-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New "Is Life-long Learners Related?" card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Life-long Learners
                                </div>
                                <div class="h5 mb-0 font-weight-bold">{{ $lifelongLearners ?? '0' }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-people fs-1 text-black-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Year Selection and Graduate Stats -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-light mb-3">
                            <div class="card-body py-2">
                                <h6 class="m-0">EMPLOYED: {{ $employedCount ?? 0 }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light mb-3">
                            <div class="card-body py-2">
                                <h6 class="m-0">UNEMPLOYED: {{ $unemployedCount ?? 0 }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light mb-3">
                            <div class="card-body py-2">
                                <h6 class="m-0">SELF-EMPLOYED: {{ $selfEmployedCount ?? 0 }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Employment by Graduation Year</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="yearlyChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Gender Distribution</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Yearly Employment Chart
            const yearlyData = @json($employmentByYear);
            new Chart(document.getElementById('yearlyChart'), {
                type: 'bar',
                data: {
                    labels: yearlyData.map(d => d.graduation_year),
                    datasets: [
                        {
                            label: 'Total Graduates',
                            data: yearlyData.map(d => d.total),
                            backgroundColor: '#4e73df'
                        },
                        {
                            label: 'Employed',
                            data: yearlyData.map(d => d.unemployed),
                            backgroundColor: '#1cc88a'
                        },
                        {
                            label: 'Unemployed',
                            data: yearlyData.map(d => d.employed),
                            backgroundColor: '#F4A261'
                        },
                        {
                            label: 'Self-Employed',
                            data: yearlyData.map(d => d.self_employed),
                            backgroundColor: '#D88FA0'
                        },
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });

            // Gender Distribution Chart
            const genderData = @json($genderDistribution);
            new Chart(document.getElementById('genderChart'), {
                type: 'doughnut',
                data: {
                    labels: genderData.map(d => d.gender.toUpperCase()),
                    datasets: [{
                        data: genderData.map(d => d.count),
                        backgroundColor: ['#4e73df', '#1cc88a']
                    }]
                }
            });

            let employmentChart;
            let trendChart;

            function initCharts(data) {
                // Pie Chart for Employment Status
                const ctxPie = document.getElementById('employmentChart').getContext('2d');
                employmentChart = new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: ['Employed', 'Self-Employed', 'Unemployed'],
                        datasets: [{
                            data: [data.employed, data.selfEmployed, data.unemployed],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(255, 99, 132, 0.8)'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            title: {
                                display: true,
                                text: 'Employment Status Distribution'
                            }
                        }
                    }
                });

                // Line Chart for Trend
                const ctxLine = document.getElementById('trendChart').getContext('2d');
                trendChart = new Chart(ctxLine, {
                    type: 'line',
                    data: {
                        labels: data.months,
                        datasets: [{
                            label: 'Employed',
                            data: data.employedTrend,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            fill: false
                        },
                        {
                            label: 'Self-Employed',
                            data: data.selfEmployedTrend,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            fill: false
                        },
                        {
                            label: 'Unemployed',
                            data: data.unemployedTrend,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            title: {
                                display: true,
                                text: 'Employment Trend by Month'
                            }
                        }
                    }
                });
            }

            function updateCharts(year) {
                fetch(`/admin/employment-stats/${year}`)
                    .then(response => response.json())
                    .then(data => {
                        // Update pie chart
                        employmentChart.data.datasets[0].data = [
                            data.employed,
                            data.selfEmployed,
                            data.unemployed
                        ];
                        employmentChart.update();

                        // Update trend chart
                        trendChart.data.labels = data.months;
                        trendChart.data.datasets[0].data = data.employedTrend;
                        trendChart.data.datasets[1].data = data.selfEmployedTrend;
                        trendChart.data.datasets[2].data = data.unemployedTrend;
                        trendChart.update();
                    });
            }

            // Initialize charts with current year data
            fetch(`/admin/employment-stats/${new Date().getFullYear()}`)
                .then(response => response.json())
                .then(data => initCharts(data));

            // Handle year selection change
            document.getElementById('yearSelect').addEventListener('change', function () {
                updateCharts(this.value);
            });
        });
    </script>
@endsection