<template>
  <div>
    <template v-if="images.length > 0">
      <image-list :images="images" @preview="openPhotoPreview"></image-list>
    </template>
    <template v-else>
      <h5 class="text-center">{{ $t(`environment.no_images`) }}</h5>
    </template>
    <md-dialog
      :md-active.sync="isGalleryDialog"
      :md-click-outside-to-close="false"
    >
      <md-dialog-title>Upload images</md-dialog-title>
      <div class="md-layout md-size-50">
        <div class="md-layout">
          <div :class="`md-layout-item md-size-100`">
            <md-field>
              <label>Multiple</label>
              <md-file v-model="uploadImages" multiple />
            </md-field>
          </div>
          <!-- dialog actions start-->
          <div class="md-layout-item md-size-100 text-right">
            <md-button
              class="md-success"
              native-type="submit"
              @click.stop.prevent="uploadImage"
            >
              {{ $t('button.save') }}
            </md-button>
            <md-button
              class="md-accent"
              @click.stop.prevent="toggleGalleryDialog"
            >
              {{ $t('button.close') }}
            </md-button>
          </div>
        </div>
      </div>
    </md-dialog>
    <div
      id="fullpage"
      :style="{
        backgroundImage: previewBackgroundImage,
        display: previewDisplay
      }"
    >
      <div class="footer">
        <md-button
          class="md-fab md-round md-icon-button"
          @click="previewDisplay = 'none'"
        >
          <md-icon>close</md-icon>
        </md-button>
        <md-button
          class="md-fab md-round md-icon-button md-danger"
          @click="previewDisplay = 'none'"
        >
          <md-icon>delete_forever</md-icon>
        </md-button>
      </div>
    </div>
  </div>
</template>

<script>
import ImageList from '../../ImageList/index.vue'
import ImageGallery from '../../ImageGallery.vue'
export default {
  props: ['images', 'isGalleryDialog'],
  components: {
    ImageGallery,
    ImageList
  },
  data: () => ({
    uploadImages: null,
    previewBackgroundImage: '',
    previewDisplay: 'none'
  }),
  methods: {
    openPhotoPreview(image) {
      this.previewBackgroundImage = 'url(' + image + ')'
      this.previewDisplay = 'block'
    },
    toggleGalleryDialog() {
      this.$emit('toggleGalleryDialog')
    },

    uploadImage() {
      // test static image
      this.images.push({
        thumbnail: `/images/images/road1.jpg`,
        meta: `Temporary static image default road1.jpg`,
        previewUrl: `/images/images/road1.jpg`
      })
    },
    deleteImage() {
      console.log('delete image')
    }
  }
}
</script>

<style>
#fullpage {
  display: none;
  position: fixed;
  z-index: 9999;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-size: contain;
  background-repeat: no-repeat no-repeat;
  background-position: center center;
  background-color: black;
}
#fullpage .footer {
  position: fixed;
  left: 0;
  bottom: 10px;
  width: 100%;
  color: white;
  text-align: center;
}
</style>