<template>
  <body id="page-top">
     <div class="body">
       <navbar></navbar>
        <md-content>
         <div class="block-router-view">
           <transition name="page" appear>
             <router-view />
           </transition>
         </div>
       </md-content>
       <Footer></Footer>
   </div>
   </body>
 </template>

 <script>
 import Footer from './MainContent/pages/sections/Footer.vue'
 import Navbar from './MainContent/pages/sections/Navbar.vue'

 export default {
   name: 'ContentActions',
   components: {
     Footer,
     Navbar
   },
 }
 </script>
