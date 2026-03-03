Ahh Ahmed 🔥 — now I understand exactly what you want: a checkbox tree for modules + permissions where:

Each module (like Tenant) has its own parent checkbox

Each action (create, view, update, delete) is a child

If all child permissions are checked, the module checkbox shows as checked automatically

Let’s go step by step, using your permissions table.

1️⃣ Assumptions

Your table:

Schema::create($tableNames['permissions'], static function (Blueprint $table) {
    $table->id(); 
    $table->string('name');          // e.g., tenant.create, tenant.view
    $table->string('guard_name');    // usually 'web' or 'api'
    $table->timestamps();

    $table->unique(['name', 'guard_name']);
});

Permissions are in dot notation: module.action → tenant.create, tenant.view …

You want to render a permission tree in frontend.

2️⃣ Backend: Group Permissions by Module
$permissions = Permission::all(); // or for specific role/plan

$grouped = $permissions->groupBy(function($permission) {
    return explode('.', $permission->name)[0]; // get module, e.g., 'tenant'
});

Result:

[
    'tenant' => [
        'tenant.create',
        'tenant.view',
        'tenant.update',
        'tenant.delete',
    ],
    'brand' => [
        'brand.create',
        'brand.view',
        'brand.update',
        'brand.delete',
    ],
]
3️⃣ Frontend Checkbox Tree (Blade Example)
@foreach ($grouped as $module => $modulePermissions)
    <div class="module">
        <label>
            <input type="checkbox" class="module-checkbox" data-module="{{ $module }}">
            <strong>{{ ucfirst($module) }}</strong>
        </label>
        <div class="permissions ms-3">
            @foreach ($modulePermissions as $permission)
                <label>
                    <input type="checkbox" class="permission-checkbox" data-module="{{ $module }}" value="{{ $permission->id }}">
                    {{ ucfirst(explode('.', $permission->name)[1]) }}
                </label>
            @endforeach
        </div>
    </div>
@endforeach
4️⃣ JavaScript to Auto-Check Module if All Children Checked
document.querySelectorAll('.module-checkbox').forEach(moduleCheckbox => {
    const module = moduleCheckbox.dataset.module;

    // Check children when module is clicked
    moduleCheckbox.addEventListener('change', () => {
        document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`).forEach(child => {
            child.checked = moduleCheckbox.checked;
        });
    });
});

// Check module if all children are checked
document.querySelectorAll('.permission-checkbox').forEach(permissionCheckbox => {
    permissionCheckbox.addEventListener('change', () => {
        const module = permissionCheckbox.dataset.module;
        const children = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`);
        const moduleCheckbox = document.querySelector(`.module-checkbox[data-module="${module}"]`);

        moduleCheckbox.checked = Array.from(children).every(c => c.checked);
    });
});

✅ Features:

Clicking module checkbox selects/deselects all child permissions

Selecting/deselecting child checkboxes updates the module checkbox automatically

Works for any number of modules (tenant, brand, unit, …)

5️⃣ Optional: Pre-Check Already Assigned Permissions

If you pass a $rolePermissions array from backend (e.g., role_permissions.permission_id), you can pre-check:

<input type="checkbox" class="permission-checkbox" data-module="{{ $module }}" value="{{ $permission->id }}"
    @if(in_array($permission->id, $rolePermissions)) checked @endif>

Module checkbox will automatically update with the JS above

6️⃣ Bonus: UX Improvements

Show partial state (indeterminate) if some but not all child permissions are checked:

childrenChecked = Array.from(children).filter(c => c.checked).length;
moduleCheckbox.indeterminate = childrenChecked > 0 && childrenChecked < children.length;

Nice visual cue for partially selected modules

Ahmed, this works perfectly for your POS SaaS.

If you want, I can prepare a full Blade + JS reusable component for all modules and CRUD permissions, ready to plug into your Laravel project.

Do you want me to do that?

yes

