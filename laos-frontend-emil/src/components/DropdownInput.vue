<template>
  <div
    :class="[
      {open: isOpen},
      {dropdown: direction === 'down'},
      {dropup: direction === 'up'}
    ]"
    @click="toggleDropDown"
    v-click-outside="closeDropDown"
  >
    <md-field>
      <slot name="input"></slot>
    </md-field>
    <div class="drop-down-area" v-if="isOpen">
      <slot class="drop-down-pos"></slot>
    </div>
  </div>
</template>
<script>
export default {
  name: 'drop-down-input',
  props: {
    direction: {
      type: String,
      default: 'down'
    },
    multiLevel: {
      type: Boolean,
      default: false
    },
    title: String
  },
  data() {
    return {
      isOpen: false
    }
  },
  methods: {
    toggleDropDown() {
      if (!this.isOpen) {
        this.isOpen = true
      }
    },
    closeDropDown() {
      this.isOpen = false
    }
  }
}
</script>

<style lang="scss"></style>
