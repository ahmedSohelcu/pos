## 🚀 Grocery SaaS app need to concern about 🚀

# Todo

- assign Role & Permissions to Users
- Protect Routes / API
- Optional: Tie Features to Permissions
- laravel response handler
- Everything Tenant Based
- Role Permission
- Seed walkin custome for each tenant
- For production need to set a default error for exception (not to show actual error to user)

## pos page

💡 👉 📊 🧱 🛠 🎨 😎 👍️✔️

https://demo.workdo.io/pos-saas/pos

## 👉 All essential command

- php artisan featues : sync
  - to update plan featues from permissions

- php artisan module:make Feature
- php artisan module:make Category Brand Customer Unit
- php artisan module:make-migration create_features_table Feature
- php artisan make:service Tenant --module=Tenant
- pa module:make-model Feature Feature
- php artisan module:make-migration create_plan_features_table Feature
- php artisan module:make-migration add_tenant_id_to_user_table Tenant
- pa module:make-request TenantRequest Tenant

  ### vue file or module with command
  - php artisan make:vue admin/test
  - php artisan make:vue-module users
    - will create modules in js/admin folder

  ### make service
  - php artisan make:service Tenant --module=Tenant

  ### make trait
  - pa make:trait Requests/CommonRules

### Requet for module

- pa module:make-request TenantRequest Tenant

### Update permissions and features

- pa db:seed --class=PermissionSeeder
- pa features:sync

### Laravel make auto index for unique, foreign key

$payment->invoice_no = 'INV-' . now()->format('Ymd') . '-' . str_pad($payment->id, 5, '0', STR_PAD_LEFT);

# Index

- Todo
- Frontend Technologies
- Backend Technologies
- Grocery Demo Link
- Application Features and Table Schema
- Frontend Packages
- Backend Packages
- Create Service For main app and modules
- Create Vue File
- Command List
- Controller return response Example
- Table / crud list
-

# Crud List

- Tenants ✔️
- User ✔️
- Role ✔️
- Permission ✔️
-
- Category ✔️
- Brand ✔️
- unit ✔️
-
- Feature ✔️
- Plan ✔️
- Subscription ✔️
- Customer
- Sales / order
- purchase
- language
- Tax
- POS
- Discount
- Currency
- Notifications
- Mobile app support
- expense category
- expense
- supplier
- Products

## Product & Inventory
- Product create/edit/delete/view
- Product categories, brands, units
- Batch management (for medicine expiration)
- Stock tracking & alerts for low stock
- Inventory view by branch/warehouse
- Barcode / QR code support


## Branch & Outlet Management

- Branch create/edit/delete/view
- Assign products & stock per branch
- Branch-wise sales & inventory reporting
-

## Customer & Supplier Management

- Customer create/edit/delete/view
- Supplier create/edit/delete/view
- Customer loyalty / reward points (optional)
- Supplier purchase history & orders

## Sales & Billing

- POS billing (quick invoice generation)
- Support multiple payment methods (cash, card, mobile)
- Apply discounts, taxes, promo codes
- Invoice / receipt printing and emailing
- Split bill / partial payments
- Refunds / returns handling

## Purchase & Stock In

- Purchase order create/edit/receive
- Track incoming stock and supplier invoices
- Expiry date tracking for medicine
- Batch-wise stock management

## Settings & Configurations

- Tax settings (VAT, GST)
- Discount rules
- Currency / store info
- POS receipt templates
- Barcode format settings

## Reports

- Sales reports (daily, weekly, monthly)
- Inventory reports (current stock, low stock)
- Product-wise sales report
- Customer purchase report
- Branch-wise performance report
- Tax reports

---

#### ✅ Frontend Technologies

---

- Vue 3 (Composition API)
- Pinia
- Bootstrap 5.3
- Axios
- Vite
- vue-quill
- flatpickr - for daterange picker
- select2
- sweetalert2
- vue router
- vue toastification
- ziggy-js ( to use route from vue file)
- ***

#### ✅ Backend Technologies

---

