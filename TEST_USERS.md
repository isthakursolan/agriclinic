# Test Users for Agriclinic

## ✅ Current Database Users (Actual)
Based on database query, there are currently **11 users** in the database:

| Email | Username | Role | Name | Contact | Password |
|-------|----------|------|------|---------|----------|
| **accountant@agriclinic.in** | accountant | accountant | Test Accountant | 9765765456 | **123456** ✅ |
| **admin@admin.com** | admin | admin | admin | 8888888888 | **123456** ✅ |
| **analyst@agriclinic.in** | analyst | analyst | Test Analyst | 8765453456 | **123456** ✅ |
| **collection@agriclinic.in** | collection_center | collection_center | collection center | 7656798767 | **123456** ✅ |
| **consultant@agriclinic.in** | consultant | consultant | Test Consultant | 9876567856 | **123456** ✅ |
| **fieldagent@agriclinic.in** | fieldagent | field_agent | Test Field Agent | 8795642468 | **123456** ✅ |
| **frontoffice@agriclinic.in** | frontoffice | front_office | Front Office Staff | 7689765666 | **123456** ✅ |
| **pankaj@yopmail.com** | pnk-farmer | farmer | Pankaj Farmer | 9518289118 | **123456** ✅ |
| **scientist@agriclinic.in** | scientist | lab_scientist | Test Scientist | 8976980757 | **123456** ✅ |
| **superadmin@admin.com** | superadmin | superadmin | superadmin | 7777777777 | **123456** ✅ |
| **test@example.com** | farmer | farmer | test | 1111111111 | **123456** ✅ |

**Status:** All passwords have been updated to `123456` ✅

---

## 📋 Expected Test Users (from DatabaseSeeder.php)

The following test users should be created when running the seeder. If they don't exist, run:
```bash
php artisan db:seed --class=DatabaseSeeder
```

### Test User Credentials (All passwords should be: `123456`)

**Note:** These users are defined in the seeder but may not exist in your database yet. To create them, run:
```bash
php artisan db:seed --class=DatabaseSeeder
```

Then update all passwords:
```bash
php artisan tinker --execute="use App\Models\User; use Illuminate\Support\Facades\Hash; \$users = User::all(); foreach(\$users as \$u) { \$u->password = Hash::make('123456'); \$u->save(); } echo 'Updated ' . \$users->count() . ' users';"
```

| Email | Username | Role | Name | Contact | Password |
|-------|----------|------|------|---------|----------|
| **test@example.com** | farmer | farmer | test | 1111111111 | 123456 |
| **admin@admin.com** | admin | admin | admin | 8888888888 | 123456 |
| **superadmin@admin.com** | superadmin | superadmin | superadmin | 7777777777 | 123456 |
| **consultant@agriclinic.in** | consultant | consultant | Test Consultant | 9876567856 | 123456 |
| **analyst@agriclinic.in** | analyst | analyst | Test Analyst | 8765453456 | 123456 |
| **scientist@agriclinic.in** | scientist | lab_scientist | Test Scientist | 8976980757 | 123456 |
| **accountant@agriclinic.in** | accountant | accountant | Test Accountant | 9765765456 | 123456 |
| **fieldagent@agriclinic.in** | fieldagent | field_agent | Test Field Agent | 8795642468 | 123456 |
| **frontoffice@agriclinic.in** | frontoffice | front_office | Front Office Staff | 7689765666 | 123456 |
| **collection@agriclinic.in** | collection_center | collection_center | collection center | 7656798767 | 123456 |

---

## Quick Reference by Role

### Admin
- **admin@admin.com** / `123456`
- **superadmin@admin.com** / `123456`

### Farmer
- **test@example.com** / `123456`
- **pankaj@yopmail.com** / `123456` (currently in DB)

### Field Agent
- **fieldagent@agriclinic.in** / `123456`

### Front Office
- **frontoffice@agriclinic.in** / `123456`

### Consultant
- **consultant@agriclinic.in** / `123456`

### Lab Scientist
- **scientist@agriclinic.in** / `123456`

### Analyst
- **analyst@agriclinic.in** / `123456`

### Accountant
- **accountant@agriclinic.in** / `123456`

### Collection Center
- **collection@agriclinic.in** / `123456`

---

## To Update All Passwords to 123456

Run this command:
```bash
php artisan tinker --execute="use App\Models\User; use Illuminate\Support\Facades\Hash; \$users = User::all(); foreach(\$users as \$u) { \$u->password = Hash::make('123456'); \$u->save(); } echo 'Updated ' . \$users->count() . ' users';"
```

Or use this PHP script:
```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$users = User::all();
foreach($users as $user) {
    $user->password = Hash::make('123456');
    $user->save();
}
```

---

*Last updated: 2025-01-27*

