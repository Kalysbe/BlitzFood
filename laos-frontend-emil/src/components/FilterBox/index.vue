<template>
  <div>
    <md-button
      class="md-just-icon md-simple"
      :class="{
        'md-primary': isLoadingFilterListData || isFilterActive
      }"
      @click="toggleFilter"
      :disabled="!hasItems"
    >
      <i
        :class="['fas', isLoadingFilterListData ? 'fa-spinner' : 'fa-filter']"
      ></i>
    </md-button>
    <div
      class="filter-items-box"
      v-if="isFilterShow && filterList.length > 0"
      v-click-outside="closeFilter"
    >
      <div class="md-layout md-alignment-center elements-zone">
        <div
          class="md-layout-item md-medium-size-20 md-small-size-50 md-xsmall-size-100 "
          v-for="item of filterList"
          :key="item.field"
        >
          <md-field>
            <label>
              {{ $t(item.name) }}
            </label>
            <md-select
              :name="item.field"
              :id="item.field"
              :disabled="
                onlyOneEnable && isFilterActive && !items_selected[item.field]
              "
              @md-selected="changeFilter"
              v-model="items_selected[item.field]"
            >
              <md-option v-for="opt of item.items" :key="opt" :value="opt">
                {{ $t(opt) }}
              </md-option>
            </md-select>
          </md-field>
        </div>
      </div>
      <div class="md-layout button-zone md-alignment-center-space-between">
        <div class="md-layout-item md-size-50">
          <div id="uncheck-all" @click="uncheckAll">
            <md-icon>clear</md-icon>
            <span>{{ $t('label.reset_filter') }}</span>
          </div>
        </div>
        <div class="md-layout-item md-size-50 active-buttons">
          <md-button class="md-sm" @click="closeFilter">
            {{ $t('button.close') }}
          </md-button>

          <md-button class="md-success md-sm" @click="setFilter">
            {{ $t('button.apply') }}
          </md-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'filter-component',
  data() {
    return {
      isFilterShow: false,
      items_selected: {},
      changed_component: ''
    }
  },
  props: {
    filterDefOptions: {type: Object},
    onlyOneEnable: {type: Boolean, default: false},
    filterList: {type: Array},
    isLoadingFilterListData: {type: Boolean}
  },
  async created() {
    this.refreshList()
  },
  watch: {
    filterList() {
      this.refreshList()
    }
  },
  methods: {
    refreshList() {
      this.items_selected = {}
      this.filterList.forEach((filter) => {
        const key = filter.field
        this.$set(this.items_selected, key, '')
      })
      Object.keys(this.filterDefOptions).forEach((opt) => {
        this.$set(this.items_selected, opt, this.filterDefOptions[opt])
      })
    },

    toggleFilter() {
      if (
        (!this.isFilterShow && this.isLoadingFilterListData) ||
        this.filterList.length === 0
      ) {
        return
      }
      this.isFilterShow = !this.isFilterShow
    },
    closeFilter() {
      this.isFilterShow = false
    },

    changeFilter(/*e*/) {},

    setFilter() {
      const selected = {}
      for (const item in this.items_selected) {
        if (this.items_selected[item] !== '') {
          selected[item] = this.items_selected[item]
        }
      }
      this.$emit('setFilter', selected)
      this.closeFilter()
    },

    uncheckAll() {
      Object.keys(this.items_selected).forEach((key) => {
        this.items_selected[key] = ''
      })
    }
  },
  computed: {
    isFilterActive() {
      const hasSelected = Object.keys(this.items_selected).reduce(
        (accum, curr) => {
          accum =
            accum ||
            (this.items_selected[curr] && this.items_selected[curr] !== '')
          return accum
        },
        false
      )
      return Boolean(hasSelected)
    },
    hasItems() {
      return this.filterList.length > 0
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/md/_variables.scss';

.actived {
}

.active-buttons .md-button .md-button-content i {
  font-size: 17px !important;
}

.filter-items-box {
  position: absolute;

  padding: 10px;
  margin-top: 10px;
  max-width: 600px;
  right: 10px;
  border-radius: 4px;
  box-shadow: 4px 11px 20px -5px rgba(119, 119, 119, 0.15),
    4px -11px 20px -5px rgba(119, 119, 119, 0.15),
    -4px 11px 20px -5px rgba(119, 119, 119, 0.15);

  background-color: #ffffff;
  z-index: 11;
  .button-zone {
    padding-top: 10px;
    // padding-left: 10px;
    // padding-right: 10px;
    .md-layout-item {
      display: flex;
      flex-direction: row;
      justify-content: flex-end;
      align-content: center;
      flex-wrap: wrap;
    }

    .md-button {
      margin: 5px;
    }
    #uncheck-all {
      color: $link-color;
      //font-size: 16px;
      display: flex;
      align-items: center;
      margin-right: auto;
      cursor: pointer;
      span {
        align-items: center;
      }
      i {
        color: inherit;
      }
      &:hover {
        color: $link-hover-color;
      }
    }
  }
  .elements-zone {
    padding-bottom: 10px;
    //border-bottom: 1px solid $grey-200;
    .md-layout-item {
      padding-top: 10px;
      padding-bottom: 5px;
    }
  }
}
</style>
