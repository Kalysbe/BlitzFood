<template>
  <div
    class="wrapper"
    :class="[{'nav-open': $sidebar.showSidebar}, {rtl: $route.meta.rtlActive}]"
  >
    <notifications></notifications>
    <side-bar
      class="side-bar-content"
      :active-color="sidebarBackground"
      :background-image="sidebarBackgroundImage"
      :data-background-color="sidebarBackgroundColor"
      @onSidebarBlur="onSidebarBlur"
      :logo="appOptions.logo"
      :title="appOptions.sidebar_text"
      :logo_link="appOptions.logo_link"
    >
      <user-menu
        :title="userFullName"
        :avatar="srcUserAvatar"
        ref="refUserMenu"
      >
        <!--li>
          <a href="#rms">
            <span class="sidebar-mini">S</span>
            <span class="sidebar-normal">Settings</span>
          </a>
        </li-->

        <li>
          <a data-toggle="collapse" @click.stop="">
            <span class="sidebar-mini">
              <md-icon class="user-menu-icon">language</md-icon>
            </span>

            <span class="sidebar-normal">
              <div @click="toggleLangList">
                {{ $t('menu.languages') }}
                <b class="lang-caret caret"></b>
              </div>
            </span>
            <md-list v-if="isShowLangMenu">
              <md-list-item
                v-for="locale in locales"
                :key="locale.code"
                @click="onSelectLang(locale.code)"
              >
                <!-- @click="onSelectLang(locale.code)" -->
                <span class="lang-name">
                  <i
                    class="fa fa-angle-right"
                    :style="{opacity: locale.code === localeActive ? 1 : 0}"
                  ></i>
                  <!--{{lang_translate(locale.code )}}-->
                  {{ locale.name }}
                  <!-- {{ locale.code=='en'?locale.name:locale.name_la }} -->
                </span>
              </md-list-item>
            </md-list>
          </a>
        </li>
        <li>
          <router-link to="/logout">
            <span class="sidebar-mini">
              <md-icon class="user-menu-icon">lock</md-icon>
            </span>
            <span class="sidebar-normal">{{ $t('menu.logout') }}</span>
          </router-link>
        </li>
      </user-menu>
      <mobile-menu></mobile-menu>

      <template slot="links">
        <sidebar-item
          v-for="item of menuItems"
          :key="item.name"
          :link="{name: $t(item.name), icon: item.icon, path: item.path}"
        >
          <template
            v-if="
              item.hasOwnProperty('children') && Array.isArray(item.children)
            "
          >
            <sidebar-item
              v-for="(subLink, index) in item.children"
              :key="index"
              :link="{
                name: $t(subLink.name),
                icon: subLink.icon,
                path: subLink.path
              }"
            ></sidebar-item>
          </template>
        </sidebar-item>
      </template>
    </side-bar>
    <div class="main-panel">
      <top-navbar></top-navbar>

      <!--fixed-plugin
        :color.sync="sidebarBackground"
        :colorBg.sync="sidebarBackgroundColor"
        :sidebarMini.sync="sidebarMini"
        :sidebarImg.sync="sidebarImg"
        :image.sync="sidebarBackgroundImage"
      ></fixed-plugin-->

      <div :class="{content: !$route.meta.hideContent}" @click="toggleSidebar">
        <zoom-center-transition :duration="100" mode="out-in">
          <!-- your content here -->
          <router-view></router-view>
        </zoom-center-transition>
      </div>
      <content-footer v-if="!$route.meta.hideFooter"></content-footer>
    </div>
  </div>
</template>
<script>
/* eslint-disable no-new */
import PerfectScrollbar from 'perfect-scrollbar'
import 'perfect-scrollbar/css/perfect-scrollbar.css'
import {mapGetters, mapState} from 'vuex'
// import { mdiFileSign } from '@mdi/js';
import TopNavbar from './TopNavbar.vue'
import ContentFooter from './ContentFooter.vue'
import MobileMenu from './Extra/MobileMenu.vue'
//import FixedPlugin from '../../FixedPlugin.vue'
import UserMenu from './Extra/UserMenu.vue'
import {ZoomCenterTransition} from 'vue2-transitions'

function hasElement(className) {
  return document.getElementsByClassName(className).length > 0
}

function initScrollbar(className) {
  if (hasElement(className)) {
    new PerfectScrollbar(`.${className}`)
  } else {
    // try to init it later in case this component is loaded async
    setTimeout(() => {
      initScrollbar(className)
    }, 100)
  }
}

