<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
      <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="index-2.html" class="text-nowrap logo-img">
          <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/dark-logo.svg" class="dark-logo" width="180" alt="" />
          <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/light-logo.svg" class="light-logo"  width="180" alt="" />
        </a>
        <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
          <i class="ti ti-x fs-8 text-muted"></i>
        </div>
      </div>
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav scroll-sidebar" data-simplebar>
        <ul id="sidebarnav">
          @if (auth()->user()->roles->pluck('name')[0] == \App\Enums\RoleEnum::ADMIN->value)
          <!-- =================== -->
          <!-- Dashboard -->
          <!-- =================== -->
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('beranda') }}" aria-expanded="false">
              <span>
                <i class="ti ti-aperture"></i>
              </span>
              <span class="hide-menu">Beranda</span>
            </a>
          </li>
          <!-- ============================= -->
          <!-- Master Data -->
          <!-- ============================= -->
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Master Data</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('produk.index') }}" aria-expanded="false">
              <span>
                <i class="ti ti-calendar"></i>
              </span>
              <span class="hide-menu">Produk</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('setting.index') }}" aria-expanded="false">
              <span>
                <i class="ti ti-message-dots"></i>
              </span>
              <span class="hide-menu">Pengaturan</span>
            </a>
          </li>

          <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('category.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-message-dots"></i>
                </span>
                <span class="hide-menu">Kategori</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('approvedpeserta.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-message-dots"></i>
                </span>
                <span class="hide-menu">Approved Peserta</span>
              </a>
            </li>
          <!-- ============================= -->
          <!-- Arisan -->
          <!-- ============================= -->
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Arisan</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="app-email.html" aria-expanded="false">
              <span>
                <i class="ti ti-mail"></i>
              </span>
              <span class="hide-menu">Peserta</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="app-notes.html" aria-expanded="false">
              <span>
                <i class="ti ti-notes"></i>
              </span>
              <span class="hide-menu">Pembayaran</span>
            </a>
          </li>
          @elseif (auth()->user()->roles->pluck('name')[0] === \App\Enums\RoleEnum::PESERTA->value)
          <!-- =================== -->
          <!-- Dashboard -->
          <!-- =================== -->
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('beranda') }}" aria-expanded="false">
              <span>
                <i class="ti ti-home"></i>
              </span>
              <span class="hide-menu">Beranda</span>
            </a>
          </li>
          @endif
        </ul>
      </nav>
      <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
  </aside>