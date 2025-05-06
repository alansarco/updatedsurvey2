@extends('layouts.app')

@section('content')
<script>
    window.location.href = "{{ route('login') }}#register";
    // Remove the click event as we'll handle it in login.blade.php
</script>
@endsection
