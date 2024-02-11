<template>
  <div class="md-layout md-layout-item md-size-100">
    
   
      <clothes-list></clothes-list>

  </div>
</template>

<script>
import {Carousel, Slide} from 'vue-carousel'
import InfiniteSlideBar from 'vue-infinite-slide-bar'
import {mapActions} from 'vuex'

import ClothesList from '../../../Components/ClothesList.vue'

export default {
  components: {
    InfiniteSlideBar,
    Carousel,
    Slide,
    ClothesList
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