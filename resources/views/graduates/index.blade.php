@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">Graduates List</h2>
        <a href="{{ route('graduates.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Graduate
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($graduates->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-people fs-1 text-muted"></i>
                    <p class="mt-2">No graduates found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Year Graduated</th>
                                <th>Status</th>
                                @if(auth()->user()->email === 'admin@gmail.com')
                                <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($graduates as $graduate)
                            <tr>
                                <td>
                                    @if($graduate->photo)
                                        <img src="{{ asset('storage/' . $graduate->photo) }}" 
                                             alt="Graduate photo" 
                                             class="rounded-circle"
                                             width="40" height="40"
                                             style="object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px;">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $graduate->user->name }}</td>
                                <td>{{ $graduate->phone_number }}</td>
                                <td>{{ $graduate->graduation_year }}</td>
                                <td>
                                    <span class="badge bg-{{ $graduate->employed ? 'success' : 'secondary' }}">
                                        {{ $graduate->current_employment }}
                                    </span>
                                </td>
                                @if(auth()->user()->email === 'admin@gmail.com')
                                <td>
                                    <div class="btn-group">
                                        <button type="button" 
                                                class="btn btn-sm btn-info" 
                                                onclick="showGraduate({{ $graduate->id }})">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <a href="{{ route('admin.graduates.edit', $graduate) }}" 
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.graduates.destroy', $graduate) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $graduates->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function showGraduate(id) {
    window.location.href = `/graduates/${id}`;
}

function deleteGraduate(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/graduates/${id}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endsection
