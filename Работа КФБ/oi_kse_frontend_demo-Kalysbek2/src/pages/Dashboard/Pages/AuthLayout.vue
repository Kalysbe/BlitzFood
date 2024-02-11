<template>
  <div class="full-page" :class="{'nav-open': $sidebar.showSidebar}">
    <md-toolbar md-elevation="0"  class="md-transparent md-toolbar-absolute">
      <div class="md-toolbar-row md-offset" style="background:rgba(221,223,223,0.1);">
         <div class="md-toolbar-section-start">
          <md-button slot="title" class="md-simple" href="/">
            <img src="/img/logoKSE.png" style="max-width:60%;min-width:200px" />
          </md-button>
        </div>
        <div class="md-toolbar-section-end">
          <md-button
            class="md-just-icon md-simple md-round md-toolbar-toggle"
            :class="{ toggled: $sidebar.showSidebar }"
            @click="toggleSidebar"
          >
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </md-button>

          <div
            class="md-collapse"
            :class="{ 'off-canvas-sidebar': responsive }"
          >
            <md-list class="navigation-menu responsive-menu">
                  <router-link  v-for="item in $t('pageAuthLayout.navbarItems')" :key="item.id"  tag="md-list-item" :to="'/' + $i18n.locale + item.link">
                    {{item.name}}
                  </router-link>
                  <!-- <router-link :to="'/' + $i18n.locale + '/'" tag="md-list-item">Главная</router-link>
                  <router-link :to="'/' + $i18n.locale + '/openinformation'" tag="md-list-item">Центр раскрытии информации</router-link> -->
              </md-list>
          </div>
        </div>
      </div>
    </md-toolbar>
    <div class="wrapper wrapper-full-page" @click="toggleSidebarPage">
      <div
        class="page-header header-filter"
        :class="setPageClass"
        filter-color="black"
        :style="setBgImage"
      >
        <div class="container md-offset" style="padding-top:100px">
          <zoom-center-transition
            :duration="pageTransitionDuration"
            mode="out-in"
          >
            <router-view></router-view>
          </zoom-center-transition>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {ZoomCenterTransition} from 'vue2-transitions'

export default {
  components: {
    ZoomCenterTransition
  },
  props: {
    backgroundColor: {
      type: String,
      default: 'black'
    }
  },
  inject: {
    autoClose: {
      default: true
    }
  },
  data() {
    return {
      responsive: false,
      showMenu: false,
      menuTransitionDuration: 250,
      pageTransitionDuration: 300,
      year: new Date().getFullYear()
    }
  },
  computed: {
    setBgImage() {
      let images = {
        Pricing: '/img/bg-pricing.jpg',
        Login: '/img/main-background-image.jpeg',
        Register: '/img/register.jpg',
        Lock: '/img/lock.jpg'
      }
      return {
        backgroundImage: `url(${images[this.$route.name]})`
      }
    },
    setPageClass() {
      return `${this.$route.name}-page`.toLowerCase()
    }
  },
  methods: {
    toggleSidebarPage() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.displaySidebar(false)
      }
    },
    linkClick() {
      if (
        this.autoClose &&
        this.$sidebar &&
        this.$sidebar.showSidebar === true
      ) {
        this.$sidebar.displaySidebar(false)
      }
    },
    toggleSidebar() {
      this.$sidebar.displaySidebar(!this.$sidebar.showSidebar)
    },
    toggleNavbar() {
      document.body.classList.toggle('nav-open')
      this.showMenu = !this.showMenu
    },
    closeMenu() {
      document.body.classList.remove('nav-open')
      this.showMenu = false
    },
    onResponsiveInverted() {
      if (window.innerWidth < 991) {
        this.responsive = true
      } else {
        this.responsive = false
      }
    }
  },
  mounted() {
    this.onResponsiveInverted()
    window.addEventListener('resize', this.onResponsiveInverted)
  },
  beforeDestroy() {
    this.closeMenu()
    window.removeEventListener('resize', this.onResponsiveInverted)
  },
  beforeRouteUpdate(to, from, next) {
    // Close the mobile menu first then transition to next page
    if (this.showMenu) {
      this.closeMenu()
      setTimeout(() => {
        next()
      }, this.menuTransitionDuration)
    } else {
      next()
    }
  }
}
</script>
<style lang="scss" scoped>
$scaleSize: 0.1;
$zoomOutStart: 0.7;
$zoomOutEnd: 0.46;
@keyframes zoomIn8 {
  from {
    opacity: 0;
    transform: scale3d($scaleSize, $scaleSize, $scaleSize);
  }
  100% {
    opacity: 1;
  }
}
.wrapper-full-page .zoomIn {
  animation-name: zoomIn8;
}
@keyframes zoomOut8 {
  from {
    opacity: 1;
    transform: scale3d($zoomOutStart, $zoomOutStart, $zoomOutStart);
  }
  to {
    opacity: 0;
    transform: scale3d($zoomOutEnd, $zoomOutEnd, $zoomOutEnd);
  }
}
.wrapper-full-page .zoomOut {
  animation-name: zoomOut8;
}
.md-button .md-ripple{
      padding: 12px 0px;
    }

</style>