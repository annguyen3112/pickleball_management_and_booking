<!-- ======= Header ======= -->
<header id="header" class="fixed-top rounded-pill shadow" style="background: #8DA49A;">
    <div class="container d-flex justify-content-between align-items-center py-3 px-4">

        <a href="{{ route('client.index') }}" class="d-flex align-items-center text-decoration-none text-white fw-bold">
            <img src="{{ asset('storage/images/pickle_court.png') }}" alt="Logo" style="height: 32px;" class="me-2">
            {{ config('app.name') }}
        </a>

        <nav id="navbar" class="navbar d-none d-md-flex justify-content-center align-items-center gap-4 flex-grow-1 mx-5">
            <a href="{{ route('client.index') }}#" class="nav-link text-white">Trang chủ</a>
            <a href="{{ route('client.index') }}#services" class="nav-link text-white">Dịch vụ</a>
            <a href="{{ route('client.index') }}#portfolio" class="nav-link text-white">Sân bóng</a>
            <a href="{{ route('client.index') }}#about" class="nav-link text-white">Về chúng tôi</a>

            <div class="dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">Chức năng</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#findFootballPitchAvailableModal">Tìm kiếm sân trống</a></li>
                    <li><a class="dropdown-item" href="{{ route('client.findOrderByCode') }}">Tra cứu yêu cầu đặt sân</a></li>
                </ul>
            </div>
        </nav>

        <div class="d-flex align-items-center gap-2">
            @guest
                <a href="{{ route('client.login') }}" class="text-white fw-semibold">Đăng nhập</a>
                <a href="{{ route('client.register') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">Đăng ký</a>
            @endguest

            @auth
                <div class="dropdown">
                    <a href="#" class="btn btn-outline-light btn-sm rounded-pill dropdown-toggle px-3" data-bs-toggle="dropdown">
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @if (auth()->user()->role != 0)
                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Trang quản trị</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @endif
                        <li><a class="dropdown-item" href="{{ route('client.profile') }}"><i class="bi bi-person me-2"></i>Thông tin cá nhân</a></li>
                        <li><a class="dropdown-item" href="{{ route('client.orderByMe') }}"><i class="bi bi-list-check me-2"></i>Yêu cầu đã đặt</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="{{ route('client.logout') }}"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a></li>
                    </ul>
                </div>
            @endauth
            <button class="btn d-md-none text-white" id="toggleMenuBtn" type="button">
                <i class="bi bi-list" style="font-size: 1.5rem;"></i>
            </button>
        </div>
    </div>
</header>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("toggleMenuBtn");
        const navbar = document.getElementById("navbar");

        toggleBtn.addEventListener("click", function () {
            navbar.classList.toggle("d-none");
        });
    });
</script>

@include('client.modal.findFootballPitchAvailable')
@include('client.modal.orderWhenFoundFootballPitch')
