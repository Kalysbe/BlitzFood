<template>
  <div style="height: 98px;text-align:right;" v-viewer="options" class="images clearfix">
    <md-button class="md-raised md-blue" id="btn-photos" @click="handleEdit()">Add/Remove Photos</md-button>
    <section class="regular slider" id="sec-photos-road">
      <img v-for="{source, thumbnail} in images"
        :key="source"
        :src="thumbnail"
        :data-source="source"
        class="image"
        :alt="source.split('?image=').pop()"
      >
    </section>
    <NewRoadPhoto :showForm="showform" :urls="urls"></NewRoadPhoto>
    </div>
  </template>
  
  <style type="text/css">
    #btn-photos {
      margin-top:-76px;
      margin-right:0px;
    }
    #sec-photos-road {
      height: 114px;
      width: 600px;
    }

    * {
      box-sizing: border-box;
    }
  
    .slider {
      width: 50%;
      margin: -30px auto;
    }
  
    .slick-slide {
      margin-bottom: -18px;
      margin-right: 2px;
      margin-left: 2px;
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

    img {
      pointer-events: all;
      cursor: pointer;
    }
  </style>
  
  <script>
  import $ from 'jquery'
  
  import '@/assets/css/slick.css';
  import '@/assets/css/slick-theme.css'
  import '@/assets/js/slick.js'

  import 'viewerjs/dist/viewer.css'
  import { directive } from '@/components/_remove_ImageViewer'

  import { mapActions } from 'vuex';
  import NewRoadPhoto from './NewRoadPhoto'

  $('body').on('click', '.slick-slide', function (e) {
    let slideClicked = $(e.currentTarget).attr("data-slick-index"); 
  });

  const listImages = [{name:"Road1", source:"/images/road1.jpg", thumbnail:"/images/road1.jpg"},
                {name:"Road2", source:"/images/road2.jpg", thumbnail:"/images/road2.jpg"},
                {name:"Road3", source:"/images/road3.jpg", thumbnail:"/images/road3.jpg"},
                {name:"Road4", source:"/images/road4.jpg", thumbnail:"/images/road4.jpg"},
                {name:"Road5", source:"/images/road5.jpg", thumbnail:"/images/road5.jpg"},
                {name:"Road6", source:"/images/road6.jpg", thumbnail:"/images/road6.jpg"},
                {name:"Road7", source:"/images/road7.jpg", thumbnail:"/images/road7.jpg"},
        ];
  //imageUrls: ["/images/road1.jpg", "/images/road2.jpg", "/images/road3.jpg", "/images/road4.jpg",
  //            "/images/road5.jpg", "/images/road6.jpg", "/images/road7.jpg"],
    var imageUrls = [];

    listImages.forEach(
          (item) => imageUrls.push(item.source),
          );

  export default {
    name: "contract-lot-road-photos",
    components: { NewRoadPhoto },
    directives: {
      viewer: directive({
        debug: true,
      }),
    },
    data() {
      return {
        options: {
          toolbar: true,
          url: 'data-source',
        },
        images: listImages,
        urls: imageUrls,
        showform: false,
      };
    },
    methods: {
      ...mapActions('Contract',[
      'showRoadPhotoForm'
    ]),
      handleEdit(){
      this.showRoadPhotoForm(true)
      this.showform = true;
    },
    },
    mounted() {
      $(".regular").slick({
          dots: true,
          infinite: true,
          slidesToShow: 3,
          slidesToScroll: 3,
      });
    }
  };
</script> 