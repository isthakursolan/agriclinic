# Agriclinic Project Brief

## 1. User Roles and Capabilities

### Role Overview
The application uses **Spatie Laravel Permission** package for role-based access control. There are **10 user roles**:

### 1.1 Admin / Superadmin
**Capabilities:**
- Full system access and configuration
- User role management (assign/change roles)
- Crop management (Categories, Types, Crops, Varieties, Rootstocks)
- Field Agent management (assign farmers, create tasks, view reports)
- Sample Type configuration
- Individual Parameters management
- Packages management
- View all farmers and samples

**Routes:** `/admin/*`

### 1.2 Farmer
**Capabilities:**
- Manage personal profile
- Manage fields (add, edit, delete)
- Manage crops (add, edit, delete active crops)
- Request sample tests
- View sample details
- Make payments for samples

**Routes:** `/user/*`

### 1.3 Field Agent
**Capabilities:**
- View assigned farmers
- View assigned fields
- View assigned tasks
- Create and submit reports
- Collect samples from farmers
- Accept samples for collection

**Routes:** `/agent/*`

### 1.4 Front Office
**Capabilities:**
- Create and manage farmers
- Create samples
- Accept/reject samples
- Track samples
- Create batches
- View paid samples
- Process payments

**Routes:** `/frontoffice/*`

### 1.5 Consultant
**Capabilities:**
- View farmers
- View assigned cases (planned, not fully implemented)
- Provide recommendations (planned, not fully implemented)
- View reports (planned, not fully implemented)

**Routes:** `/con/*`
**Status:** Dashboard exists but most features are placeholders

### 1.6 Lab Scientist
**Capabilities:**
- View assigned tests (planned, not fully implemented)
- Upload test results (planned, not fully implemented)
- View reports (planned, not fully implemented)

**Routes:** `/lab/*`
**Status:** Dashboard exists but features not implemented

### 1.7 Analyst
**Capabilities:**
- Dashboard access (planned, not fully implemented)

**Routes:** `/analyst/*`
**Status:** Dashboard exists but features not implemented

### 1.8 Accountant
**Capabilities:**
- View invoices (planned, not fully implemented)
- View payments (planned, not fully implemented)
- View reports (planned, not fully implemented)

**Routes:** `/acc/*`
**Status:** Dashboard exists but features not implemented

### 1.9 Collection Center
**Capabilities:**
- Limited implementation

**Status:** Role exists but minimal functionality

---

## 2. Database Configuration

### Primary Database
- **Default:** SQLite (`database/database.sqlite`)
- **Configuration:** `config/database.php`

### Supported Databases
The application supports multiple database systems:
- **SQLite** (default)
- **MySQL**
- **MariaDB**
- **PostgreSQL**
- **SQL Server**

### Database Tables (36+ migrations)
Key tables include:
- `users` - User accounts
- `profile` - Extended user profiles
- `roles` - User roles (Spatie permissions)
- `permissions` - Permissions (Spatie permissions)
- `crop_cat` - Crop categories
- `crop_type` - Crop types
- `crop` - Crops
- `variety` - Crop varieties
- `rootstock` - Rootstocks
- `field` - Farmer fields
- `active_crop` - Active crops on fields
- `sample` - Sample submissions
- `sample_type` - Sample types
- `sample_buffer` - Sample buffer/queue
- `batch` - Sample batches
- `packages` - Test packages
- `individual_parameter` - Individual test parameters
- `payments` - Payment records
- `lab_refrence` - Lab reference numbers (⚠️ **SPELLING ERROR**)
- `field_agent_assignments` - Agent-farmer assignments
- `agent_tasks` - Field agent tasks
- `agent_reports` - Field agent reports
- And more...

### Redis Configuration
- Configured for caching and sessions
- Default connection: `127.0.0.1:6379`

---

## 3. Menu Structure and Naming Issues

### Current Menu Structure

#### Admin Menu
1. **Notifications** - Placeholder (no route)
2. **Role Management** ✓
3. **Farmers** ✓
4. **Crops** (submenu)
   - Crop Categories ✓
   - Crop Types ✓
   - Crops ✓
   - **Variety and Rootstock** ⚠️ (Confusing name - should be separate items)
5. **Field Agents** (submenu)
   - Manage Agents ✓
   - View Assignments ✓
   - Agent Reports ✓
6. **Cases** (submenu) ⚠️ (Poor naming - should be "Test Configuration" or "Sample Configuration")
   - Sample Types ✓
   - Individual Parameters ✓
   - Packages ✓

#### Farmer Menu
1. My Profile ✓
2. My Fields ✓
3. My Crops ✓
4. Request Tests ✓

#### Field Agent Menu
1. Add Farmers ✓
2. Collect Samples ✓
3. Assigned Farmers ✓
4. (Commented out: Fields, Tasks, Reports)

