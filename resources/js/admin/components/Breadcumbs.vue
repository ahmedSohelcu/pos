<template>
  <!--begin::App Content Header-->
  <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6">
          <h3 class="mb-0">
            <span
              class="breadcrumb-item"
              aria-current="page"
              v-for="(crumb, index) in breadcrumbs"
              :key="index"
            >
              {{ crumb?.label }}
            </span>
          </h3>
        </div>

        <div class="cdol-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>

            <li
              class="breadcrumb-item"
              aria-current="page"
              v-for="(crumb, index) in breadcrumbs"
              :key="index"
            >
              <router-link :to="crumb.to">{{ crumb.label }}</router-link>
            </li>
          </ol>
        </div>
      </div>
      <!--end::Row-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::App Content Header-->
</template>

<script>
export default {
  computed: {
    breadcrumbs() {
      const route = this.$route;
      const matchedRoutes = route.matched;

      return matchedRoutes.map((routeItem) => ({
        label: routeItem.meta.breadcrumb || routeItem.name,
        to: this.getRoutePath(route, routeItem),
      }));
    },
  },
  methods: {
    getRoutePath(route, routeItem) {
      const matchedSegments = route.matched.slice(
        0,
        route.matched.indexOf(routeItem) + 1
      );
      return matchedSegments.map((segment) => segment.path).join('/');
    },
  },
};
</script>