export default {
  components: {
    TopNavbar,
    ContentFooter,
    MobileMenu,
    //FixedPlugin,
    UserMenu,
    ZoomCenterTransition
  },
  data() {
    return {
      sidebarBackgroundColor: 'black',
      sidebarBackground: 'green',
      sidebarBackgroundImage: '/img/sidebar-2.jpg',
      sidebarMini: true,
      sidebarImg: true,
      isShowLangMenu: false,
      /*menuItems: [
        {name: 'menu.dashboard', icon: 'dashboard', path: '/dashboard'},
        {
          name: 'menu.contracts', icon: 'assignment',
          children: [
            {name: 'menu.contracts_list', icon: 'chat', path: '/contracts/list'},
            {name: "menu.contracts_reports", icon: 'article', path: '/contracts/reports'},
          ]
        },
        {name: 'menu.map', icon: 'map', path: '/web-gis'},
        {
          name: 'menu.reports', icon: 'plagiarism',
          children: [
            {name: "menu.report_road", icon: 'analytics', path: '/reports/'}
          ]
        },
        {name: 'menu.translate', icon: 'translate', path: '/localisation'}
      ],*/
      selectedLang: null,
      current_lang: null,
      lang_messages: {}
      // locales_list: [
      //   {
      //     index: 0,
      //     code: "en",
      //     name: "English",
      //     name_la: "ອັງ​ກິດ",
      //   },
      //   {
      //     index: 1,
      //     code: "la",
      //     name: "Lao",
      //     name_la: "ລາວ",
      //   }
      // ],
    }
  },
  created() {
    document.title = this.appOptions.title_text
  },
  computed: {
    ...mapState({
      me: (state) => state.Login.me,
      locales: (state) =>
        state.i18nStore.locales.sort((a, b) => a.index - b.index),
      localeActive: (state) => state.i18nStore.active,
      appOptions: (state) => state.Login.appOptions
    }),
    // menuItems() {
    //   return this.me.menu_items
    // },
    ...mapGetters({
      isLangMessagesExist: 'isLangMessagesExist'
    }),
    menuItems() {
      return this.me.menu_items
    },
    localeActiveName() {
      const localeAct = this.locales.find(
        (locale) => locale.code === this.localeActive
      )
      return localeAct.name
    },
    userFullName() {
      const {last_name = 'LastName', first_name = 'FirstName'} = this.me
      return `${last_name} ${first_name}`
    },
    srcUserAvatar() {
      const {avatar} = this.me
      return avatar ? avatar : '/img/default-avatar.png'
    },

    linkLogoutPrefix() {
      return this.$t('map.logout').substring(0, 1)
    }
  },
  methods: {
    lang_translate(code) {
      if (code == 'en') {
        return 'English'
      } else {
        return 'ລາວ'
      }
      // return this.$i18n.locale == 'en' ? this.locales_list[0].name: this.locales_list[1].name
    },
    translateLink(link) {
      return this.$t(link)
    },

    // onLangChanged(langcode){
    //   console.log("langcode:", langcode)
    //   localStorage.setItem("lang", langcode)
    //   window.location.reload
    //
    //   this.$i18n.locale = localStorage.getItem("lang")
    //   console.log("this.$i18n.locale-sirway:", this.$i18n.locale)
    // },
    onSidebarBlur() {
      this.displayLangList(false)
      this.$refs.refUserMenu.closeMenu()
    },
    displayLangList(val) {
      this.isShowLangMenu = val
    },
    async onSelectLang(langcode) {
      if (!this.isLangMessagesExist(langcode)) {
        await this.$store.dispatch('LOAD_UI_TRANSLATE', langcode)
      }
      this.$store.commit('CHANGE_LANG', langcode)

      // console.log("langcode:", langcode)
      // localStorage.setItem("lang", langcode)
      // window.location.reload
      //
      // this.$i18n.locale = localStorage.getItem("lang")
      // console.log("this.$i18n.locale-sirway:", this.$i18n.locale)
    },
    toggleLangList() {
      this.isShowLangMenu = !this.isShowLangMenu
    },
    toggleSidebar() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.displaySidebar(false)
      }
    },
    minimizeSidebar() {
      if (this.$sidebar) {
        this.$sidebar.toggleMinimize()
        this.displayLangList(false)
      }
    }
  },
  async mounted() {
    let docClasses = document.body.classList
    let isWindows = navigator.platform.startsWith('Win')
    if (isWindows) {
      // if we are on Windows OS we activate the perfectScrollbar function
      initScrollbar('sidebar')
      initScrollbar('sidebar-wrapper')
      initScrollbar('main-panel')
      if (this.$route.meta.hideScroll) {
        docClasses.add('perfect-scrollbar-off')
      } else {
        docClasses.add('perfect-scrollbar-on')
      }
    } else {
      docClasses.add('perfect-scrollbar-off')
    }
  },
  watch: {
    sidebarMini() {
      this.minimizeSidebar()
    }
  }
}
</script>
<style lang="scss" scoped>
.no-scroll {
  overflow: hidden;
}

//.sidebar .user .user-info .caret {
//  font-family: phetsarath_ot;
//  top: unset;
//}

.side-bar-content {
  font-family: phetsarath_ot;
}

.user-menu-icon {
  height: unset !important;
}

.lang-name-active {
  font-weight: 500;
}

.lang-caret {
  top: unset !important;
}

.lang-name {
  color: #ffffff;
  font-weight: 300;
  font-size: 0.8rem;

  i {
    font-size: 14px !important;
    float: none !important;
  }
}

$scaleSize: 0.95;
@keyframes zoomIn95 {
  from {
    opacity: 0;
    transform: scale3d($scaleSize, $scaleSize, $scaleSize);
  }
  to {
    opacity: 1;
  }
}

.main-panel .zoomIn {
  animation-name: zoomIn95;
}

@keyframes zoomOut95 {
  from {
    opacity: 1;
  }
  to {
    opacity: 0;
    transform: scale3d($scaleSize, $scaleSize, $scaleSize);
  }
}

.main-panel .zoomOut {
  animation-name: zoomOut95;
}
</style>
