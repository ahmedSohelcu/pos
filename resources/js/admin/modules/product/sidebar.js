import { productPermissions } from './permissions';
import { brandPermissions } from '../brands/permissions';
import { unitPermissions } from '../units/permissions';
import { categoryPermissions } from '../categories/permissions';

export const ProductMenus = [
  {
    key: 'products',
    label: 'Products',
    icon: 'bi bi-box-seam-fill',
    items: [
      {
        name: 'component',
        label: 'Grocery Products',
        permission: '',
      },
      {
        name: 'component',
        label: 'Medicine Products',
        permission: '',
      },
      {
        name: 'component',
        label: 'Add New Product',
        permission: '',
      },
      {
        name: 'category.index',
        label: 'Categories',
        permission: '',
      },
      {
        name: 'brand.index',
        label: 'Brands',
        permission: '',
      },
      {
        name: 'unit.index',
        label: 'Units',
        permission: '',
      },
    ],
  },
];
