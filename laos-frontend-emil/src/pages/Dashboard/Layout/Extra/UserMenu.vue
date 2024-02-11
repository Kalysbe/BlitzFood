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
          {{ title }}
          <b class="caret"></b>
        </span>
      </a>

      <collapse-transition>
        <div v-show="!isClosed">
          <ul class="nav">
            <slot></slot>
          </ul>
        </div>
      </collapse-transition>
    </div>
  </div>
</template>
<script>
import {CollapseTransition} from 'vue2-transitions'

export default {
  components: {
    CollapseTransition
  },
  props: {
    title: {
      type: String,
      default: 'Noname'
    },
    rtlTitle: {
      type: String,
      default: 'تانيا أندرو'
    },
    avatar: {
      type: String,
      default: '/img/default-avatar.png'
    }
  },
  data() {
    return {
      isClosed: true
    }
  },
  methods: {
    clicked: function(e) {
      e.preventDefault()
    },
    closeMenu() {
      this.isClosed = true
    },
    toggleMenu: function() {
      this.isClosed = !this.isClosed
    }
  }
}
</script>
<style>
.collapsed {
  transition: opacity 1s;
}
</style>
