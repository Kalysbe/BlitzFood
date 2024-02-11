<template>
  <md-card>
    <md-card-header>
      <slot name="title"></slot>
    </md-card-header>
    <md-card-media>
      <md-ripple>
        <div class="image-card-state">
          <slot name="imageState"></slot>
        </div>
      </md-ripple>
    </md-card-media>
    <md-card-actions>
      <slot name="first-button"></slot>
      <slot name="second-button"></slot>
      <slot name="third-button"></slot>
    </md-card-actions>
  </md-card>
</template>

<script>
export default {
  name: "image-card",
  methods: {
    selectCustomFiles() {
      console.log("select")
    }
  }
}

</script>

<style lang="scss">

.image-card-state {
  height: 300px;

  img {
    height: 100%;
    width: 100%;
    object-fit: contain
  }
}
</style>
