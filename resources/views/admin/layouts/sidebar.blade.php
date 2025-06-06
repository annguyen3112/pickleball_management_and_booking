<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.dashboard') }}">
          <i class="bi bi-bar-chart-line"></i>
          <span>Trang chủ</span>
        </a>
      </li>

      @can('checkAdmin', auth()->user())
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.pitchType') }}">
          <i class="bi bi-grid"></i>
          <span>Quản lý loại sân</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.footballPitch') }}">
          <i class="bi bi-collection-fill"></i>
          <span>Quản lý sân bóng</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.equipment') }}">
          <i class="bi bi-bullseye"></i>
          <span>Quản lý dụng cụ</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#order-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-calendar-event-fill"></i><span>Quản lý yêu cầu</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="order-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.orderCalendar') }}">
              <i class="bi bi-circle"></i>
              <span>Quản lý yêu cầu - lịch</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.orderTable') }}">
              <i class="bi bi-circle"></i>
              <span>Quản lý yêu cầu - bảng</span>
            </a>
          </li>
        </ul>
      </li>

      @can('checkCourtOwner', auth()->user())
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.bankInformation') }}">
          <i class="bi bi-credit-card-2-back-fill"></i>
          <span>Quản lý thông tin thanh toán</span>
        </a>
      </li>
      @endcan
      @endcan

      @can('checkSystemAdmin', auth()->user())
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.owner') }}">
          <i class="bi bi-person-badge"></i>

          <span>Quản lý chủ sân</span>
        </a>
      </li>
      @endcan

      @canany(['checkCourtOwner', 'checkSystemAdmin'], auth()->user())
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.employe') }}">
          <i class="bi bi-file-person-fill"></i>
          <span>Quản lý nhân viên</span>
        </a>
      </li>
      @endcanany

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.customer') }}">
          <i class="bi bi-people"></i>
          <span>Quản lý khách hàng</span>
        </a>
      </li>
      
    </ul>

  </aside>