#### Consultant Menu
1. Farmers ✓
2. Assigned Cases ⚠️ (Placeholder - no route)
3. Recommendations ⚠️ (Placeholder - no route)
4. **Farmers** ⚠️ (Duplicate - appears twice)
5. Reports ⚠️ (Placeholder - no route)

#### Front Office Menu
1. **Farmer Management** (submenu)
   - Add New Farmer ✓
   - Manage Farmers ✓
2. Create Samples ✓
3. Accept Samples ✓
4. Batches ✓

#### Lab Scientist Menu
1. Assigned Tests ⚠️ (Placeholder - no route)
2. Upload Results ⚠️ (Placeholder - no route)
3. Reports ⚠️ (Placeholder - no route)

#### Accountant Menu
1. Invoices ⚠️ (Placeholder - no route)
2. Payments ⚠️ (Placeholder - no route)
3. Reports ⚠️ (Placeholder - no route)

### Recommended Menu Naming Fixes

1. **"Cases" → "Test Configuration"** or **"Sample Configuration"**
   - More descriptive of what it contains (Sample Types, Parameters, Packages)

2. **"Variety and Rootstock" → Split into two items:**
   - "Varieties"
   - "Rootstocks"
   - Or keep as "Varieties & Rootstocks" (with ampersand)

3. **Remove duplicate "Farmers"** from Consultant menu

4. **"Post Office" → "Post Office"** (currently `postoffice` in database - should be `post_office`)

5. **Add proper routes** for placeholder menu items or remove them

---

## 4. Code Improvements

### 4.1 Critical Issues

#### Login Logic Bug
**File:** `app/Http/Controllers/auth/loginController.php`
**Issue:** Validates `email` but uses `$request->login` which may not be email
```php
// Line 66-77: Validates email but login input could be username/contact
$request->validate([
    'email' => 'required|email',  // Validates email
    'password' => 'required|string',
]);
$loginInput = $request->login;  // But uses 'login' field
// ... finds user by email/username/contact
if (Auth::attempt($request->only('email', 'password'))) {  // But attempts with 'email'
```
**Fix:** Should validate `login` field and use it consistently, or change form to use `email` field.

#### Inconsistent Controller Naming
**Issue:** Mixed use of `SampleController` and `sampleController` in routes
- `routes/web.php` line 30: Uses `SampleController` (not imported)
- `routes/web.php` line 3: Imports `sampleController` (lowercase)
- `routes/web.php` line 33-34: Uses `sampleController` (lowercase)

**Fix:** Standardize to PascalCase for all controllers.

### 4.2 Naming Convention Issues

#### Controllers
- ✅ Good: `CropController`, `FarmerController`, `SampleController`
- ❌ Inconsistent: `loginController`, `roleController`, `casesController`, `accountantController`
- ❌ Wrong: `scientictController` (should be `scientistController`)

**Recommendation:** Use PascalCase for all controllers (Laravel standard)

#### Models
- ✅ Good: `User`, `Role`
- ❌ Inconsistent: `profileModel`, `sampleModel`, `fieldModel`, `cropModel`
- ❌ Wrong: `labRefModel` (should be `LabReferenceModel`)

**Recommendation:** Use PascalCase without "Model" suffix (Laravel standard: `Profile`, `Sample`, `Field`, `Crop`, `LabReference`)

### 4.3 Code Organization

#### Duplicate Controllers
- `app/Http/Controllers/modules/sampleController.php`
- `app/Http/Controllers/farmer/sampleController.php`
- `app/Http/Controllers/frontoffice/SampleController.php`

**Issue:** Similar functionality in different namespaces, potential code duplication.

**Recommendation:** Consider using a base controller or service pattern.

#### Unused Import
**File:** `routes/web.php`
```php
use PhpParser\Node\Scalar\MagicConst\Dir;  // Line 6 - Not used
```

### 4.4 Database Naming

#### Table Names
- ✅ Good: `users`, `roles`, `samples`, `fields`
- ❌ Wrong: `lab_refrence` (should be `lab_references`)

#### Column Names
- ❌ Inconsistent: `postoffice` (should be `post_office` for consistency with other fields)

### 4.5 Security Improvements

1. **Profile Model Access**
   - Line 81 in `loginController.php`: `$request->session()->put(['id' => $profile->id]);`
   - Should check if `$profile` exists before accessing

2. **Role Validation**
   - Some routes use `role:admin|superadmin` but should verify permissions

3. **Mass Assignment**
   - Models should explicitly define `$fillable` or `$guarded` (most do, but verify all)

### 4.6 Performance Improvements

1. **N+1 Query Issues**
   - Check relationships in views for eager loading opportunities
   - Use `with()` for relationships

2. **Database Queries**
   - `sampleModel.php` line 44: Uses `DB::table('sample')->max('id') + 1` for sample_id
   - Consider using auto-increment or better ID generation

---

## 5. Spelling Mistakes

### 5.1 Code Files

