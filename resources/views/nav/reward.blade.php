@if(count(array_intersect(array_values(config('access.reward')), $admin_roles)) > 0)
    <li class="nav-item nav-item-submenu">
        <a href="#" class="nav-link">
            <i class="ph-film-script"></i>
            <span>Reward</span>
        </a>
        <ul class="nav-group-sub collapse @if ($page == config('app.nav.pnr_submission_history') || ($page == config('app.nav.customer_leader_board')) || ($page == config('app.nav.seller_leader_board')) ) show @endif">
            <a href="{{ url('/pnr-submission-history') }}" class="nav-link @if($page == config('app.nav.pnr_submission_history')) active @endif">
                <i class="ph-user-list"></i>
                <span>PNR Submission History</span>
            </a>
            <li style="border-bottom: 1px solid var(--nav-link-active-bg);"></li>

            <a href="{{ url('/customer-leader-board') }}" class="nav-link @if($page == config('app.nav.customer_leader_board')) active @endif">
                <i class="ph-user-list"></i>
                <span>Customer Leader Board</span>
            </a>
            <li style="border-bottom: 1px solid var(--nav-link-active-bg);"></li>

            <a href="{{ url('/seller-leader-board') }}" class="nav-link @if($page == config('app.nav.seller_leader_board')) active @endif">
                <i class="ph-user-list"></i>
                <span>Seller Leader Board</span>
            </a>
            <li style="border-bottom: 1px solid var(--nav-link-active-bg);"></li>
        </ul>
    </li>
@endif
