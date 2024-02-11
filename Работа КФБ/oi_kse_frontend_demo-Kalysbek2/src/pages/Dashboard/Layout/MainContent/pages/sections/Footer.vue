<template>
<div class="section-footer">
      <div>
  <div class="footer-container">
        <div class="md-layout footer-content">
            <div class="footer-social">
              <ul class="">
                <li v-for="item in socialNetworks" :key="item.id">
                  <a :href="item.link" target="_blank">
                    <img class="social-icon" :src="item.icon" alt="">
                  </a>
                </li>
              </ul>
            </div>
        </div>
        <div class="md-layout bottom-footer">
          <div class="md-layout-item">
            &copy; {{$t('pageFooter.bottomFooterText')}}
          </div>
        </div>
  </div>
      </div>
</div>
</template>

<script>
export default {
data:() => ({
  socialNetworks:[
    {icon:'/socicons/facebook.svg',link:'https://ru-ru.facebook.com/KyrgyzStockExchange/'},
    {icon:'/socicons/telegram.svg',link:'https://telegram.me/+996551311484'},
    {icon:'/socicons/instagram.svg',link:'https://www.instagram.com/kse.kg/'},
    {icon:'/socicons/whatsapp.svg',link:'https://wa.me/+996551311484'}
  ]
})
}
</script>

<style lang="scss" scoped>
.section-footer {
  background: #49b9c4;
  min-height: 15vh;
  margin-top: 10vh;
  padding: 15px 0;
  color: rgb(222, 222, 228);
  width:100%;
  margin-left: auto;
  margin-right: auto;
}
.section-footer > div {
  padding: 0 50px;
}
.footer-container {
  max-width: 600px;
  margin-left:auto;
  margin-right: auto;
}
.footer-social {
width:200px;
margin-left:auto;
margin-right:auto;
}
.footer-social ul {
  display: flex;
}
.footer-social ul li {
  list-style:none;
  margin:0 10px;
}
.social-icon {
  width:100%;
  height:100%;
}

.bottom-footer {
  border-top:1px solid gray;
  padding: 15px 0;
  text-align: center;
}
.footer-menu {
  padding-left: 0px;
}
.footer-menu li:first-child {
  color:white;
}
.footer-menu li {
  list-style: none;
  margin:20px 0;
}
.footer-menu li a {
  color:#6D767E;
}
</style>