Perfect Ahmed 🔥
I’ll give you a complete reusable Blade permission component for your SaaS POS — clean, dynamic, and works for all modules like:

tenant.create

tenant.view

tenant.update

tenant.delete

brand.*

product.*

etc.

This works with your existing permissions table (dot notation).

✅ Step 1: Controller (Send Grouped Permissions)

In your RoleController (create/edit):

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

public function edit(Role $role)
{
    $permissions = Permission::all();

    // Group by module (tenant, brand, product, etc.)
    $groupedPermissions = $permissions->groupBy(function ($permission) {
        return explode('.', $permission->name)[0];
    });

    $rolePermissions = $role->permissions->pluck('id')->toArray();

    return view('roles.edit', compact(
        'role',
        'groupedPermissions',
        'rolePermissions'
    ));
}
✅ Step 2: Reusable Blade Component

Create:

resources/views/components/permission-tree.blade.php
📌 permission-tree.blade.php
<div class="permission-tree">

@foreach ($groupedPermissions as $module => $permissions)
    <div class="card mb-3">
        <div class="card-header">
            <label class="fw-bold">
                <input type="checkbox"
                       class="module-checkbox me-2"
                       data-module="{{ $module }}">
                {{ ucfirst($module) }}
            </label>
        </div>

        <div class="card-body ms-3">
            @foreach ($permissions as $permission)
                @php
                    $action = explode('.', $permission->name)[1];
                @endphp

                <div class="form-check mb-1">
                    <input type="checkbox"
                           name="permissions[]"
                           value="{{ $permission->id }}"
                           class="form-check-input permission-checkbox"
                           data-module="{{ $module }}"
                           id="perm_{{ $permission->id }}"
                           {{ in_array($permission->id, $rolePermissions ?? []) ? 'checked' : '' }}>

                    <label class="form-check-label" for="perm_{{ $permission->id }}">
                        {{ ucfirst($action) }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
@endforeach

</div>
✅ Step 3: Include Component in Role Form

Inside roles/edit.blade.php:

<x-permission-tree 
    :groupedPermissions="$groupedPermissions" 
    :rolePermissions="$rolePermissions ?? []" 
/>
✅ Step 4: JavaScript (Auto Module Check + Indeterminate)

Add this at bottom of page:

<script>
document.addEventListener('DOMContentLoaded', function () {

    function updateModuleState(module) {
        const children = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`);
        const moduleCheckbox = document.querySelector(`.module-checkbox[data-module="${module}"]`);

        const checkedCount = Array.from(children).filter(c => c.checked).length;

        moduleCheckbox.checked = checkedCount === children.length;
        moduleCheckbox.indeterminate = checkedCount > 0 && checkedCount < children.length;
    }

    // When module checkbox is clicked
    document.querySelectorAll('.module-checkbox').forEach(moduleCheckbox => {
        moduleCheckbox.addEventListener('change', function () {
            const module = this.dataset.module;

            document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`)
                .forEach(child => {
                    child.checked = this.checked;
                });
        });
    });

    // When individual permission is clicked
    document.querySelectorAll('.permission-checkbox').forEach(permissionCheckbox => {
        permissionCheckbox.addEventListener('change', function () {
            updateModuleState(this.dataset.module);
        });
    });

    // Initialize states on load
    document.querySelectorAll('.module-checkbox').forEach(moduleCheckbox => {
        updateModuleState(moduleCheckbox.dataset.module);
    });

});
</script>
🎯 What You Get

✔ Click module → selects all CRUD
✔ Select all CRUD → module auto-checks
✔ Partial selection → module shows indeterminate state
✔ Works for unlimited modules
✔ Clean UI
✔ Reusable component

🧠 How It Looks in UI
☑ Tenant
    ☑ Create
    ☑ View
    ☑ Update
    ☑ Delete

◩ Brand   (indeterminate)
    ☑ View
    ☑ Create
    ☐ Update
    ☐ Delete