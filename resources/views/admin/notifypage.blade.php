@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Notify Graduate</h1>
        <!-- Year Filter Dropdown -->
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            
        <div class="d-flex">
            <!-- Excel Upload Form -->
            <form action="{{ route('admin.graduates.notify') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <label for="lifelong_learner" class="form-label">Upload Excel:</label>
                    <input type="file" name="excel_file" class="form-control border p-2" accept=".xlsx,.xls" required>
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    
</script>
@endpush
@endsection
