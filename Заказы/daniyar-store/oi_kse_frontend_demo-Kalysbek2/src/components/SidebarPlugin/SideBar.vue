<template>
  <div
    class="sidebar"
    :data-color="activeColor"
    :data-image="backgroundImage"
    :data-background-color="backgroundColor"
    :style="sidebarStyle"
  >
    <div class="logo">
      <a class="simple-text logo-mini">
        <div>
          <img :src="logo" />
        </div>
      </a>
      <a class="simple-text logo-normal" target="_blank">
        <template v-if="$route.meta.rtlActive">{{ rtlTitle }}</template>
        <template v-else>{{ title }}</template>
      </a>
      <div class="navbar-minimize">
        <md-button
          id="minimizeSidebar"
          class="md-round md-just-icon md-transparent"
          @click="minimizeSidebar"
        >
          <i class="material-icons text_align-center visible-on-sidebar-regular"
            >more_vert</i
          >
          <i
            class="material-icons design_bullet-list-67 visible-on-sidebar-mini"
            >view_list</i
          >
        </md-button>
      </div>
    </div>
    <div class="sidebar-wrapper" ref="sidebarScrollArea">
      <slot></slot>
      <md-list class="nav">
        <slot name="links">
          <sidebar-item
            v-for="(link, index) in sidebarLinks"
            :key="link.name + index"
            :link="link"
          >
            <sidebar-item
              v-for="(subLink, index) in link.children"
              :key="subLink.name + index"
              :link="subLink"
            >
            </sidebar-item>
          </sidebar-item>
        </slot>
      </md-list>
    </div>
  </div>
</template>
<script>
export default {
  name: 'sidebar',
  props: {
    title: {
      type: String,
      default: 'OI SYSTEM'
    },

    activeColor: {
      type: String,
      default: 'green',
      validator: (value) => {
        let acceptedValues = [
          'blue',
          'purple',
          'azure',
          'green',
          'orange',
          'danger',
          'rose',
          'primary'
        ]
        return acceptedValues.indexOf(value) !== -1
      }
    },
    backgroundImage: {
      type: String,
      default: '/img/main-background-image.jpeg'
    },
    backgroundColor: {
      type: String,
      default: 'black',
      validator: (value) => {
        let acceptedValues = ['', 'black', 'white', 'red']
        return acceptedValues.indexOf(value) !== -1
      }
    },
    logo: {
      type: String,
      default: '/img/logo.png'
    },
    sidebarLinks: {
      type: Array,
      default: () => []
    },
    autoClose: {
      type: Boolean,
      default: false
    }
  },
  provide() {
    return {
      autoClose: this.autoClose
    }
  },
  methods: {
    minimizeSidebar() {
      if (this.$sidebar) {
        this.$sidebar.toggleMinimize()
      }
    }
  },
  computed: {
    sidebarStyle() {
      return {
        backgroundImage: `url(${this.backgroundImage})`
      }
    }
  },
  beforeDestroy() {
    if (this.$sidebar.showSidebar) {
      this.$sidebar.showSidebar = false
    }
  }
}
</script>
<style>
.sidebar-wrapper::-webkit-scrollbar {
  width: 0;
}

@media (min-width: 992px) {
  .navbar-search-form-mobile,
  .nav-mobile-menu {
    display: none;
  }
}
</style>
