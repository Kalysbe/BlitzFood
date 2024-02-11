<template>
  <div class="user">
    <div class="photo">
      <img :src="avatar" alt="avatar" />
    </div>
    <div class="user-info">
      <a
        data-toggle="collapse"
        :aria-expanded="!isClosed"
        @click.stop="toggleMenu"
        @click.capture="clicked"
      >
        <span v-if="$route.meta.rtlActive">
          {{ rtlTitle }}
          <b class="caret"></b>
        </span>
        <span v-else>
          {{ user }} 

          <b class="caret"></b>
        </span>
      </a>

      <collapse-transition>
        <div v-show="!isClosed">
          <ul class="nav">
            <slot>
              <li>
                <router-link :to="'/' + $i18n.locale + `/dashboard/profile`">
                  <span class="sidebar-mini">МП</span>
                  <span class="sidebar-normal">Мой профиль</span>
                </router-link>
              </li>
              <li>
                <router-link :to="'/' + $i18n.locale + '/' + `dashboard/changePass`">
                  <span class="sidebar-mini">Н</span>
                  <span class="sidebar-normal">Настройки</span>
                </router-link>
              </li>
              <!-- <li>
                <router-link v-if="$route.meta.rtlActive" to="/pages/changePass"> 
                  <span class="sidebar-mini">و</span>
                  <span class="sidebar-normal">إعدادات</span>
                </router-link>
                <router-link v-else to="/pages/changePass">  
                  <span class="sidebar-mini" >ДК</span>
                  <span class="sidebar-normal">Добавить компанию</span>
                </router-link>
              </li> -->
            </slot>
          </ul>
        </div>
      </collapse-transition>
    </div>
  </div>
</template>
<script>
import {CollapseTransition} from 'vue2-transitions'
import {mapActions, mapState} from 'vuex'
export default {
  async created() {
    let res = await this.GET_ME()
    this.user = res.data.login
  },
  components: {
    CollapseTransition
  },
  props: {
    title: {
      type: String,
      default: 'User'
    },
    rtlTitle: {
      type: String,
      default: 'تانيا أندرو'
    },
    avatar: {
      type: String,
      default: '/img/default-user-img.png'
    }
  },
  data() {
    return {
      isClosed: true,
      user: ''
    }
  },
  methods: {
    ...mapActions('auth', ['GET_ME']),
    clicked: function (e) {
      e.preventDefault()
    },
    toggleMenu: function () {
      this.isClosed = !this.isClosed
    }
  }
}
</script>
<style>
.collapsed {
  transition: opacity 1s;
}
.material-icons {
  text-align: center;
}
</style>
