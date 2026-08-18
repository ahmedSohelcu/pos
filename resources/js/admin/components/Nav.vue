<template>
  <!--begin::Header-->
  <nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Start Navbar Links-->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
            <i class="bi bi-list"></i>
          </a>
        </li>
        <li class="nav-item d-none d-md-block">
          <a href="#" class="nav-link">POS</a>
        </li>
        <li class="nav-item d-none d-md-block">
          <a href="#" class="nav-link">Contact</a>
        </li>
      </ul>
      <!--end::Start Navbar Links-->
      <!--begin::End Navbar Links-->
      <ul class="navbar-nav ms-auto">
        <!--begin::Navbar Search-->
        <li class="nav-item">
          <a
            class="nav-link"
            data-widget="navbar-search"
            href="#"
            role="button"
          >
            <i class="bi bi-search"></i>
          </a>
        </li>

        <!--begin::Theme Toggle-->
        <li class="nav-item">
          <a
            class="nav-link"
            href="#"
            role="button"
            title="Toggle theme"
            @click.prevent="themeStore.toggle()"
          >
            <i
              class="bi"
              :class="themeStore.theme === 'dark' ? 'bi-sun-fill' : 'bi-moon-stars-fill'"
            ></i>
          </a>
        </li>
        <!--end::Theme Toggle-->
        <!--begin::Language Switch-->
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            data-bs-toggle="dropdown"
            href="#"
            role="button"
          >
            <i class="bi bi-globe me-2"></i> Language
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
            <a
              href="#"
              class="dropdown-item"
              @click.prevent="switchLanguage('en')"
            >
              <span class="me-2 flag-united-states"></span> English (US)
            </a>
            <a
              href="#"
              class="dropdown-item"
              @click.prevent="switchLanguage('bn')"
            >
              <span class="me-2 flag-bangladesh"></span> Bangla (BD)
            </a>
            <a
              href="#"
              class="dropdown-item"
              @click.prevent="switchLanguage('ar')"
            >
              <span class="me-2 flag-saudi-arabia"></span> Arabic (SA)
            </a>
          </div>
        </li>
        <!--end::Language Switch-->
        <!--end::Navbar Search-->
        <!--begin::Messages Dropdown Menu-->
        <li class="nav-item dropdown">
          <a class="nav-link" data-bs-toggle="dropdown" href="#">
            <i class="bi bi-chat-text"></i>
            <span class="navbar-badge badge text-bg-danger">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
            <a href="#" class="dropdown-item">
              <!--begin::Message-->
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <img
                    src="admin/v1/assets/img/user1-128x128.jpg"
                    alt="User Avatar"
                    class="img-size-50 rounded-circle me-3"
                  />
                </div>
                <div class="flex-grow-1">
                  <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-end fs-7 text-danger"
                      ><i class="bi bi-star-fill"></i
                    ></span>
                  </h3>
                  <p class="fs-7">Call me whenever you can...</p>
                  <p class="fs-7 text-secondary">
                    <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                  </p>
                </div>
              </div>
              <!--end::Message-->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!--begin::Message-->
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <img
                    src="admin/v1/assets/img/user8-128x128.jpg"
                    alt="User Avatar"
                    class="img-size-50 rounded-circle me-3"
                  />
                </div>
                <div class="flex-grow-1">
                  <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-end fs-7 text-secondary">
                      <i class="bi bi-star-fill"></i>
                    </span>
                  </h3>
                  <p class="fs-7">I got your message bro</p>
                  <p class="fs-7 text-secondary">
                    <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                  </p>
                </div>
              </div>
              <!--end::Message-->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!--begin::Message-->
              <div class="d-flex">
                <div class="flex-shrink-0">
                  <img
                    src="admin/v1/assets/img/user3-128x128.jpg"
                    alt="User Avatar"
                    class="img-size-50 rounded-circle me-3"
                  />
                </div>
                <div class="flex-grow-1">
                  <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-end fs-7 text-warning">
                      <i class="bi bi-star-fill"></i>
                    </span>
                  </h3>
                  <p class="fs-7">The subject goes here</p>
                  <p class="fs-7 text-secondary">
                    <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                  </p>
                </div>
              </div>
              <!--end::Message-->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer"
              >See All Messages</a
            >
          </div>
        </li>
        <!--end::Messages Dropdown Menu-->
        <!--begin::Notifications Dropdown Menu-->
        <li class="nav-item dropdown">
          <a class="nav-link" data-bs-toggle="dropdown" href="#">
            <i class="bi bi-bell-fill"></i>
            <span class="navbar-badge badge text-bg-warning">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="bi bi-envelope me-2"></i> 4 new messages
              <span class="float-end text-secondary fs-7">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="bi bi-people-fill me-2"></i> 8 friend requests
              <span class="float-end text-secondary fs-7">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
              <span class="float-end text-secondary fs-7">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">
              See All Notifications
            </a>
          </div>
        </li>
        <!--end::Notifications Dropdown Menu-->
        <!--begin::Fullscreen Toggle-->
        <li class="nav-item">
          <a class="nav-link" href="#" data-lte-toggle="fullscreen">
            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
            <i
              data-lte-icon="minimize"
              class="bi bi-fullscreen-exit"
              style="display: none"
            ></i>
          </a>
        </li>
        <!--end::Fullscreen Toggle-->
        <!--begin::User Menu Dropdown-->
        <li class="nav-item dropdown user-menu">
          <a
            href="#"
            class="nav-link dropdown-toggle"
            data-bs-toggle="dropdown"
          >
            <img
              src="admin/v1/assets/img/user2-160x160.jpg"
              class="user-image rounded-circle shadow"
              alt="User Image"
            />
            <!-- <span class="d-none d-md-inline">Alexander </span> -->
          </a>
          <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
            <!--begin::User Image-->
            <li class="user-header text-bg-primary text-center">
              <img
                src="admin/v1/assets/img/user2-160x160.jpg"
                class="rounded-circle shadow mx-auto d-block"
                alt="User Image"
              />
              <p v-if="auth.user">
                <small>Member since {{ auth.user.name ?? '' }}</small>
                <small>
                  Member since
                  {{ formatDateDayYear(auth.user.created_at) ?? '' }}
                </small>
              </p>
            </li>
            <!--end::User Image-->
            <!--begin::Menu Body-->
            <!-- <li class="user-body"> -->
            <!--begin::Row-->
            <!-- <div class="row">
                <div class="col-4 text-center"><a href="#">Followers</a></div>
                <div class="col-4 text-center"><a href="#">Sales</a></div>
                <div class="col-4 text-center"><a href="#">Friends</a></div>
              </div> -->
            <!--end::Row-->
            <!-- </li> -->
            <!--end::Menu Body-->
            <!--begin::Menu Footer-->
            <li class="user-footer">
              <a href="#" class="btn btn-default btn-flat">Profile</a>
              <a
                href="#"
                @click="signOut"
                class="btn btn-default btn-flat float-end"
                >Sign out</a
              >
            </li>
            <!--end::Menu Footer-->
          </ul>
        </li>
        <!--end::User Menu Dropdown-->
      </ul>
      <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
  </nav>
  <!--end::Header-->
</template>

<script setup>
import { useI18n } from 'vue-i18n';
import { useAuthStore } from '../../ahmed-vue-kit/stores/authStore';
import { useThemeStore } from '../../ahmed-vue-kit/stores/themeStore';
import { useRouter } from 'vue-router';
import { notify } from '@kit/composables/useNotify';
import {
  formatDate,
  formatDateDayYear,
} from '../../ahmed-vue-kit/utils/helpers';
const router = useRouter();
const { locale } = useI18n();
const auth = useAuthStore();
const themeStore = useThemeStore();

const switchLanguage = (lang) => {
  locale.value = lang;
};

const signOut = async () => {
  try {
    const res = await auth.logout();

    notify.success(res?.data?.message || 'Logout Successfully');

    router.replace({ name: 'Login' }); // better than push
  } catch (error) {
    notify.error('Logout failed');
  }
};
</script>
