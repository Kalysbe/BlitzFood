<template>
  <ul class="nav nav-mobile-menu">
    <li v-if="isLoggedIn" @click="LOGOUT">
      <router-link to="#">
        <i class="material-icons">logout</i>
        <p>Выйти</p>
      </router-link>
    </li>
    <li>
      <router-link :to="'/' + $i18n.locale + '/' + `Home`">
        <i class="material-icons">home</i>
        <p>Главная</p>
      </router-link>
    </li>
  </ul>
</template>
<script>
import {mapState, mapActions} from 'vuex'
export default {
  computed: {
    ...mapState('auth', {isLoggedIn: (state) => state.token !== ''})
  },

  data() {
    return {}
  },
  methods: {
    ...mapActions('auth', ['LOGOUT'])
  }
}
</script>
