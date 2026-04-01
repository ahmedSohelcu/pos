export const ProductMenus = [
  {
    key: 'products',
    label: 'Products',
    icon: 'bi bi-box-seam-fill',
    items: [
      {
        name: 'attribute.index',
        label: 'Attributes / Variations',
        access: 'attribute.view',
      },
      {
        name: 'brand.index',
        label: 'Add New Product',
        access: 'brand.view',
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