1. **`scientictController.php`** → Should be **`scientistController.php`**
   - File: `app/Http/Controllers/labscientist/scientictController.php`
   - Class: `scientictController` → `scientistController`
   - Used in: `routes/auth.php` line 22, 188

2. **`lab_refrence`** → Should be **`lab_reference`** or **`lab_references`**
   - Migration: `2025_08_07_102014_create_lab_refrence_table.php`
   - Table name: `lab_refrence` → `lab_references`
   - Model: `labRefModel.php` → `LabReferenceModel.php`
   - Used in: `app/Models/labRefModel.php`, `app/Http/Controllers/frontoffice/SampleController.php`

### 5.2 Database/Model Names

1. **`postoffice`** → Should be **`post_office`** (for consistency)
   - Used in: `profile` table, multiple views and controllers
   - Not critical but inconsistent with other field names (e.g., `post_office` would match `field_area`, `field_name` pattern)

### 5.3 Content/UI (if any)
- Review view files for spelling mistakes in user-facing text
- Check for typos in labels, buttons, messages

---

## 6. Structural Issues

### 6.1 Architecture

#### Model Naming Convention
- **Issue:** Mix of `Model` suffix and no suffix
- **Current:** `profileModel`, `sampleModel`, `fieldModel`, `cropModel`, `User`, `Role`
- **Standard:** Laravel uses PascalCase without suffix: `Profile`, `Sample`, `Field`, `Crop`, `User`, `Role`

#### Controller Organization
- **Issue:** Controllers in multiple directories with similar names
- **Structure:**
  - `modules/` - Shared controllers?
  - `farmer/` - Farmer-specific
  - `frontoffice/` - Front office specific
  - `admin/` - Admin specific
  - `fieldAgent/` - Field agent specific
- **Recommendation:** Clarify purpose of `modules/` directory or consolidate

### 6.2 Route Organization

#### Route File Structure
- ✅ Good: Separate route files (`auth.php`, `farmer.php`, `frontOffice.php`)
- ⚠️ Issue: `web.php` has mixed routes and imports
- **Recommendation:** Keep route files role-specific or feature-specific

#### Route Naming
- ✅ Good: Most routes use consistent naming (`admin.*`, `user.*`, `agent.*`)
- ⚠️ Issue: Some routes in `web.php` don't follow prefix pattern

### 6.3 Database Structure

#### Foreign Key Relationships
- **Issue:** Some relationships may not have proper foreign key constraints
- **Recommendation:** Add foreign key constraints in migrations for data integrity

#### Table Naming
- **Issue:** Some tables use singular (`field`, `crop`), some plural (Spatie uses `roles`, `permissions`)
- **Laravel Convention:** Use plural for table names
- **Current State:** Mixed (mostly singular)

### 6.4 Authentication Flow

#### Login Process
- **Issue:** Login validates `email` but form may use `login` field
- **Issue:** Finds user by email/username/contact but attempts auth with email only
- **Recommendation:** Standardize login field or implement proper multi-field authentication

#### Session Management
- **Issue:** Stores profile ID in session without null check
- **Recommendation:** Add validation for profile existence

### 6.5 Code Duplication

#### Role-Based Redirects
- **Issue:** Same role-checking logic in multiple places:
  - `loginController.php`
  - `guestMiddleware.php`
- **Recommendation:** Extract to a service or trait

#### Sample Controllers
- **Issue:** Three different sample controllers with potentially overlapping functionality
- **Recommendation:** Use inheritance or service pattern to reduce duplication

### 6.6 Missing Features

#### Incomplete Roles
- **Consultant:** Dashboard exists but most features are placeholders
- **Lab Scientist:** Dashboard exists but features not implemented
- **Analyst:** Dashboard exists but features not implemented
- **Accountant:** Dashboard exists but features not implemented

**Recommendation:** Either implement features or remove placeholder menu items

---

## Summary of Priority Fixes

### High Priority
1. ✅ Fix spelling: `scientictController` → `scientistController`
2. ✅ Fix spelling: `lab_refrence` → `lab_references`
3. ✅ Fix login logic bug (email vs login field)
4. ✅ Fix inconsistent controller naming in routes (`SampleController` vs `sampleController`)

### Medium Priority
1. Standardize model naming (remove `Model` suffix)
2. Standardize controller naming (use PascalCase)
3. Fix menu naming ("Cases" → "Test Configuration")
4. Remove duplicate menu items
5. Add null checks for profile in login

### Low Priority
1. Rename `postoffice` to `post_office` (database migration)
2. Implement placeholder features or remove menu items
3. Add foreign key constraints
4. Extract duplicate code (role redirects)
5. Review and optimize N+1 queries

---

## Technology Stack

- **Framework:** Laravel 12
- **PHP:** ^8.2
- **Permission System:** Spatie Laravel Permission ^6.21
- **Frontend:** AdminLTE (Bootstrap-based)
- **Database:** SQLite (default), supports MySQL/MariaDB/PostgreSQL/SQL Server

---

*Generated: 2025-01-27*

