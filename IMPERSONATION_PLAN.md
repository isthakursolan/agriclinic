# User Impersonation Feature - Implementation Plan

## Overview
This document outlines the complete implementation plan for the user impersonation feature, allowing superadmin users to browse the application as other users while maintaining their original session.

## Architecture

### 1. Session Management Strategy
- **Original User Storage**: Store superadmin's user ID in session under `impersonation.original_user_id`
- **Impersonation State**: Store impersonated user ID in session under `impersonation.impersonated_user_id`
- **Session Switching**: When impersonating, switch `Auth::user()` to the impersonated user
- **Session Restoration**: On logout or stop impersonation, restore original superadmin session

### 2. Components Required

#### A. Controller: `ImpersonationController`
**Location**: `app/Http/Controllers/admin/ImpersonationController.php`

**Methods**:
1. `index()` - List all users with pagination/datatable
   - Show: Name, Email, Username, Contact, Roles, Created At
   - Only accessible by superadmin
   - Search/filter functionality

2. `show(User $user)` - Display user profile page
   - Show all user details
   - Show user's roles
   - Show user's profile information
   - Show "Impersonate" button (only if not already impersonating)

3. `impersonate(User $user)` - Start impersonation
   - Validate: Only superadmin can impersonate
   - Validate: Cannot impersonate another superadmin (security)
   - Store original user ID in session
   - Log in as impersonated user
   - Redirect to appropriate dashboard based on impersonated user's role

4. `stop()` - Stop impersonation
   - Restore original superadmin session
   - Clear impersonation session data
   - Redirect to admin dashboard

#### B. Middleware: `ImpersonationMiddleware`
**Location**: `app/Http/Middleware/ImpersonationMiddleware.php`

**Purpose**: 
- Check if user is impersonating
- Ensure impersonation state is maintained across requests
- Handle edge cases (session expiry, etc.)

**Logic**:
```php
if (session()->has('impersonation.original_user_id')) {
    // User is impersonating
    // Ensure Auth::user() matches impersonated user
    // If mismatch, restore from session
}
```

#### C. Routes
**Location**: `routes/auth.php` (inside superadmin middleware group)

```php
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        // User Management
        Route::get('/users', [ImpersonationController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [ImpersonationController::class, 'show'])->name('users.show');
        
        // Impersonation
        Route::post('/impersonate/{user}', [ImpersonationController::class, 'impersonate'])->name('impersonate.start');
        Route::post('/impersonate/stop', [ImpersonationController::class, 'stop'])->name('impersonate.stop');
    });
});
```

#### D. Views

1. **User List View**: `resources/views/admin/users/index.blade.php`
   - Datatable with columns: #, Name, Email, Username, Contact, Roles, Actions
   - Actions: View Profile button
   - Search functionality
   - Only visible to superadmin

2. **User Profile View**: `resources/views/admin/users/show.blade.php`
   - User Information Card:
     - Name, Email, Username, Contact
     - Profile Picture (if exists)
     - Created At, Updated At
   - Roles Card:
     - List all roles assigned to user
   - Profile Details Card (if profile exists):
     - Full Name, Address, etc.
   - Action Buttons:
     - "Impersonate" button (dark, with icon)
     - "Back to Users" button (secondary)
   - Show warning if trying to impersonate superadmin

3. **Floating Widget**: `resources/views/layouts/impersonation-widget.blade.php`
   - Fixed position at bottom-right
   - Only visible when impersonating
   - Display:
     - "Impersonating as: [User Name]"
     - "Original User: [Superadmin Name]"
     - "Stop Impersonation" button
   - Styled with Bootstrap classes
   - Z-index: 9999

#### E. Sidebar Menu Update
**Location**: `resources/views/layouts/sidebar.blade.php`

Add new menu item (only for superadmin):
```blade
@role('superadmin')
    <li class="nav-item">
        <a href="{{ route('admin.users.index') }}"
            class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-people"></i>
            <p>All Users</p>
        </a>
    </li>
@endrole
```

#### F. Logout Handler Update
**Location**: `app/Http/Controllers/auth/loginController.php`

Update `logout()` method:
```php
public function logout(Request $request)
{
    // Check if user is impersonating
    if (session()->has('impersonation.original_user_id')) {
        // Restore original user
        $originalUserId = session('impersonation.original_user_id');
        Auth::loginUsingId($originalUserId);
        
        // Clear impersonation session
        session()->forget('impersonation');
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'Impersonation stopped. Returned to your account.');
    }
    
    // Normal logout
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect()->route('login')->with('success', 'Logged out successfully.');
}
```

#### G. CSS Styling
**Location**: `public/css/app.css`

Add styles for floating widget:
```css
/* Impersonation Widget */
.impersonation-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    background: #fff;
    border: 2px solid #dc3545;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    min-width: 300px;
    max-width: 400px;
}

.impersonation-widget .alert {
    margin-bottom: 10px;
}

.impersonation-widget .btn {
    width: 100%;
}
```

## Implementation Steps

### Phase 1: Core Functionality
1. Create `ImpersonationController` with basic methods
2. Create routes for impersonation
3. Implement `impersonate()` method with session management
4. Implement `stop()` method to restore session
5. Update logout handler

### Phase 2: User Interface
1. Create user list view with datatable
2. Create user profile view
3. Add sidebar menu item (superadmin only)
4. Create floating widget component
5. Include widget in main layout

### Phase 3: Security & Edge Cases
1. Add middleware to prevent impersonation loops
2. Prevent impersonating other superadmins
3. Handle session expiry during impersonation
4. Add logging for impersonation actions (optional)

### Phase 4: Testing
1. Test impersonation flow
2. Test session restoration
3. Test logout during impersonation
4. Test edge cases (expired sessions, etc.)

## Security Considerations

1. **Authorization**: Only superadmin can access impersonation features
2. **Prevent Superadmin Impersonation**: Cannot impersonate another superadmin
3. **Session Security**: Original session stored securely in Laravel session
4. **Audit Trail**: Consider logging impersonation actions (who, when, which user)
5. **Session Timeout**: Handle case where original session expires

## Database Considerations

No new database tables required. Uses existing:
- `users` table
- `roles` table (via Spatie Permission)
- `model_has_roles` table (via Spatie Permission)
- `profiles` table (if exists)

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── admin/
│   │       └── ImpersonationController.php
│   └── Middleware/
│       └── ImpersonationMiddleware.php (optional)

resources/
└── views/
    ├── admin/
    │   └── users/
    │       ├── index.blade.php
    │       └── show.blade.php
    └── layouts/
        └── impersonation-widget.blade.php

routes/
└── auth.php (add routes)

public/
└── css/
    └── app.css (add widget styles)
```

## User Flow

1. **Superadmin logs in** → Sees "All Users" in sidebar
2. **Clicks "All Users"** → Sees list of all users
3. **Clicks "View Profile"** on a user → Sees user profile page
4. **Clicks "Impersonate"** → 
   - Original session saved
   - Logged in as selected user
   - Redirected to user's dashboard
   - Floating widget appears
5. **Browses as user** → Can see everything the user sees
6. **Clicks "Stop Impersonation"** → 
   - Original session restored
   - Redirected to admin dashboard
   - Widget disappears

## Notes

- The floating widget should be included in `layouts/app.blade.php` conditionally
- Use `@if(session()->has('impersonation.original_user_id'))` to show widget
- Consider adding a helper method in User model: `isImpersonating()`
- Consider adding a helper method: `getOriginalUser()` to get superadmin user

