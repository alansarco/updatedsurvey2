@props(['variant' => 'light'])

<form method="POST" action="{{ route('logout') }}" class="m-0">
    @csrf
    <button type="submit" 
            {{ $attributes->merge(['class' => "btn btn-outline-$variant btn-sm logout-btn"]) }}>
        <span class="d-flex align-items-center">
            <i class="bi bi-box-arrow-right me-2"></i>
            <span>Logout</span>
        </span>
    </button>
</form>

<style>
.logout-btn {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.logout-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(255,255,255,0.2);
}

.logout-btn span {
    transition: all 0.3s ease;
}

.logout-btn:hover span {
    transform: translateX(3px);
}

.logout-btn i {
    transition: all 0.3s ease;
}

.logout-btn:hover i {
    animation: logoutIcon 1s infinite;
}

@keyframes logoutIcon {
    0%, 100% { transform: translateX(0); }
    50% { transform: translateX(3px); }
}
</style>
