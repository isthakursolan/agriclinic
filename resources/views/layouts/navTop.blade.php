<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <div class="navbar-brand d-flex align-items-center">
            <h4 class="mb-0 fw-bold" id="page-title">Dashboard</h4>
        </div>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown" style="display: none;">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-chat-text"></i>
                    <span class="navbar-badge badge text-bg-danger">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <a href="#" class="dropdown-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('adminlte/dist/assets/img/user1-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 rounded-circle me-3" />
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span style="color: #777777;"><i class="bi bi-star-fill"></i></span>
                                </h3>
                                <p class="fs-7">Call me whenever you can...</p>
                                <p class="fs-7 text-secondary">
                                    <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('adminlte/dist/assets/img/user8-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 rounded-circle me-3" />
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-end fs-7 text-secondary">
                                        <i class="bi bi-star-fill"></i>
                                    </span>
                                </h3>
                                <p class="fs-7">I got your message bro</p>
                                <p class="fs-7 text-secondary">
                                    <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('adminlte/dist/assets/img/user3-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 rounded-circle me-3" />
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span style="color: #777777;">
                                        <i class="bi bi-star-fill"></i>
                                    </span>
                                </h3>
                                <p class="fs-7">The subject goes here</p>
                                <p class="fs-7 text-secondary">
                                    <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>
            <li class="nav-item dropdown" style="display: none;">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-bell-fill"></i>
                    <span class="navbar-badge badge text-bg-warning">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-envelope me-2"></i> 4 new messages
                        <span class="float-end text-secondary fs-7">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-people-fill me-2"></i> 8 friend requests
                        <span class="float-end text-secondary fs-7">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                        <span class="float-end text-secondary fs-7">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
                </div>
            </li>
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" role="button" onclick="event.preventDefault();">
                    <span class="d-none d-md-inline">{{ Auth::user()->email ?? 'User' }}</span>
                    <i class="bi bi-chevron-down ms-1"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <div class="user-header text-bg-primary p-3">
                        <p class="mb-0">{{ Auth::user()->email ?? 'User' }} 
                            <small class="d-block">
                                Role: 
                                @if(Auth::user()->roles->count() > 0)
                                    {{ Auth::user()->roles->pluck('name')->map(fn($role) => ucfirst($role))->join(', ') }}
                                @else
                                    No role
                                @endif
                            </small>
                        </p>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Edit Profile</a>
                    @role('admin|superadmin')
                    <a class="dropdown-item" href="{{ route('admin.roles') }}"><i class="bi bi-people me-2"></i> Roles Management</a>
                    @endrole
                    <a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
