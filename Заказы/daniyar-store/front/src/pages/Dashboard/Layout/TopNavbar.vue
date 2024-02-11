<template>
  <md-toolbar
    md-elevation="0"
    class="md-transparent"
    :class="{
      'md-toolbar-absolute md-white md-fixed-top': $route.meta.navbarAbsolute
    }"
  >
    <div class="md-toolbar-row">
      <div class="md-toolbar-section-start"></div>
      <div class="md-toolbar-section-end">
        <md-button
          class="md-just-icon md-round md-simple md-toolbar-toggle"
          :class="{toggled: $sidebar.showSidebar}"
          @click="toggleSidebar"
        >
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </md-button>

        <div class="md-collapse">
          <md-list>
            <language-select/>
            <md-list-item @click="linkToHome">
              <i class="material-icons">home</i>
            </md-list-item>
            <md-list-item v-if="hasToken" @click="LOGOUT">
              <label>Выйти</label>
            </md-list-item>
          </md-list>
        </div>
      </div>
    </div>
  </md-toolbar>
</template>

<script>
import {mapActions,mapGetters} from 'vuex'

export default {
  computed: {
    ...mapGetters('auth', ['hasToken'])
  },
  data() {
    return {}
  },
  methods: {
    ...mapActions('auth', ['LOGOUT']),
    toggleSidebar() {
      this.$sidebar.displaySidebar(!this.$sidebar.showSidebar)
    },
    minimizeSidebar() {
      if (this.$sidebar) {
        this.$sidebar.toggleMinimize()
      }
    },
    linkToHome() {
      //this.$router.push('/' + this.$i18n.locale)
      this.$router.push('/' + this.$i18n.locale + '/dashboard/home')
    }
  }
}
</script>
<style lang="scss" scoped>
.md-toolbar{
  @media print {
        display: none;
    }

}
</style>
