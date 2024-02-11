<template>
  <div class="main-fixed-navbar">
        <div class="fixed-navigation-menu">
      <md-toolbar id="toolbar" md-elevation="0" class="md-transparent md-absolute md-fixed-top main-head-navbar">
        <div class="md-toolbar-row">
        <div class="md-toolbar-section-start">
              <md-list class="bottom-header">
                <md-list-item>
                <router-link :to="'/' + $i18n.locale + '/'" class="nav-logo">
                  <img src="/img/logo.png" alt="" class="logo1"/>
                </router-link>
                  </md-list-item>
                <md-list-item class="md-small-hide" style="font-size: 8px" >
                  <md-icon class="material-icons kseIcon">place</md-icon>
                  {{$t('headerLocation')}}
                </md-list-item>
                <md-list-item class="md-small-hide" style="font-size: 8px">
                  <md-icon  class="material-icons kseIcon">phone</md-icon>
                 (0312) 31 15 01 
                </md-list-item>
                <md-list-item class="md-small-hide" style="font-size: 8px">
                  <md-icon  class="material-icons kseIcon">email</md-icon>
                 office@kse.kg
                </md-list-item>
              </md-list>
              
        </div>
          <div class="md-toolbar-section-end">
              <md-list>
                     <language-select style="z-index:6;"/>
              </md-list>
              <md-button
                class="md-just-icon md-simple md-toolbar-toggle"
                @click="showNavigation = true">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>  
                <span class="icon-bar"></span>
              </md-button>
          <div>
     
          </div>
          </div>
        </div>
        <!-- Navigation -->
       <div class="md-toolbar-row"> 
            <div class="md-toolbar-section-start">
              <md-list class="navigation-menu responsive-menu">
                <md-list-item v-for="item in $t('navbarItems')" :key="item.id">
                  <router-link :to="'/' + $i18n.locale + item.link">{{item.name}}</router-link>
                </md-list-item>
                
              </md-list>
            </div>
            <div class="md-toolbar-section-end">
                 <md-list>
                   <md-list-item class="responsive-menu">
                <button class="login-button" @click="linkToLogin()">
                  <template v-if="!Auth">{{$t('loginButton')}}</template>
                  <template v-else-if="Auth">Кабинет</template>
                </button>
              </md-list-item>
                 </md-list>
            </div>
          </div> 
       </md-toolbar>
         </div>
      <!-- Mobile menu -->
       <md-drawer
          class="md-right md-fixed"
          :md-active.sync="showNavigation"
          md-swipeable
          style="z-index:9990;"
        >
       
          <md-list class="navigation-menu">
            <hr>
              <md-list-item v-for="item in $t('navbarItems')" :key="item.id" @click="showNavigation = false">
                  <router-link :to="'/' + $i18n.locale + item.link" >{{item.name}}</router-link>
              </md-list-item>
               <md-list-item>
                 <button class="login-button" @click="linkToLogin()">
                  <template v-if="!Auth">{{$t('loginButton')}}</template>
                  <template v-else-if="Auth">Кабинет</template>
                </button>
              </md-list-item>
          </md-list>
        </md-drawer>
  </div>
</template>
 
<script>
import LanguageSelect from './languageSelect.vue'
import {mapActions} from 'vuex'

export default {
  name: 'ContentActions',
  components: {
    LanguageSelect,
  },

  data: () => ({
    showNavigation: false,
    showSidepanel: false,
    langs: ['ru','eng','kg',],
    Auth: localStorage.getItem('token'),
  }),
  methods: {
    ...mapActions('auth', ['LOGOUT']),
    linkToLogin() {
      this.$router.push('/' + this.$i18n.locale + '/auth/login')
    },
    toggleMenu() {
      this.showNavigation = !this.showNavigation
    }
  },
  computed: {
    route() {
      console.log(this.$router)
    }
  }
}
</script>

<style lang="scss" scoped>
.md-toolbar {
padding-top: 0px;
}
.md-content {
  max-width: 1200px;
  margin-left: auto;
  margin-right: auto;
}
.main-fixed-navbar {
  min-height: 122px;
}
.fixed-navigation-menu {
  position: fixed;
  background: white;
  width: 100%;
  z-index: 1030;
}
.main-head-navbar {
  // position: fixed;
  max-width: 1200px;
  margin-left: auto;
  margin-right: auto;

  left: 0;
  right: 0;
  padding-top: 0px;
}
.bottom-header {
  display: flex; 
  align-items: center;
  min-width:100%;
}
.nav-logo {
  min-width: 60px;
}
.login-button {
  background: white;
  color: #78c3cc;
  border: none;
  border: 0.5px solid #78c3cc;
  cursor: pointer;
  font-size: 16px;
  border-radius: 40px;
  padding: 5px 20px;
}
.login-button:hover {
  background: rgb(98, 181, 190, 0.1);
}
.navigation-menu li a:hover {
  border-bottom: 0.5px solid #49b9c4;
  transition: 0.2s;
  color: #49b9c4;
}
.navigation-menu li a {
  font-size: 18px;
}

.md-drawer {
  width: 230px;
  max-width: calc(100vw - 125px);
}
a {
  text-transform: capitalize;
}
.section-footer {
  background: #49b9c4;
  min-height: 15vh;
  margin-top: 10vh;
  padding: 15px 0;
  color: rgb(222, 222, 228);
  width:100%;
  margin-left: auto;
  margin-right: auto;
}
.section-footer > div {
  padding: 0 50px;
}
.kseIcon {
  margin-right: 5px;
}
.page-enter-active,
.page-leave-active {
  transition: all 0.3s ease;
  opacity: 0;
}

@media screen and (max-width: 960px) {
  .responsive-menu {
    display: none;
  }
  .main-fixed-navbar {
    min-height: 60px;
  }
}
</style>
