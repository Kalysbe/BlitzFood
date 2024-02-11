<template>

  <div class="md-layout">
    <div class="md-layout-item md-size-100 md-medium-size-100">
      <tabs class="env-nav-tabs"
            :tab-name="[$t('button.environmental'), $t('button.impact_evaluation'), $t('button.accident'), $t('button.social_monitoring'), $t('button.grievance_monitoring')]"

            color-button="success"
      >
        <!-- here you can add your content for tab-content -->
        <template slot="tab-pane-1">

        </template>
        <template slot="tab-pane-2">

        </template>
        <template slot="tab-pane-3">

        </template>
      </tabs>
    </div>
  </div>
</template>

<script>
import {Tabs} from "@/components";

export default {
  name: "ContractEnvironment",
  props: ["contractId"],
  components: {
    Tabs
  },
  data() {
    return {
      details: {},
      isDataLoading: false
    }
  },
}
</script>

<style lang="scss" scoped>
</style>