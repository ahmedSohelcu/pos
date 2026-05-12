import { useAuthStore } from '../stores/authStore';

export function filterMenus(menus) {
  const auth = useAuthStore();

  if (auth.isSystemAdmin()) return menus;

  return menus
    .map((menu) => {
      if (!menu) return null;

      // filter children
      if (menu.items?.length) {
        const items = menu.items.filter((item) => auth.hasAccess(item.access));

        if (!items.length) return null;

        return { ...menu, items };
      }

      if (!auth.hasAccess(menu.access)) return null;

      return menu;
    })
    .filter(Boolean);
}
