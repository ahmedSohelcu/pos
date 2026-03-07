<?php

return [
    [
        'name'       => 'expense.create',
        'guard_name' => 'api',
        'tenant_id'  => null
    ],
    [
        'name' => 'expense.update',
        'guard_name' => 'api',
        'tenant_id'  => null
    ],
    [
        'name' => 'expense.delete',
        'guard_name' => 'api',
        'tenant_id'  => null
    ],
    [
        'name' => 'expense.view',
        'guard_name' => 'api',
        'tenant_id'  => null
    ],

     // Expense Category Permissions
    [
        'name'       => 'expense_category.create',
        'guard_name' => 'api',
        'tenant_id'  => null
    ],
    [
        'name'       => 'expense_category.update',
        'guard_name' => 'api',
        'tenant_id'  => null
    ],
    [
        'name'       => 'expense_category.delete',
        'guard_name' => 'api',
        'tenant_id'  => null
    ],
    [
        'name'       => 'expense_category.view',
        'guard_name' => 'api',
        'tenant_id'  => null
    ],
];