- Laravel 12 [Documentation](https://laravel.com/)
- Module package [nwidart/laravel-modules](https://nwidart.com/laravel-modules/v6/introduction)
  - #### nwidart Module Commands List [click here][modulecommand]

    ## [modulecommand]: https://nwidart.com/laravel-modules/v6/advanced-tools/artisan-commands

- Sanctum
- 01.DB transaction
- 02.row locking
- 03.stock validation at checkout
- 04.overselling prevention

<br>

# Command List

### 01. Create Service For main app and modules

      01. php artisan make:service TestService

      02. php artisan make:service Product --module=Product

### 02. Create Vue File

    01. php artisan make:vue admin/pages/Ahmed

        will create file in js/admin/pages/Ahmed. vue

### 03. Laravel Module Command

- Module package [nwidart/laravel-modules](https://nwidart.com/laravel-modules/v6/introduction)
  - php artisan module:make <module-name>
  - php artisan module:make Blog User Auth
  - php artisan module:make Blog --plain (only module)
  - php artisan module:list
  - php artisan module:migrate-rollback Blog
  - php artisan module:v6:migrate
  - php artisan module:seed Blog
  - php artisan module:publish-config Blog
  - php artisan module:publish-translation Blog
  - php artisan module:enable Blog
  - php artisan module:disable Blog
  - php artisan module:update Blog
  - php artisan module:make-command CreatePostCommand Blog

### Grocery Demo Link

```php

    https://demo.workdo.io/pos-saas/pos
    https://demo.workdo.io/pos-saas/settings

    https://grocery.acnoo.xyz/business/sales/create

    https://readypos.razinsoft.com/purchase/list

    https://zaisub.zainikthemes.com/admin/profile

```

    <br/>

## Application Features and Table Schema

💡 👉 📊 🧱 🛠 🎨 😎

# Translated Tables needed for

- categories
- category_translations
- sub_categories
- sub_category_translations
- products
- product_translations
- brands
- brand_translations
- units
- unit_translations
- payment_methods
- payment_method_translations
- expense_types
- expense_type_translations

  <br>

# ❌ DO NOT CREATE Translation Tables For

- users
- roles
- permissions
- subscriptions
- orders
- order_items
- stock_movements
- transactions - these table later
- tenants
- settings

🧠 Rule You Should Always Follow

If the data:

✔ Is shown to customer
✔ Is marketing content
✔ Can change per language

→ Use translation table.

If the data:

✔ Is system logic
✔ Used in permission checking
✔ Used internally only

→ DO NOT translate in DB.

### New Tables or Extara Column Need to Add

## languages Table

- id
- name (English, Bangla)
- code (en, bn)
- direction (ltr, rtl)
- is_default (boolean)
- is_active (boolean)
- created_at
- updated_at

## Users Table

- Role
- status_id
- tenant_id
- language_id ← user’s preferred language //If language_id is null → use languages.is_default

## Roles Table

- id
- name
- description
- status
- tenant_id

## Permissions Table

- - id
- name - e.g., view_orders, manage_products
- description
- status

## role_permissions

- id
- role_id
- permission_id

## user_roles

- id
- user_id
- role_id

## featres - d

    * Id
    * name
    * description

## plan_features - d

- Id
- plan_id
- feature_id
- limit - int

## Subscription Table -d

- id
- tenant_id
- plan_id
- start_date - date
- end_date - date
- status
- gateway_ref_id
- // subscriptions table
  tenant_id
  plan_id
  payment_gateway // stripe/bkash/nagad
  payment_status // pending/active/canceled
  amount
  start_date
  end_date
  next_billing_at
  gateway_reference_id // transaction ID
- - Tracks whether the last payment was successful. Examples: pending, success, failed. This is transaction-level.
  - Gateway transaction reference

- plan is active or expired
  - //payment_status //active, pending, canceled ->default('pending');
  - payment_gateway //->default('stripe, ');
    $tenant->next_billing_at = now()->addMonth(); // or add 3 months

      <!-- stripe_id string	Only if Stripe is used
    <!-- payment_gateway	string	'stripe', 'bkash', 'nagad', 'rocket' -->
    <!-- payment_status	enum	'active', 'pending', 'canceled' -->
    <!-- next_billing_at	timestamp	Next payment due date -->

  ## Payments Table -d
  - Id
  - user_id
  - subscription_id
  - amount
  - payment_method
  - status
  - transaction_id
  -

  ## Tenants Table -d
  - Id - PK
  - name - Company/store name
  - subdomain - Unique subdomain (for SaaS)
  - plan_id
  - status_id
  - $tenant->payment_status = 'success'; pending, success, failed // payment verified
$tenant->plan_status = 'active'; // subscription is now active
    $tenant->next_billing_at = now()->addMonths(1); // or 3 for quarterly
$tenant->save();

### Grocery Demo Link

    https://grocery.acnoo.xyz/business/sales/create

    <br/>

`````php
Schema::create('units', function (Blueprint $table) {
    $table->id();
    $table->string('name');// Kilogram, Gram, Sack, Liter, Piece
    $table->string('symbol');// kg, g, sack, l, pc
    $table->decimal('conversion_to_base', 10, 4)->default(1);//conversion to base unit
    $table->timestamps();
});


<br/>

Examples:

````sql
---------------------------------------
name	    symbol	conversion_to_base
---------------------------------------
Kilogram	kg	    1.0000
Gram	    g	    0.0010
Sack	    sack	50.0000
Liter	    l	    1.0000
Piece	    pc	    1.0000


💡 👉 📊 🧱 🛠 🎨 😎

```php
Schema::create('units', function (Blueprint $table) {
    $table->id();
    $table->string('name');// Kilogram, Gram, Sack, Liter, Piece
    $table->string('symbol');// kg, g, sack, l, pc
    $table->decimal('conversion_to_base', 10, 4)->default(1);//conversion to base unit
    $table->timestamps();
});
`````

<br/>

\*\* Examples:

```sql
---------------------------------------
name	    symbol	conversion_to_base
---------------------------------------
Kilogram	kg	    1.0000
Gram	    g	    0.0010
Sack	    sack	50.0000
Liter	    l	    1.0000
Piece	    pc	    1.0000
```

💡 👉 📊 🧱 🛠 🎨 😎

## Frontend Packages

- npm install vue-i18n - for vue lang

## Backend Packages

- view-toastification
  - https://vue-toastification.maronato.dev/
  - composer require nwidart/laravel-modules
  - composer require spatie/laravel-permission
-

## Documentation

with VuePress.

## Application Features and Table Schema

# Controller Return Response Message Example

````php
<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
          // No try/catch needed anymore: added in bootstrap/app.php

        // public function store(Request $request)        // {
        //     $customer = Customer::create($request->validated());
        //     return created_response('Customer', [
        //         'data' => $customer
        //     ]);
        // }

    // public function store(Request $request)
    // {
    //     try {
    //         $customer = Customer::create($request->all());

    //         return created_response('Customer', ['data' => $customer]);

    //     } catch (\Exception $e) {
    //         return failed_response(['errors' => ['exception' => $e->getMessage()]]);
    //     }
    // }

  // DB Transatio Example
  // public function storeUserWithProfile(Request $request)
  // {
  //     try {
  //         $result = DB::transaction(function () use ($request) {

  //             // 1. Create User
  //             $user = User::create($request->only(['name', 'email', 'password']));        //

  //             // return all created data
  //             return [
  //                 'user' => $user,
  //                 'profile' => $profile
  //             ];
  //         });

  //         // Transaction succeeded → return professional response
  //         return created_response('User', ['data' => $result]);

  //     } catch (\Exception $e) {
  //         // Transaction failed → rollback automatically
  //         return failed_response([
  //             'errors' => ['exception' => $e->getMessage()]
  //         ]);
  //     }
  // }

    public function update(Request $request, Customer $customer)
    {
        try {
            $customer->update($request->all());

            return updated_response('Customer', ['data' => $customer]);

        } catch (\Exception $e) {
            return failed_response(['errors' => ['exception' => $e->getMessage()]]);
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();

            return deleted_response('Customer');

        } catch (\Exception $e) {
            return failed_response(['errors' => ['exception' => $e->getMessage()]]);
        }
    }
}

```php



```json

https://dummyjson.com/products

"products": [
    {
      "id": 1,
      "title": "Essence Mascara Lash Princess",
      "description": "The Essence Mascara Lash Princess is a popular mascara known for its volumizing and lengthening effects. Achieve dramatic lashes with this long-lasting and cruelty-free formula.",
      "category": "beauty",
      "price": 9.99,
      "discountPercentage": 10.48,
      "rating": 2.56,
      "stock": 99,
      "tags": [
        "beauty",
        "mascara"
      ],
      "brand": "Essence",
      "sku": "BEA-ESS-ESS-001",
      "weight": 4,
      "dimensions": {
        "width": 15.14,
        "height": 13.08,
        "depth": 22.99
      },
      "warrantyInformation": "1 week warranty",
      "shippingInformation": "Ships in 3-5 business days",
      "availabilityStatus": "In Stock",
      "reviews": [
        {
          "rating": 3,
          "comment": "Would not recommend!",
          "date": "2025-04-30T09:41:02.053Z",
          "reviewerName": "Eleanor Collins",
          "reviewerEmail": "eleanor.collins@x.dummyjson.com"
        },
        {
          "rating": 4,
          "comment": "Very satisfied!",
          "date": "2025-04-30T09:41:02.053Z",
          "reviewerName": "Lucas Gordon",
          "reviewerEmail": "lucas.gordon@x.dummyjson.com"
        },
        {
          "rating": 5,
          "comment": "Highly impressed!",
          "date": "2025-04-30T09:41:02.053Z",
          "reviewerName": "Eleanor Collins",
          "reviewerEmail": "eleanor.collins@x.dummyjson.com"
        }
      ],
      "returnPolicy": "No return policy",
      "minimumOrderQuantity": 48,
      "meta": {
        "createdAt": "2025-04-30T09:41:02.053Z",
        "updatedAt": "2025-04-30T09:41:02.053Z",
        "barcode": "5784719087687",
        "qrCode": "https://cdn.dummyjson.com/public/qr-code.png"
      },
      "images": [
        "https://cdn.dummyjson.com/product-images/beauty/essence-mascara-lash-princess/1.webp"
      ],
      "thumbnail": "https://cdn.dummyjson.com/product-images/beauty/essence-mascara-lash-princess/thumbnail.webp"
    },
]
````
