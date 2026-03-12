export const ProductMenus = [
  {
    key: 'products',
    label: 'Products',
    icon: 'bi bi-box-seam-fill',
    items: [
      {
        name: 'component',
        label: 'Add New Product',
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
