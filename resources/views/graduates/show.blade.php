@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Graduate Details</h4>
            <a href="{{ route('graduates.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    @if($graduate->photo)
                        <img src="{{ asset('storage/' . $graduate->photo) }}" 
                             alt="Graduate photo" 
                             class="rounded-circle img-thumbnail"
                             style="width: 200px; height: 200px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto"
                             style="width: 200px; height: 200px;">
                            <i class="bi bi-person-circle fs-1"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <dl class="row">
                        <dt class="col-sm-3">Name</dt>
                        <dd class="col-sm-9">{{ $graduate->user->name }}</dd>

                        <dt class="col-sm-3">Phone Number</dt>
                        <dd class="col-sm-9">{{ $graduate->phone_number }}</dd>

                        <dt class="col-sm-3">Gender</dt>
                        <dd class="col-sm-9">{{ ucfirst($graduate->gender) }}</dd>

                        <dt class="col-sm-3">Year Graduated</dt>
                        <dd class="col-sm-9">{{ $graduate->graduation_year }}</dd>

                        <dt class="col-sm-3">Facebook</dt>
                        <dd class="col-sm-9">{{ $graduate->facebook }}</dd>

                        <dt class="col-sm-3">Employment Status</dt>
                        <dd class="col-sm-9">
                            <span class="badge bg-{{ $graduate->employed ? 'success' : 'secondary' }}">
                                {{ $graduate->current_employment }}
                            </span>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
