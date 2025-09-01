<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="#" class="brand-link">
            <img src="{{ asset('adminlte/dist/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">Dashboard</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-accordion="false" id="navigation">

                <!-- Notifications -->
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->is('notifications*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Notifications</p>
                    </a>
                </li>

                @role('admin')
                    <!-- User Management -->
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>User Management</p>
                        </a>
                    </li>

                    <!-- Farmers -->
                    <li class="nav-item">
                        <a href="{{route('admin.farmers')}}" class="nav-link {{ request()->is('farmers*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Farmers</p>
                        </a>
                    </li>

                    <!-- Crops Menu -->
                    <li class="nav-item {{ request()->is('crops*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('crops*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>
                                Crops
                                <i class="right bi bi-chevron-down"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="{{ request()->is('crops*') ? 'display:block;' : '' }}">
                            <li class="nav-item">
                                <a href="{{ route('admin.crop.cat') }}"
                                    class="nav-link {{ request()->is('crops/crop_cat*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Crop Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.crop.type') }}"
                                    class="nav-link {{ request()->is('crops/crop_type*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Crop Types</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.crop') }}"
                                    class="nav-link {{ request()->is('crops/crop*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Crops</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ route('admin.variety') }}"
                                    class="nav-link {{ request()->is('crops/variety*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Varieties</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.rootstock') }}"
                                    class="nav-link {{ request()->is('crops/rootstock*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Rootstocks</p>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="{{ route('admin.crops') }}"
                                    class="nav-link {{ request()->is('crops/rootstock*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Variety and Rootstock</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Plots & Crops -->
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('plots*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Plots & Crops</p>
                        </a>
                    </li>

                    <!-- Cases -->
                    {{-- <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('cases*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Cases</p>
                        </a>
                    </li> --}}

                    <!-- Crops Menu -->
                    <li class="nav-item {{ request()->is('cases*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('crops*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>
                                Cases
                                <i class="right bi bi-chevron-down"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="{{ request()->is('crops*') ? 'display:block;' : '' }}">
                            <li class="nav-item">
                                <a href="{{ route('admin.sampleType') }}"
                                    class="nav-link {{ request()->is('crops/crop_cat*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Sample Types</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.singlePara') }}"
                                    class="nav-link {{ request()->is('crops/crop_type*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Individual Parameters</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.packages') }}"
                                    class="nav-link {{ request()->is('crops/crop*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Packages</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item ">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>samples</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Lab Tests</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Invoices</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Reports & Analytics</p>
                        </a>
                    </li>
                @endrole
                @role('farmer')
                    <li class="nav-item ">
                        <a href="{{ route('user.profile') }}" class="nav-link ">
                            <i class="nav-icon bi bi-circle"></i>
                            <p> My Profile</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{ route('user.field') }}" class="nav-link ">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>My Fields</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{ route('user.crop') }}" class="nav-link ">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>My Crops</p>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a href="{{ route('user.sample') }}" class="nav-link ">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Requests Tests</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Invoices / Payments</p>
                        </a>
                    </li>
                @endrole
                @role('consultant')
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Assigned Cases</p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Recommendations</p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Farmers</p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                @endrole
                @role('lab_scientist')
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Assigned Tests</p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Upload Results</p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                @endrole
                @role('field_agent')
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Assigned Collections</p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Update Status</p>
                        </a>
                    </li>
                @endrole
                @role('accountant')
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Invoices</p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Payments</p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                @endrole
                @role('front_office')
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Register Farmers</p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Assist Farmers</p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Track Cases</p>
                        </a>
                    </li>
                @endrole

            </ul>
        </nav>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.app-sidebar .sidebar-wrapper');

        sidebar.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;

            const parent = link.parentElement;
            const submenu = parent.querySelector('.nav-treeview');
            if (!submenu) return;

            e.preventDefault();
            const isOpen = parent.classList.contains('menu-open');

            // Close siblings
            parent.parentElement.querySelectorAll('.nav-item.menu-open').forEach(item => {
                if (item !== parent) {
                    item.classList.remove('menu-open');
                    const sub = item.querySelector('.nav-treeview');
                    if (sub) sub.style.display = 'none';
                    const linkItem = item.querySelector('> .nav-link');
                    if (linkItem) linkItem.classList.remove('active');
                }
            });

            // Toggle current
            parent.classList.toggle('menu-open', !isOpen);
            link.classList.toggle('active', !isOpen);
            submenu.style.display = !isOpen ? 'block' : 'none';
        });

        // Auto-scroll active link
        const activeLink = document.querySelector('.app-sidebar .nav-link.active');
        if (activeLink && sidebar) {
            const sidebarRect = sidebar.getBoundingClientRect();
            const linkRect = activeLink.getBoundingClientRect();
            sidebar.scrollTop += linkRect.top - sidebarRect.top - 80;
        }
    });
</script>
