<template>
  <div class="md-layout">
    <div class="md-layout-item md-size-100">
      <md-card class="md-card-plain">
        <md-card-header class="md-card-header-icon md-card-header-blue">
          <div class="card-icon">
            <md-icon>gavel</md-icon>
          </div>
          <h4 class="title mt-0">{{$t('pageLegislation.title')}}</h4>
          <p class="category"></p>
        </md-card-header>
        <md-card-content>
          <md-table >
            <md-table-row v-for="item in $t('pageLegislation.files')" :key="item.id">
              <md-table-cell md-label="">
                <a :href="item.link" target="_blank">{{ item.name }}</a>
              </md-table-cell>
            </md-table-row>
          </md-table>
        </md-card-content>
      </md-card>
    </div>
  </div>
</template>

<script>
import {} from '@/components'

export default {
  components: {},
  props: {},
  methods: {},
  mounted() {}
}
</script>

<style lang="css"></style>
