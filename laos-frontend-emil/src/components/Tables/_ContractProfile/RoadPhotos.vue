<template>
  <section class="regular slider">
    <div>
      <img src="@/assets/images/road1.jpg"/>
    </div>
    <div>
      <img src="@/assets/images/road2.jpg"/>
    </div>
    <div>
      <img src="@/assets/images/road3.jpg"/>
    </div>
    <div>
      <img src="@/assets/images/road4.jpg"/>
    </div>
    <div>
      <img src="@/assets/images/road5.jpg"/>
    </div>
    <div>
      <img src="@/assets/images/road6.jpg"/>
    </div>
    <div>
      <img src="@/assets/images/road7.jpg"/>
    </div>
  </section>
</template>

<style type="text/css">
  section {
    margin: 0;
    padding: 0;
    width: 600px !important;
  }

  * {
    box-sizing: border-box;
  }

  .slider {
      width: 50%;
      margin: 100px auto;
  }

  .slick-slide {
    margin: 0px 2px;
  }

  .slick-slide img {
    width: 100%;
  }

  .slick-prev:before,
  .slick-next:before {
    color: black;
  }

  .slick-slide {
    transition: all ease-in-out .3s;
  }

  .iram-row {
    font-weight: 400 !important;
  }

</style>

<script>
import $ from 'jquery'

import '@/assets/css/slick.css';
import '@/assets/css/slick-theme.css'
import '@/assets/js/slick.js'

export default {
  name: "road-photos",
  mounted() {
    $(".regular").slick({
        dots: true,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3
    });
  }
};

</script>