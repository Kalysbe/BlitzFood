<template>
  <div class="md-layout md-layout-item md-large-size-100">
      <div class="md-layout-item md-size-50 md-small-size-100">
          <md-list class="md-double-line">
           <md-subheader> <h3>{{$t('pageContacts.ourContactTitle')}}</h3> </md-subheader>
           <md-list-item  v-for="item in $t('pageContacts.ourContact')" :key="item.id" style="word-break: break-all;">
            <md-icon  class="md-primary md-size-2x">{{item.icon}}</md-icon>
            <div class="md-list-item-text">
            {{item.value}}
            </div>
           </md-list-item>
        </md-list>
      </div>

      <div  class="md-layout-item md-size-50 md-small-size-100" style="min-height:350px;">
        <md-card id="mymap" style="width:100%; height:100%">

        </md-card>
      </div>
    </div>
</template>

<script> 
import DG from '2gis-maps';
export default {
    mounted () {
          DG.then(function () {
        let map = DG.map('mymap', {
            center: [42.870092, 74.585252],
            zoom: 17
        });
         DG.marker([42.870092, 74.585252]).addTo(map);
    });
}
}
</script>

<style scoped lang="scss">
.google-map {
  min-height: 400px;
  height: 100%;
}
</style>