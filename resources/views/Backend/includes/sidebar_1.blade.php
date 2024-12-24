<!-- Sidebar Start -->
<aside class="left-sidebar with-vertical">
    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
    <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="{{ route('admin.index') }}" class="text-nowrap logo-img">
            <img src="{{ asset('storage/images/logos/logo-dark.svg') }}" class="light-logo" alt="Logo-light" />
        </a>
        <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
            <i class="ti ti-x"></i>
        </a>
    </div>

    <div class="scroll-sidebar" data-simplebar>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="mb-0">
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow success-hover-bg" href="#" aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="solar:smart-speaker-minimalistic-line-duotone"
                                class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Movies</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('movie.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Movies</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('director.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Director</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('actor.list') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Actor</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('categories.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Category</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('banners.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Banner</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow warning-hover-bg" href="#" aria-expanded="false">
                        <span class="aside-icon p-2 bg-warning-subtle rounded-1">
                            <iconify-icon icon="solar:pie-chart-3-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Cinema</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('admin.cinema.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Cinema</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('admin.cinematype.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Cinema Type</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('admin.room.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Room</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @if (Auth::check() && (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'supper'))
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow indigo-hover-bg" href="#" aria-expanded="false">
                            <span class="aside-icon p-2 bg-danger-subtle rounded-1">
                                <iconify-icon icon="solar:user-circle-line-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu ps-1">User</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="{{ route('user.index') }}" class="sidebar-link">
                                    <span class="sidebar-icon"></span>
                                    <span class="hide-menu">User Admin</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('user.client.index') }}" class="sidebar-link">
                                    <span class="sidebar-icon"></span>
                                    <span class="hide-menu">User Client</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow danger-hover-bg" href="#" aria-expanded="false">
                        <span class="aside-icon p-2 bg-danger-subtle rounded-1">
                            <iconify-icon icon="solar:user-circle-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Showing & Food Combo</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('showingrelease.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">ShowingRelease</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('foodcombos.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Food Combo</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow success-hover-bg" href="#" aria-expanded="false">
                        <span class="aside-icon p-2 bg-danger-subtle rounded-1">
                            <iconify-icon icon="solar:user-circle-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Manage</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('bill.index') }}">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Bill</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('voucher.list') }}">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Voucher</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('rankmember.index') }}">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Rank Member</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('seattype.list') }}">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Seat Type</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link indigo-hover-bg" href="{{ route('blog.index') }}" aria-expanded="false">
                        <span class="aside-icon p-2 bg-indigo-subtle rounded-1">
                            <iconify-icon icon="solar:mailbox-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Blog</span>
                    </a>
                </li>
            </ul>

        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
</aside>
<!--  Sidebar End -->
