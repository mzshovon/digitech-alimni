@php
    $route = Route::current()->getName();
@endphp
<style>
    .nav-item-active-a {
        background-color: #f6f9ff !important;
    }

    .ul-item-li-a-i {
        background-color: #4154f1 !important;
    }

    .ul-item-li-a-span {
        color: #4154f1 !important;
    }
</style>
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ in_array($route, ['admin.dashboard']) ? 'nav-item-active-a' : 'collapsed' }}"
                href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        @if (auth()->user()->hasRole("superadmin") || auth()->user()->hasRole("admin"))
            <li class="nav-item">
                <a class="nav-link {{ in_array($route, ['admin.usersList']) ? 'nav-item-active-a' : 'collapsed' }}"
                    href="{{ route('admin.usersList') }}">
                    <i class="bi bi-people"></i>
                    <span>Members</span>
                </a>
            </li><!-- End Dashboard Nav -->
        @endif
        <li class="nav-item">
            <a class="nav-link {{ in_array($route, ['admin.payment']) ? 'nav-item-active-a' : 'collapsed' }}"
                href="{{ route('admin.payment') }}">
                <i class="bi bi-cash"></i>
                <span>Payment</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link {{ in_array($route, ['admin.contact']) ? 'nav-item-active-a' : 'collapsed' }}"
                href="{{ route('admin.contact') }}">
                <i class="bi bi-envelope"></i>
                <span>Contact Us</span>
            </a>
        </li><!-- End Dashboard Nav -->

{{--
        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-error-404.html">
                <i class="bi bi-dash-circle"></i>
                <span>Error 404</span>
            </a>
        </li><!-- End Error 404 Page Nav --> --}}

    </ul>

</aside><!-- End Sidebar-->
