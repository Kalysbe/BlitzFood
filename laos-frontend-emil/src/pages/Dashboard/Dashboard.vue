<template>
  <div>
    <div
        class="md-layout md-alignment-center-space-between tabs-items"
        style=""
        v-if="!isLoadingTabList"
    >
      <div class="md-layout-item " v-for="(tab, index) in tabs" :key="index">
        <div
            style="{#font-family: phetsarath_ot; #font-size: 1.3em; }"
            class="md-block tab-item md-simple"
            :class="{'tab-active': isActiveTab(tab.id)}"
            @click="switchPanel(tab.id)"
        >
          {{ $t('dashboard.road_contract_dashboard') }}
        </div>
      </div>
    </div>

    <transition name="fade1">
      <template v-if="!isLoadingTabData">
        <DashboardPanel></DashboardPanel>
      </template>
    </transition>
  </div>
</template>

<script>
import {DashboardPanel} from '@/components'

export default {
  components: {
    DashboardPanel,
  },
  data() {
    return {
      tabs: [],
      isLoadingTabList: true,
      isLoadingTabData: true,
      activeTab: 0,
    }
  },
  props: {domain: {type: String}},
  watch: {
    '$route'(to, from) {
      if (to.path !== from.path) {
        this.refreshDashboard()
      }
    }
  },
  async created() {
    let {tab = 0} = this.$route.query
    this.isLoadingTabList = true
    try {
      const tabs = await this.$store.dispatch('LOAD_DASHBOARD_TABS')
      tab = tabs[0].id
      this.tabs = [...tabs]
      await this.switchPanel(+tab)
    } catch (err) {
    } finally {
      this.isLoadingTabList = false
    }
  },

  methods: {
    async refreshDashboard() {
      const {tab} = this.$route.query
      this.isLoadingTabList = true
      try {
        const tabs = await this.$store.dispatch('LOAD_DASHBOARD_TABS', this.domain)
        this.tabs = [...tabs]
        if (tabs.length > 0) {
          await this.switchPanel(tab ? +tab : +tabs[0].id)
        }
      } catch (err) {
        throw err
      } finally {
        this.isLoadingTabList = false
      }
    },
    isActiveTab(id) {
      return this.activeTab === id
    },
    async switchPanel(ind) {

      this.$router.push({name: this.$route.name, query: {tab: ind}})
      this.activeTab = ind

      this.isLoadingTabData = true
      try {
        await this.$store.dispatch('LOAD_DASHBOARD_TAB_DATA', {domain: this.domain, tab_id: ind})
      } catch (err) {
        console.error(err)
      } finally {
        this.isLoadingTabData = false
      }
    }
  }
}
</script>

<style lang="scss">
@import '~@/assets/scss/md/_variables.scss';

.tab-item {
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  height: 60px;
  font-weight: 400;
}

.tab-active {
  color: $brand-success;
  border-bottom: 2px solid $brand-success;
  font-weight: 500;
}

.tabs-items {
  margin-bottom: 20px;
  border-bottom: 1px solid #ddd;
  cursor: pointer;
}

.fade-enter-active {
  transition: all 0.9s ease;
}

.fade-leave-active {
  transition: all 0.9s ease; // cubic-bezier(1, 0.5, 0.8, 1);
}

.fade-enter {
  //opacity: 0;
}

.fade-enter-from-left {
  transform: translateX(100%);
}

.fade-enter-from-right {
  transform: translateX(-100%);
}

.fade-leave-to {
  opacity: 0;
}
</style>
