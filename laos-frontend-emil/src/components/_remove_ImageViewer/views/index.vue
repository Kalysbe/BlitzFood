<template>
  <div>
    <h1 class="title">
      Demo
    </h1>
    <hr>
    <div style="margin-bottom: 3em">
      <h2 class="title is-4">
        Directive
      </h2>
      <p class="subtitle">
        <a href="https://github.com/mirari/v-viewer/blob/master/example/views/example/DirectiveExample.vue" target="_blank">Source</a>
      </p>
      <directive-image />
    </div>
    <div style="margin-bottom: 6em">
      <h2 class="title is-4">
        Component
      </h2>
      <p class="subtitle">
        <a href="https://github.com/mirari/v-viewer/blob/master/example/views/example/ComponentExample.vue" target="_blank">Source</a>
      </p>
      <component-image />
    </div>
    <div>
      <h2 class="title is-4">
        Api
      </h2>
      <p class="subtitle">
        <a href="https://github.com/mirari/v-viewer/blob/master/example/views/example/ApiExample.vue" target="_blank">Source</a>
      </p>
      <api-example />
    </div>
  </div>
</template>

<script>
import DirectiveImage from './DirectiveImage.vue'
import ComponentImage from './ComponentImage.vue'
import ApiImage from './ApiImage.vue'

export default {
  components: {
    ComponentImage,
    DirectiveImage,
    ApiImage,
  },

  data() {
    return {
    }
  },

  computed: {

  },

  mounted() {

  },
}
</script>

<style lang="scss" rel="stylesheet/scss" scoped>
</style>
