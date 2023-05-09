<div class="sidebar-section">
    <ul class="nav nav-sidebar" data-nav-type="accordion">
        @if(in_array(config('access.global.dashboard'), $admin_roles))
        <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link @if($page == config('app.nav')['dashboard']) active @endif">
                <i class="ph-house"></i><span>Dashboard</span>
            </a>
        </li>
        @endif
        <li style="border-bottom: 1px solid var(--nav-link-active-bg);"></li>
        @if(in_array(config('access.users.admin-read'), $admin_roles))
            <li class="nav-item">
                <a href="{{url('admins')}}" class="nav-link @if($page == config('app.nav.admins')) active @endif">
                    <i class="ph-user-list"></i><span>Admins</span>
                </a>
            </li>
            <li style="border-bottom: 1px solid var(--nav-link-active-bg);"></li>
        @endif

        @include('nav.reward')
    </ul>
</div>
