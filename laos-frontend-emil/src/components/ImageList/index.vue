<template>
  <div>
    <ul class="mdc-image-list my-image-list">
      <li v-for="image in images" class="mdc-image-list__item">
        <div class="mdc-image-list__image-aspect-container" @click="onShowPreview(image)">
          <img class="mdc-image-list__image" :src="image.thumbnail">
        </div>
        <div class="mdc-image-list__supporting" :title="image.meta">
          <span class="mdc-image-list__label">{{ image.meta }}</span>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "index.vue",
  props: {
    images: {type: Array}
  },
  data() {
    return {}
  },
  methods: {
    onShowPreview(image) {
      this.$emit("preview", image.previewUrl)
    }
  }
}
</script>

<style lang="scss" scoped>

@use "sass:math";

$standard-gutter-size: 4px !default;
$masonry-gutter-size: 16px !default;
$icon-size: 24px !default;
$text-protection-background-color: rgba(0, 0, 0, 0.6) !default;
$text-protection-height: 48px !default;
$text-protection-horizontal-padding: 16px !default;
$shape-radius: 4px !default;
$column-count: 5;
$gutter-size: $standard-gutter-size;
$width-height-ratio: 1.4;

.mdc-image-list {
  display: flex;
  flex-wrap: wrap;
  margin: 0 auto;
  padding: 0;
}

.mdc-image-list__item,
.mdc-image-list__image-aspect-container {
  position: relative;
  box-sizing: border-box;
}

.mdc-image-list__item {
  list-style-type: none;
  padding: 4px;
}

.mdc-image-list__image {
  width: 100%;
}

.mdc-image-list__image-aspect-container .mdc-image-list__image {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  height: 100%;
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
}

.mdc-image-list__supporting {
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-sizing: border-box;
  padding: 8px 0;
  line-height: $icon-size;
}

.mdc-image-list__label {
  text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
}

.mdc-image-list__image {
  border-radius: $shape-radius;
}

.mdc-image-list--with-text-protection .mdc-image-list__supporting {
  position: absolute;
  bottom: 0;
  width: 100%;
  height: $text-protection-height;
  padding: 0 $text-protection-horizontal-padding;
  background: $text-protection-background-color;
  color: #fff;
}

@mixin standard-columns(
  $column-count,
  $gutter-size: $standard-gutter-size,
) {
  .mdc-image-list__item {
    // Subtract extra fraction from each item's width to ensure correct wrapping in IE/Edge which round differently
    width: calc(
        100% / #{$column-count} - #{$gutter-size + math.div(1, $column-count)}
    );
    margin: math.div($gutter-size, 2);
  }
}


.mdc-image-list__image-aspect-container {
  padding-bottom: calc(100% / #{$width-height-ratio});
  cursor: pointer;
}

.my-image-list {
  @include standard-columns(5);
  //max-width: 960px;
}

@media (max-width: 1279px) {
  .my-image-list {
    @include standard-columns(3);
  }
}

@media (max-width: 599px) {
  .my-image-list {
    @include standard-columns(1);
  }
}

</style>

