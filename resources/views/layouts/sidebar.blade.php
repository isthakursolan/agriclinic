<aside class="app-sidebar bg-body-secondary shadow sidebar-{{ Auth::user()->roles->first()->name ?? 'default' }}" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="/login" class="brand-link">
            <img src="{{ asset('adminlte/dist/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">Dashboard</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-accordion="false" id="navigation">

                @role('admin|superadmin')
                    <!-- Farmers -->
                    <li class="nav-item">
                        <a href="{{ route('farmers') }}"
                            class="nav-link {{ request()->routeIs('farmers*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-check"></i>
                            <p>Farmers</p>
                        </a>
                    </li>


                    <!-- Crops Menu -->
                    <li
                        class="nav-item {{ request()->is('admin/crop*') || request()->routeIs('admin.crop*') || request()->routeIs('admin.variety*') || request()->routeIs('admin.rootstock*') || request()->routeIs('admin.crop-varieties*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is('admin/crop*') || request()->routeIs('admin.crop*') || request()->routeIs('admin.variety*') || request()->routeIs('admin.rootstock*') || request()->routeIs('admin.crop-varieties*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-flower1"></i>
                            <p>
                                Crops
                                <i class="right bi bi-chevron-down"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            style="{{ request()->is('admin/crop*') || request()->routeIs('admin.crop*') || request()->routeIs('admin.variety*') || request()->routeIs('admin.rootstock*') || request()->routeIs('admin.crop-varieties*') ? 'display:block;' : 'display:none;' }}">
                            <li class="nav-item">
                                <a href="{{ route('admin.crops') }}"
                                    class="nav-link {{ request()->routeIs('admin.crops') || request()->routeIs('admin.crops.*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Crops List</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.crop.categories') }}"
                                    class="nav-link {{ request()->routeIs('admin.crop.categories*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Crop Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.crop.types') }}"
                                    class="nav-link {{ request()->routeIs('admin.crop.types*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Crop Types</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.crop-varieties') }}"
                                    class="nav-link {{ request()->routeIs('admin.crop-varieties*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Varieties & Rootstocks</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <!-- Field Agent Management -->
                    <li class="nav-item {{ request()->is('admin/field-agents*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/field-agents*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-badge"></i>
                            <p>
                                Field Agents
                                <i class="right bi bi-chevron-down"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            style="{{ request()->is('admin/field-agents*') ? 'display:block;' : 'display:none;' }}">
                            <li class="nav-item">
                                <a href="{{ route('admin.field-agents') }}"
                                    class="nav-link {{ request()->routeIs('admin.field-agents') && !request()->is('*/assigned-farmers') && !request()->is('*/reports*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Manage Agents</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.field-agents.assigned-farmers') }}"
                                    class="nav-link {{ request()->routeIs('admin.field-agents.assigned-farmers') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Farmer Assignments</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.field-agents.reports') }}"
                                    class="nav-link {{ request()->routeIs('admin.field-agents.reports*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Field Agent Reports</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <!-- Test Configuration Menu -->
                    <li
                        class="nav-item {{ request()->is('admin/sample-types*') || request()->is('admin/test-parameters*') || request()->is('admin/test-packages*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is('admin/sample-types*') || request()->is('admin/test-parameters*') || request()->is('admin/test-packages*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-clipboard-data"></i>
                            <p>
                                Test Configurations
                                <i class="right bi bi-chevron-down"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            style="{{ request()->is('admin/sample-types*') || request()->is('admin/test-parameters*') || request()->is('admin/test-packages*') ? 'display:block;' : 'display:none;' }}">
                            <li class="nav-item">
                                <a href="{{ route('admin.sample-types') }}"
                                    class="nav-link {{ request()->routeIs('admin.sample-types*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Sample Types</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.test-parameters') }}"
                                    class="nav-link {{ request()->routeIs('admin.test-parameters*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Test Parameters</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.test-packages') }}"
                                    class="nav-link {{ request()->routeIs('admin.test-packages*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Test Packages</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endrole

                @role('farmer')
                    <li class="nav-item">
                        <a href="{{ route('user.profile') }}"
                            class="nav-link {{ request()->routeIs('user.profile*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person"></i>
                            <p>My Profile</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.field') }}"
                            class="nav-link {{ request()->routeIs('user.field*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-geo-alt"></i>
                            <p>My Fields</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.crop') }}"
                            class="nav-link {{ request()->routeIs('user.crop*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-flower2"></i>
                            <p>My Crops</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.sample') }}"
                            class="nav-link {{ request()->routeIs('user.sample*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-clipboard-check"></i>
                            <p>Request Tests</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-file-earmark-text"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-credit-card"></i>
                            <p>Invoices / Payments</p>
                        </a>
                    </li> --}}
                @endrole

                @role('field_agent')
                    <!-- Dashboard -->
                    {{-- <li class="nav-item">
                        <a href="{{ route('agent.dashboard') }}"
                           class="nav-link {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li> --}}

                    <!-- Register Farmers -->
                    <li class="nav-item">
                        <a href="{{ route('farmers') }}"
                            class="nav-link {{ request()->routeIs('farmers') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-plus"></i>
                            <p>Register Farmers</p>
                        </a>
                    </li>
                    <!-- Sample Collection -->
                    <li class="nav-item">
                        <a href="{{ route('agent.samples') }}"
                            class="nav-link {{ request()->routeIs('agent.samples') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-box-seam"></i>
                            <p>Sample Collection</p>
                        </a>
                    </li>
                    <!-- Assigned Farmers -->
                    <li class="nav-item">
                        <a href="{{ route('agent.farmers') }}"
                            class="nav-link {{ request()->routeIs('agent.farmers') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-people"></i>
                            <p>My Assigned Farmers</p>
                        </a>
                    </li>

                    <!-- Fields -->
                    {{-- <li class="nav-item">
                        <a href="{{ route('agent.fields') }}"
                            class="nav-link {{ request()->routeIs('agent.fields') && !request()->is('*/show') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-geo-alt"></i>
                            <p>Assigned Fields</p>
                        </a>
                    </li>

                    <!-- Tasks -->
                    <li class="nav-item">
                        <a href="{{ route('agent.tasks') }}"
                            class="nav-link {{ request()->routeIs('agent.tasks') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-check-square"></i>
                            <p>My Tasks</p>
                        </a>
                    </li>

                    <!-- Reports -->
                    <li class="nav-item ">
                        <a href="{{ route('agent.reports') }}"
                            class="nav-link {{ request()->routeIs('agent.reports') && !request()->is('*/show') && !request()->is('*/edit') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-file-earmark-text"></i>
                            <p> My Reports </p>
                        </a>
                    </li> --}}
                @endrole

                @role('consultant')
                    <!-- Farmers -->
                    <li class="nav-item">
                        <a href="{{ route('farmers') }}"
                            class="nav-link {{ request()->routeIs('admin.farmers*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-check"></i>
                            <p>Farmers</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-briefcase"></i>
                            <p>My Test Requests</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-lightbulb"></i>
                            <p>Recommendations</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-graph-up"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                @endrole

                @role('lab_scientist')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-clipboard-pulse"></i>
                            <p>My Assigned Tests</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-upload"></i>
                            <p>Upload Test Results</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-bar-chart"></i>
                            <p>Test Reports</p>
                        </a>
                    </li>
                @endrole

                @role('accountant')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-receipt"></i>
                            <p>Invoices</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-credit-card"></i>
                            <p>Payments</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-graph-up"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                @endrole

                @role('front_office')
                    {{-- <li class="nav-item">
                        <a href="{{ route('frontoffice.dashboard') }}"
                            class="nav-link {{ request()->routeIs('frontoffice.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li> --}}

                    <!-- Farmer Management -->
                    <li class="nav-item {{ request()->is('frontoffice/farmers*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('frontoffice/farmers*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-people"></i>
                            <p>
                                Farmer Management
                                <i class="right bi bi-chevron-down"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            style="{{ request()->is('farmers*') ? 'display:block;' : 'display:none;' }}">
                            <li class="nav-item">
                                <a href="{{ route('farmer.create') }}"
                                    class="nav-link {{ request()->routeIs('farmer.create') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Add New Farmer</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('farmers') }}"
                                    class="nav-link {{ request()->routeIs('farmers') || request()->routeIs('farmer.*') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Manage Farmers</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('sample') }}"
                            class="nav-link {{ request()->routeIs('sample') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-file-earmark-plus"></i>
                            <p>Create Test Request</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('frontoffice.samples.accept') }}"
                            class="nav-link {{ request()->routeIs('frontoffice.samples.accept') ? 'active' : '' }}">
                            <i class="bi bi-check-circle nav-icon"></i>
                            <p>Sample Intake</p>
                        </a>
                    </li>
                    {{-- In Blade sidebar --}}
                    <li class="nav-item">
                        <a href="{{ route('frontoffice.all-batches') }}"
                            class="nav-link {{ request()->routeIs('frontoffice.batches.create') ? 'active' : '' }}">
                            <i class="bi bi-boxes nav-icon"></i>
                           <p>Sample Batches</p>
                        </a>
                    </li>

                    <!-- Sample Management -->
                    {{-- <li class="nav-item {{ request()->is('frontoffice/samples*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('frontoffice/samples*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>
                                Sample Management
                                <i class="right bi bi-chevron-down"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            style="{{ request()->is('frontoffice/samples*') ? 'display:block;' : 'display:none;' }}">
                            <li class="nav-item">
                                <a href="{{ route('frontoffice.samples.create') }}"
                                    class="nav-link {{ request()->routeIs('frontoffice.samples.create') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Create Sample</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('frontoffice.samples.index') }}"
                                    class="nav-link {{ request()->routeIs('frontoffice.samples.index') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>All Samples</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('frontoffice.payments.paid') }}"
                                    class="nav-link {{ request()->routeIs('frontoffice.payments.paid') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Paid Samples</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('frontoffice.samples.track') }}"
                                    class="nav-link {{ request()->routeIs('frontoffice.samples.track') ? 'active' : '' }}">
                                    <i class="bi bi-dot nav-icon"></i>
                                    <p>Track Sample</p>
                                </a>
                            </li>
                        </ul>
                    </li> --}}
                @endrole

            </ul>
        </nav>
    </div>
</aside>
<style>
    .app-sidebar .nav-link p .right,
    .app-sidebar .nav-link .right {
        transition: transform 0.3s ease;
        display: inline-block;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.app-sidebar .sidebar-wrapper');
        const menuItems = document.querySelectorAll('.nav-item > .nav-link');

        // Handle menu click events
        menuItems.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const parent = this.parentElement;
                const submenu = parent.querySelector('.nav-treeview');

                if (submenu) {
                    e.preventDefault();

                    const isOpen = parent.classList.contains('menu-open');

                    // Close other open menus
                    document.querySelectorAll('.nav-item.menu-open').forEach(function(
                        openItem) {
                        // Do not close the current parent if one of its children is active
                        const isActive = openItem.querySelector(
                            '.nav-treeview .nav-link.active');
                        if (openItem !== parent && !isActive) {
                            openItem.classList.remove('menu-open');
                            const openSubmenu = openItem.querySelector('.nav-treeview');
                            if (openSubmenu) {
                                openSubmenu.style.display = 'none'; // Hide submenu
                            }
                            const openLink = openItem.querySelector('.nav-link');
                            if (openLink) {
                                openLink.classList.remove('active');
                                // Rotate chevron icon back
                                const pTag = openLink.querySelector('p');
                                const chevron = pTag ? pTag.querySelector('.right') : null;
                                if (chevron) {
                                    chevron.style.transform = 'rotate(0deg)';
                                }
                            }
                        }
                    });

                    // Toggle current menu
                    const pTag = this.querySelector('p');
                    const chevron = pTag ? pTag.querySelector('.right') : null;
                    if (!isOpen) {
                        parent.classList.add('menu-open');
                        submenu.style.display = 'block';
                        this.classList.add('active');
                        // Rotate chevron icon down (180 degrees)
                        if (chevron) {
                            chevron.style.transform = 'rotate(180deg)';
                        }
                    } else {
                        parent.classList.remove('menu-open');
                        submenu.style.display = 'none'; // Hide submenu
                        if (!this.parentElement.querySelector(
                                '.nav-treeview .nav-link.active')) {
                            this.classList.remove('active');
                        }
                        // Rotate chevron icon back (0 degrees)
                        if (chevron) {
                            chevron.style.transform = 'rotate(0deg)';
                        }
                    }
                }
            });
        });

        // Initialize chevron rotation for already open menus
        document.querySelectorAll('.nav-item.menu-open').forEach(function(openItem) {
            const openLink = openItem.querySelector('.nav-link');
            if (openLink) {
                const pTag = openLink.querySelector('p');
                const chevron = pTag ? pTag.querySelector('.right') : null;
                if (chevron) {
                    chevron.style.transform = 'rotate(180deg)';
                }
            }
        });

        // Auto-scroll to active link
        const activeLink = document.querySelector('.app-sidebar .nav-link.active');
        if (activeLink && sidebar) {
            const sidebarRect = sidebar.getBoundingClientRect();
            const linkRect = activeLink.getBoundingClientRect();
            if (linkRect.top < sidebarRect.top || linkRect.bottom > sidebarRect.bottom) {
                activeLink.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }
    });
</script>
