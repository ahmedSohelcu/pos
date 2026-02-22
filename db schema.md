
----------------------------------
# 🚀 Grocery SaaS app need to concern about 🚀
----------------------------------
💡  👉  📊  🧱  🛠  🎨  😎 

# New Table or Extara Column Need to Add

## Users Table
* Role  
* status_id
* tenant_id
* 

## Roles Table
* id
* name
* description
* status
* tenant_id
  

## Permissions Table
* * id
* name - e.g., view_orders, manage_products
* description
* status

## role_permissions
* id
* role_id
* permission_id
  

## user_roles
* id
* user_id
* role_id


## Plans Table
  * ID
  * Name
  * Price - decimal
  * duration_days
  * status

## featres
  * Id
  * name
  * description

## plan_features
* Id
* plan_id
* feature_id
* limit - int

## Subscription Table
* id
* tenant_id
* plan_id
* start_date - date
* end_date - date
* status
* payment_status


## Payments Table
* Id
* user_id
* subscription_id
* amount
* payment_method
* status
* transaction_id
*  


## Tenants Table
* Id - PK
* name - Company/store name
* subdomain - Unique subdomain (for SaaS)
* plan_id
* status_id
  

### Grocery Demo Link

    https://grocery.acnoo.xyz/business/sales/create
    
    <br/>

```php
Schema::create('units', function (Blueprint $table) {
    $table->id();
    $table->string('name');// Kilogram, Gram, Sack, Liter, Piece
    $table->string('symbol');// kg, g, sack, l, pc
    $table->decimal('conversion_to_base', 10, 4)->default(1);//conversion to base unit
    $table->timestamps();
});
```

<br/>

** Examples:
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


# Get Started

This is a normal page, which contains VuePress basics.

## Pages

You can add markdown files in your vuepress directory, every markdown file will be converted to a page in your site.
My  Laravel vue3 [laravue project ][laravue]project
See [routing][] for more details.

## Content

Every markdown file [will be rendered to HTML, then converted to a Vue SFC][content].

VuePress support basic markdown syntax and [some extensions][synatex-extensions], you can also [use Vue features][vue-feature] in it.

## Configuration

VuePress use a `.vuepress/config.js`(or .ts) file as [site configuration][config], you can use it to config your site.

For [client side configuration][client-config], you can create `.vuepress/client.js`(or .ts).

Meanwhile, you can also add configuration per page with [frontmatter][].

## Layouts and customization

Here are common configuration controlling layout of `@vuepress/theme-default`:

- [navbar][]
- [sidebar][]

Check [default theme docs][default-theme] for full reference.

You can [add extra style][style] with `.vuepress/styles/index.scss` file.

[routing]: https://vuejs.press/guide/page.html#routing
[content]: https://vuejs.press/guide/page.html#content
[synatex-extensions]: https://vuejs.press/guide/markdown.html#syntax-extensions
[vue-feature]: https://vuejs.press/guide/markdown.html#using-vue-in-markdown
[config]: https://vuejs.press/guide/configuration.html#client-config-file
[client-config]: https://vuejs.press/guide/configuration.html#client-config-file
[frontmatter]: https://vuejs.press/guide/page.html#frontmatter
[navbar]: https://vuejs.press/reference/default-theme/config.html#navbar
[sidebar]: https://vuejs.press/reference/default-theme/config.html#sidebar
[default-theme]: https://vuejs.press/reference/default-theme/
[style]: https://vuejs.press/reference/default-theme/styles.html#style-file
[laravue]:http://lara-vue-admin.test/component








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
```