@php
    $isImpersonating = session()->has('impersonation.original_user_id');
    $impersonatedUserId = session('impersonation.impersonated_user_id', null);
    $originalUserId = session('impersonation.original_user_id', null);
    
    $impersonatedUser = null;
    $originalUser = null;
    
    if ($isImpersonating && $impersonatedUserId && $originalUserId) {
        $impersonatedUser = \App\Models\User::find($impersonatedUserId);
        $originalUser = \App\Models\User::find($originalUserId);
    }
@endphp

@if($isImpersonating && $impersonatedUser && $originalUser)
    <div class="impersonation-widget">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="impersonation-icon">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div class="impersonation-info">
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <div>
                                    <small class="text-white-50 d-block">Impersonating as</small>
                                    <strong class="text-white">{{ $impersonatedUser->name ?? $impersonatedUser->email }}</strong>
                                    <small class="text-white-50 d-block">{{ $impersonatedUser->email }}</small>
                                </div>
                                <div class="vr text-white-50" style="height: 40px;"></div>
                                <div>
                                    <small class="text-white-50 d-block">Original User</small>
                                    <strong class="text-white">{{ $originalUser->name ?? $originalUser->email }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <form action="{{ route('admin.impersonate.stop') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-light btn-sm">
                            <i class="bi bi-x-circle me-1"></i> Stop Impersonation
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

