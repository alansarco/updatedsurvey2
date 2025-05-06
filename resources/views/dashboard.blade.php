@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="row mb-4">
            <div class="col-12">
                @if(!$hasSubmitted)
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div>
                            You haven't submitted your graduate survey yet.
                            <a href="{{ route('graduates.create') }}" class="alert-link ms-2">Fill it up now!</a>
                        </div>
                    </div>
                @else
                    <div class="alert alert-success d-flex align-items-center justify-content-between" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>
                                Thank you! You have already submitted your graduate survey.
                                <a href="{{ route('graduates.edit', auth()->user()->graduate->id) }}"
                                    class="alert-link ms-2">Would you like to edit it?</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @if(!auth()->user()->email === 'admin@gmail.com')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const hasSubmitted = {{ $hasSubmitted ? 'true' : 'false' }};
                    if (hasSubmitted) {
                        const surveyLink = document.querySelector('a[href="{{ route('graduates.create') }}"]');
                        if (surveyLink) {
                            surveyLink.parentElement.style.display = 'none';
                        }
                    }
                });
            </script>
        @endif
        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-2">Total Graduates</h6>
                                <h2 class="mb-0">{{ $totalGraduates }}</h2>
                            </div>
                            <i class="bi bi-people-fill fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-2">Employment Rate</h6>
                                <h2 class="mb-0">{{ $employmentRate }}%</h2>
                            </div>
                            <i class="bi bi-graph-up fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Survey Response Rate Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-2">Response Rate</h6>
                                <h2 class="mb-0">{{ $surveyStats['responseRate'] }}%</h2>
                            </div>
                            <i class="bi bi-clipboard-check fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Department Quick Links -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Department Links</h5>
                </div>
                <div class="card-body">
                    @foreach($departments as $category => $items)
                        <h6 class="text-muted mb-3">{{ $category }}</h6>
                        <div class="row g-3 mb-4">
                            @foreach($items as $dept)
                                <div class="col-md-3 col-sm-6">
                                    <a href="{{$dept['link']}}">
                                        <div class="card h-100 border-0 bg-light">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                                        <i class="bi {{ $dept['icon'] }} text-primary fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">{{ $dept['name'] }}</h6>
                                                        <small class="text-muted">{{ $dept['desc'] }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-xl-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Graduates by Year</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="graduatesChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!--<div class="col-xl-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Employment Status</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="employmentChart" height="300"></canvas>
                                </div>
                            </div>
                        </div>-->

            <!-- Survey Response Chart -->
            <div class="col-xl-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Survey Responses</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="surveyChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graduates List -->
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Graduates</h5>
                @if(!$hasSubmitted && !auth()->user()->is_admin)
                    <a href="{{ route('graduates.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add New
                    </a>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Year</th>
                                <th>Employment</th>
                                <th>Facebook</th>
                                <th>Contact</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $graduate)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($graduate->photo)
                                                <img src="{{ asset('storage/' . $graduate->photo) }}" class="rounded-circle me-2"
                                                    width="32" height="32" style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2"
                                                    style="width: 32px; height: 32px;">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $graduate->user->name }}</div>
                                                <div class="small text-muted">{{ $graduate->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $graduate->graduation_year }}</td>
                                    <td>
                                        @php
                                            if ($graduate->employed == 1)
                                                $employement_status = "employed";
                                            else if ($graduate->employed == 2)
                                                $employement_status = "self-employed";
                                            else
                                                $employement_status = "unemployed";
                                        @endphp
                                        <span
                                            class="badge bg-{{ $graduate->employed == 1 ? 'success' : ($graduate->employed == 2 ? 'primary' : 'secondary') }}">
                                            {{ ucfirst($employement_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($graduate->facebook)
                                            <a href="https://facebook.com/{{ $graduate->facebook }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-facebook"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="small text-muted">
                                            <i class="bi bi-phone me-1"></i>
                                            {{ $graduate->phone_number }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Graduates by Year Chart
                new Chart(document.getElementById('graduatesChart'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($graduatesByYear->pluck('graduation_year')) !!},
                        datasets: [{
                            label: 'Number of Graduates',
                            data: {!! json_encode($graduatesByYear->pluck('total')) !!},
                            backgroundColor: '#4e73df',
                            borderRadius: 4
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
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });

                // Employment Status Chart
                new Chart(document.getElementById('employmentChart'), {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($employmentStatus->pluck('current_employment')) !!},
                        datasets: [{
                            data: {!! json_encode($employmentStatus->pluck('total')) !!},
                            backgroundColor: ['#1cc88a', '#36b9cc', '#e74a3b']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        cutout: '60%'
                    }
                });

                // Survey Response Chart
                new Chart(document.getElementById('surveyChart'), {
                    type: 'bar',
                    data: {
                        labels: ['Responded', 'Not Responded'],
                        datasets: [{
                            data: [
                                                                                                                                    {{ $surveyStats['responded'] }},
                                {{ $surveyStats['notResponded'] }}
                            ],
                            backgroundColor: ['#36b9cc', '#e74a3b'],
                            borderRadius: 4
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
                                ticks: { stepSize: 1 }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection