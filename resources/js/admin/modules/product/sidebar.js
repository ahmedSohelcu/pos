export const ProductMenus = [
  {
    key: 'products',
    label: 'Products',
    icon: 'bi bi-box-seam-fill',
    items: [
      {
        name: 'product.index',
        label: 'Products List',
        access: 'product.view',
      },
      {
        name: 'attribute.index',
        label: 'Attributes / Variations',
        access: 'attribute.view',
      },
      {
        name: 'product.create',
        label: 'Add New Product',
        access: 'product.create',
      },
      {
        name: 'category.index',
        label: 'Categories',
        access: 'category.view',
      },
      {
        name: 'brand.index',
        label: 'Brands',
        access: 'brand.view',
      },
      {
        name: 'unit.index',
        label: 'Units',
        access: 'unit.view',
      },
    ],
  },
];
