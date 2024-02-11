<template>
  <div class="md-layout md-layout-item md-size-100">
    <div class="md-layout-item md-size-100" v-scrollanimation>
      <md-card>
        <carousel
          :per-page="1"
          loop
          :speed="2000"
          autoplay
          :autoplay-timeout="4000"
          :mouse-drag="false"
        >
          <slide v-for="image in slideImage" :key="image.id" class="carousel">
            <a
              :href="
                image.link
                  ? image.link
                  : image.dataslide.doc
                  ? 'http://localhost:8088/api/' + image.dataslide.doc.file
                  : ''
              "
              target="_blank"
            >
              <img
                class="carouselImage"
                :src="'http://localhost:8088/api/' + image.dataslide.image.file"
                alt=""
              />
            </a>
          </slide>
        </carousel>
      </md-card>
    </div>
    <div class="md-layout-item md-layout section-our-clients" v-scrollanimation>
      <div class="md-layout-item md-size-100">
        <h3 class="md-headline">{{ $t('pageHome.ourClientsTitle') }}</h3>
        <p class="md-subheading" style="text-align: center">
          {{ $t('pageHome.ourClientsText') }}
        </p>
        <p></p>
      </div>

      <div class="md-layout-item md-size-100 company-logos">
        <infinite-slide-bar duration="80s">
          <div class="company-logo-items">
            <div v-for="logo in logoOurCompanies" :key="logo.key">
              <img :src="'/companylogo/' + logo.logo" />
            </div>
          </div>
        </infinite-slide-bar>
      </div>
    </div>

    <div
      class="md-layout-item md-size-100 md-layout section-information-about-us"
      v-scrollanimation
    >
      <div
        class="md-layout-item md-size-50 md-xsmall-size-100 md-small-size-100"
      >
        <img src="/img/home-image-1.jpeg" alt="" />
      </div>
      <div
        class="md-layout-item md-size-50 md-xsmall-size-100 md-small-size-100"
      >
        <h1>{{ $t('pageHome.whoAreWeTitle') }}</h1>
        <p>{{ $t('pageHome.whoAreWeText') }}</p>
      </div>
      <div
        class="md-layout-item md-size-50 md-xsmall-size-100 md-small-size-100"
      >
        <h1>{{ $t('pageHome.whatWeDoTitle') }}</h1>
        <p>{{ $t('pageHome.whatWeDoText') }}</p>
      </div>
      <div
        class="md-layout-item md-size-50 md-xsmall-size-100 md-small-size-100"
      >
        <img src="/img/home-image-2.jpeg" alt="" />
      </div>
    </div>
  </div>
</template>

<script>
import {Carousel, Slide} from 'vue-carousel'
import InfiniteSlideBar from 'vue-infinite-slide-bar'
import {mapActions} from 'vuex'
export default {
  components: {
    InfiniteSlideBar,
    Carousel,
    Slide
  },
  data() {
    return {
      carouselImages: [],
      logoOurCompanies: [
        {logo: 'manas.webp'},
        {logo: 'kyrgyz-altyn.jpg'},
        {logo: 'bakaj-bank.png'},
        {logo: 'kyrgyzstan-bank.png'},
        {logo: 'kyrgyzkommerts.jpg'},
        {logo: 'sum.jpeg'},
        {logo: 'azattyk.jpeg'},
        {logo: 'garant-fond.jpg'}
      ],
      slideImage: []
    }
  },

  methods: {
    ...mapActions('company', ['GET_SLIDER_IMAGE'])
  },
  //   computed: {
  //     ...mapGetters('documents', ['setSliderImages'])
  // },
  async mounted() {
    // await this.$store.dispatch('GET_SLIDER_IMAGE')
    // .then(res => {
    //   //console.log(res)
    //   this.slideImage = res.data
    // })
    // await this.GET_SLIDER_IMAGE()
    //this.slideImage = this.res.data
    this.res = await this.GET_SLIDER_IMAGE()
    this.slideImage = this.res.data
  }
}
</script>

<style lang="scss" scoped>
.carousel {
  max-height: 460px;
}
.carouselImage {
  width: 100%;
  height: 100%;
}
.section-our-clients {
  margin: 5vh 0;
  width: 100%;
}
.section-our-clients > div {
  margin-bottom: 50px;
}
.section-our-clients h3 {
  margin-top: -20px;
  text-align: center;
}
.company-logos img {
  height: 120px;
  margin: 0 10px;
  padding: 0 15px;
}
.company-logo-items {
  display: flex;
  justify-content: space-around;
}
.section-information-about-us > div {
  margin-bottom: 50px;
}
.section-information-about-us p {
  font-size: 18px;
  font-weight: 400;
  line-height: 26px;
  letter-spacing: 1px;
}
.section-information-about-us img {
  min-height: 300px;
  max-height: 500px;
  max-width: 500px;
  width: 100%;
  height: 100%;
  border-radius: 10px;
}
.before-enter {
  opacity: 0;
  transform: translateY(100px);
  transition: all 2s ease-out;
}
.enter {
  opacity: 1;
  transform: translateY(0px);
}
@media screen and (max-width: 600px) {
  .main-content {
    height: 60vh;
  }
}
</style>