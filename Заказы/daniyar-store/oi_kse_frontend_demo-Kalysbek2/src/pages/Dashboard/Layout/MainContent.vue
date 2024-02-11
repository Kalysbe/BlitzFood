<template>
  <div class="main-content">
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

<style lang="scss" scoped>
.main-content {
  position: relative;
  background: white;
  overflow: hidden;

}
.md-content {
  max-width: 1130px;
  margin-left: auto;
  margin-right: auto;
    min-height: calc(100vh - 365px)
}
a {
  text-transform: capitalize;
}
.page-enter-active,
.page-leave-active {
  transition: all 0.3s ease;
  opacity: 0;
}
.block-router-view  .md-layout-item {
  padding: 0 0px;
}
</style>