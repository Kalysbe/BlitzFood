<template>
  <md-card style="">
    <transition name="fade">
      <div v-if="isDataLoading" class="load-progress">
        <md-progress-bar
            md-mode="indeterminate"
            class="progress-bar"
        ></md-progress-bar>
      </div>
    </transition>
    <md-card-header
        class="md-card-header-icon card-icon"
        :class="getClass(headerColor)"
    >
      <div class="card-icon">
        <md-icon>{{ 'view_list' }}</md-icon>
      </div>
      <h4 class="title">{{ $t(subTableTitle) }}</h4>
      <div class="icon-zone">
        <div class="active" @click="onDataRowAdd">
          <i class="fas fa-calendar-plus"></i>
        </div>
        <div @click="onExport">
          <i class="fas fa-file-export"></i>
        </div>

      </div>

    </md-card-header>

    <md-card-content class="sub-table-content">
      <md-table v-model="tableData" class="table-full-width" >
        <md-table-row
            slot="md-table-row"
            slot-scope="{ item }"
        >
          <md-table-cell v-for="header in tableDataHeaders" :key="header"
                         :md-label="$t(`daily_inspection.${header}`)"
                         :md-numeric="!isNaN(item[header])"
                         :md-tooltip="$t(`daily_inspection.${header}`)"
          >
            {{ item[header] }}
          </md-table-cell>
          <md-table-cell
              :md-label="$t('tables.actions')"
              v-if="hasAccess(feature, 'update')"
              md-numeric
          >
            <div class='cell-actions'>
              <drop-down direction="down">
                <md-button
                    slot="title"
                    class='md-button md-just-icon md-simple'
                    data-toggle="dropdown"
                >
                  <md-icon>more_vert</md-icon>
                </md-button>
                <ul
                    class="dropdown-menu"
                    :class="{ 'dropdown-menu-right': !responsive }"
                >
                  <li><a href="" @click.prevent='onDataRowEdit'>{{ $t("button.edit") }}</a></li>
                  <li><a href="" @click.prevent='onDataRowDelete'>{{ $t("button.delete") }}</a></li>
                </ul>
              </drop-down>
            </div>
          </md-table-cell>
        </md-table-row>
      </md-table>
    </md-card-content>
  </md-card>
</template>

<script>
import {utils, writeFile} from "xlsx";
import {permMixin} from "@/mixins/permission"

export default {
  name: "daily-inspection-subTable",
  props: {
    feature: {type: String},
    subTableTitle: {type: String},
    tableData: {type: Array, default: () => []},
    tableDataHeaders: {type: Array, default: () => []},
    headerColor:{type:String, default:()=> "green"}
  },
  mixins: [permMixin],
  data() {
    return {
      responsive: false,
      isDataLoading: false,
    }
  },
  methods: {
    onDataRowAdd() {
    },
    onDataRowEdit(data) {
    },
    onDataRowDelete(id) {
    },
    getClass(headerColor) {
      return 'md-card-header-' + headerColor + ''
    },
    onExport() {
      const headers = this.dataHeaders.map((header) =>
          this.$t(`translate.${header}`)
      )
      const export_data = [headers, ...this.tableData]
      const today = new Date().toJSON().slice(0, 10)
      const worksheet = utils.aoa_to_sheet(export_data)
      const new_workbook = utils.book_new()


      utils.book_append_sheet(
          new_workbook,
          worksheet,
          `${this.name}`
      )
      writeFile(
          new_workbook,
          `export_${this.$t(this.subTableName)}_${today}.xlsx`
      )
    },
  },
}
</script>


<style lang="scss">
@import '@/assets/scss/md/_variables.scss';

//.md-button + .md-button {
//  margin-left: 10px;
//}

.load-progress {
  position: absolute;
  width: 100%;
  top: 0px;
  display: flex;
  flex-direction: column;
  align-items: center;

  .progress-bar {
    width: 100%;
  }
}

.sub-table-content{
  height: 400px;
}

.icon-zone {
  position: absolute;
  right: 5px;
  top: 15px;
  font-size: 25px;
  color: $gray-color;
  cursor: pointer;
  display: flex;
  font-size: 24px;

  .active {
    color: $green-500
  }

}

.cell-actions {
  display: flex;
  flex-direction: column;
  align-items: flex-end;

}

.card-icon {
  position: relative;
  z-index: 10 !important;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.7s;
}

.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */
{
  opacity: 0;
}

</style>