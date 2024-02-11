<template>
  <div class="md-layout">
    <div
        class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-50"
    >

      <div class="md-layout">
        <div class="md-layout-item  md-xsmall-size-100 md-size-50">
          <stats-card header-color='green'>
            <template slot='header'>
              <div class='card-icon'>
                <md-icon>schema</md-icon>
              </div>
              <p class='category'>{{ $t("lot.summary_of_bill") }}</p>
              <h3 class='title'>
                <animated-number :value='lotBoqAmount' :separate="true"></animated-number>
              </h3>
            </template>
            <template slot='footer'>
              <div class='stats'>
                {{ $t("lot.subtext") }}
              </div>
            </template>
          </stats-card>
        </div>
        <div
            class="md-layout-item  md-xsmall-size-100 md-size-50"
        >
          <stats-card header-color='blue'>
            <template slot='header'>
              <div class='card-icon'>
                <md-icon>work_history</md-icon>
              </div>
              <p class='category'>{{ $t("lot.summary_of_dayWork") }}</p>
              <h3 class='title'>
                <animated-number :value='lotDayWorksAmount' :separate="true"></animated-number>
              </h3>
            </template>
            <template slot='footer'>
              <div class='stats'>
                {{ $t("lot.subtext") }}
              </div>
            </template>
          </stats-card>
        </div>
      </div>
      <div class="md-layout-item md-size-100">
        <div class="bill-total">
          <h4>
            <span>{{ $t("lot.total_amount") }}: {{ lotTotalAmount | formatNumber }}</span>
          </h4>
          <drop-down>
            <md-button
                slot="title"
                class="md-button md-simple md-just-icon md-round"
                data-toggle="dropdown"
            >
              <md-icon>more_vert</md-icon>
            </md-button>
            <ul
                class="dropdown-menu"
                :class="{ 'dropdown-menu-right': !responsive }"
            >
              <li><a href="#" @click="onAddBill">{{ $t("lot.add_bill") }}</a></li>
              <li><a href="#">{{ $t("lot.add_dayWork_labor") }}</a></li>
              <li><a href="#">{{ $t("lot.add_dayWork_material") }}</a></li>
              <li><a href="#">{{ $t("lot.add_dayWork_equipment") }}</a></li>
            </ul>
          </drop-down>
        </div>
      </div>
      <div class="md-layout-item md-size-100">
        <time-line plain type="simple">
          <time-line-item v-for="it in boqList" :key="it.billGroup" inverted badge-type="success" badge-icon="assignment">
            <div slot="header" style="display: flex; align-items: center; justify-content: space-between">
              <span class="badge badge-success">{{ $t('label.bill') }} {{ it.billGroup }}</span>
              <md-button class="md-success md-just-icon md-round md-sm" @click='onAddBill(it.billGroup)'>
                <md-icon>add</md-icon>
              </md-button>
            </div>
            <div slot="content">
              <md-table v-model="it.data">
                <md-table-row slot="md-table-row" slot-scope="{ item }">
                  <md-table-cell md-label="Item No">{{ item.item_no }}</md-table-cell>
                  <md-table-cell md-label="Description">{{ item.description }}</md-table-cell>
                  <md-table-cell md-label="Unit">{{
                      item.unit
                    }}
                  </md-table-cell>
                  <md-table-cell md-label="Quantity" md-numeric>{{ item.quantity | formatNumber }}</md-table-cell>
                  <md-table-cell md-label="Unit price" md-numeric>{{ item.unit_price | formatNumber }}</md-table-cell>
                  <md-table-cell md-label="Amount" md-numeric>{{ item.quantity * item.unit_price | formatNumber }}</md-table-cell>
                  <md-table-cell md-label="Action" md-numeric>

                    <md-button
                        class="md-simple md-danger md-just-icon md-round" @click="removeBoqItem(it.billGroup, item.item_no)"
                    >
                      <md-icon>delete</md-icon>
                    </md-button>

                  </md-table-cell>
                </md-table-row>
              </md-table>
            </div>
            <h6 slot="footer">
              <i class="ti-time"></i>
              {{ $t('label.bill_total') }}: {{ subBillTotal(it.billGroup) | formatNumber }}
            </h6>
          </time-line-item>

          <time-line-item inverted badge-type="info" badge-icon="receipt_long">
            <div slot="header" style="display: flex; align-items: center; justify-content: space-between">
              <span slot="header" class="badge badge-info">Daywork</span>
              <drop-down>
                <md-button
                    slot="title"
                    class="md-button md-info md-round md-just-icon"
                    data-toggle="dropdown"
                >
                  <md-icon>add</md-icon>
                </md-button>
                <ul
                    class="dropdown-menu"
                    :class="{ 'dropdown-menu-right': !responsive }"
                >
                  <li><a href="#">Labor</a></li>
                  <li><a href="#">Equipment</a></li>
                  <li><a href="#">Material</a></li>
                </ul>
              </drop-down>
            </div>
            <div slot="content">
              <md-table v-model="dayWorkList">
                <md-table-row slot="md-table-row" slot-scope="{ item, index }">
                  <md-table-cell md-label="Item No">{{ item.item_no }}</md-table-cell>
                  <md-table-cell md-label="Description">{{ item.description }}</md-table-cell>
                  <md-table-cell md-label="Unit">{{
                      item.unit
                    }}
                  </md-table-cell>
                  <md-table-cell md-label="Quantity" md-numeric>{{ item.quantity | formatNumber }}</md-table-cell>
                  <md-table-cell md-label="Unit price" md-numeric>{{ item.unit_price | formatNumber }}</md-table-cell>
                  <md-table-cell md-label="Amount" md-numeric>{{ item.quantity * item.unit_price | formatNumber }}</md-table-cell>
                  <md-table-cell md-label="Action" md-numeric>

                    <md-button
                        class="md-simple md-danger md-just-icon md-round"
                        @click="removeDayworkItem(item.item_no)"
                    >
                      <md-icon>delete</md-icon>
                    </md-button>

                  </md-table-cell>
                </md-table-row>
              </md-table>
              <hr>
              <h6 slot="footer">
                <i class="ti-time"></i>
                {{ $t('label.total') }}: {{ lotDayWorksAmount | formatNumber }}
              </h6>
            </div>

          </time-line-item>
        </time-line>
      </div>
    </div>
    <md-dialog :md-active.sync='showBillAdd '>
      <md-dialog-content>
        {{
          $t(`lot.add_bill`)
        }}
        <md-field>
          <label>{{ $t("lot.bill_item_no") }}</label>
          <md-select v-model="newBill.item_no">
            <md-option v-for="content in billTypeContent" :value="content.boq_id" :key="content.id">{{ content.boq_id }} /
              {{ $t(`lot.bill_item_${content.name}`) }}
            </md-option>
          </md-select>
        </md-field>

        <md-field>
          <label>{{ $t('label.quantity') }}</label>
          <md-input v-model='newBill.quantity' type='number'></md-input>
        </md-field>
        <md-field>
          <label>{{ $t('label.price') }}</label>
          <md-input v-model='newBill.price' type='number'></md-input>
        </md-field>
      </md-dialog-content>
      <md-dialog-actions>
        <md-button :disabled='false' class='md-success' @click='addBill'>{{ $t('button.apply') }}</md-button>
        <md-button class='md-simple' @click='showBillAdd = false'>{{ $t('button.close') }}</md-button>
      </md-dialog-actions>
    </md-dialog>
  </div>

</template>

<script>
import {AnimatedNumber, StatsCard, TimeLine, TimeLineItem,} from "@/components";
import Swal from "sweetalert2";

export default {
  name: "LotContent",
  components: {
    TimeLine, TimeLineItem,
    AnimatedNumber, StatsCard
  },
  props: {
    contractId: {type: Number},
    lotId: {type: Number},
  },

  data() {
    return {
      responsive: false,
      boqList: [],
      dayWorkList: [],
      showBillAdd: false,
      showDayWorkAdd: false,
      newBill: {item_no: undefined, quantity: 1, price: 0},
      refDayWork: [],
      billTypes: ["boq", "mac", "other"],
      billTypeContent: []
    }
  },
  async created() {
    try {
      const content = await this.$store.dispatch("LOAD_LOT_CONTENT", {contractId: this.contractId, lotId: this.lotId})
      this.boqList = content.boqs
      this.dayWorkList = content.dayworks
    } catch (err) {
      console.log(err)
      throw err
    }

  },
  methods: {
    async onAddBill(group = null) {
      const boqs = await this.$store.dispatch("LOAD_BILLS_OF_QUANTITIES")

      this.billTypeContent = [...boqs.sort((a, b) => {
        return a.id - b.id
      }).map(boq => {
        return {name: boq.boq_description, ...boq}
      })]

      this.newBill = {item_no: undefined, quantity: 1, price: 0}
      this.showBillAdd = true
    },
    async addBill() {
      const fire = {
        title: this.$t('label.added'),
        text: this.$t('label.record_was_added'),
        type: "success",
      }

      try {
        const params = {contractId: this.contractId, lotId: this.lotId, data: this.newBill}
        await this.$store.dispatch("ADD_LOT_BILL_ITEM", {...params})
        const boqItem = this.billTypeContent.find(boq => {
          return boq.boq_id === this.newBill.item_no
        })

        const boqListInd = this.boqList.findIndex(b => b.billGroup === boqItem.boq_top)
        if (~boqListInd) {
          const insNo = boqItem.boq_id.split("-")
          const sumInsNo = parseInt(insNo[0]) + parseInt(insNo[1])
          let insIndex = this.boqList[boqListInd].data.length
          this.boqList[boqListInd].data.every((row, ind) => {
            const no = row.item_no.split("-")
            const sumNo = parseInt(no[0]) + parseInt(no[1])
            if (sumNo > sumInsNo) {
              insIndex = ind
              return false
            }
            return true
          })
          this.boqList[boqListInd].data.splice(insIndex, 0, {
            description: boqItem.boq_description,
            item_no: boqItem.boq_id,
            quantity: this.newBill.quantity,
            unit: boqItem.unit,
            unit_price: this.newBill.price
          });

        }
        this.showBillAdd = false
      } catch (err) {
        fire.title = this.$t('label.error'),
            fire.text = this.$t('label.record_was_not_added')
        fire.type = 'error'
        fire.footer = err.message ? err.message : err
      } finally {
        Swal.fire({
          ...fire,
          confirmButtonClass: "md-button md-success",
          buttonsStyling: false
        })
      }


    },

    removeBoqItem(bill, no) {
      Swal.fire({
        title: this.$t("label.are_you_sure"),
        text: this.$t("label.do_you_want_to_delete", {data: `${bill} - ${no}`}),
        showCancelButton: true,
        confirmButtonText: this.$t("label.yes_delete_it"),
        cancelButtonText: this.$t("label.cancel"),
        confirmButtonClass: "md-button md-success",
        cancelButtonClass: "md-button md-danger",
        buttonsStyling: false
      }).then(async result => {
        if (result.value) {
          const fire = {
            title: this.$t('label.deleted'),
            text: this.$t('label.record_was_deleted'),
            type: "success",
          }
          try {
            const params = {contractId: this.contractId, lotId: this.lotId, bill: no}
            await this.$store.dispatch("REMOVE_LOT_BILL_ITEM", {...params})
            const ind = this.boqList.findIndex(boq => boq.billGroup === bill)
            const subInd = this.boqList[ind].data.findIndex(bill => bill.item_no = no)
            this.boqList[ind].data.splice(subInd, 1);
          } catch (err) {
            fire.title = this.$t('label.error'),
                fire.text = this.$t('label.record_was_not_deleted')
            fire.type = 'error'
            fire.footer = err.message ? err.message : err
          } finally {
            Swal.fire({
              ...fire,
              confirmButtonClass: "md-button md-success",
              buttonsStyling: false
            })
          }

        }
      });
    },
    removeDayworkItem(no) {
      Swal.fire({
        title: this.$t("label.are_you_sure"),
        text: this.$t("label.do_you_want_to_delete", {data: `dayWork - ${no}`}),
        showCancelButton: true,
        confirmButtonText: this.$t("label.yes_delete_it"),
        cancelButtonText: this.$t("label.cancel"),
        confirmButtonClass: "md-button md-danger",
        cancelButtonClass: "md-button md-default",
        buttonsStyling: false
      }).then(async result => {
        if (result.value) {
          const fire = {
            title: this.$t('label.deleted'),
            text: this.$t('label.record_was_deleted'),
            type: "success",
          }
          try {
            const params = {contractId: this.contractId, lotId: this.lotId, bill: no}
            await this.$store.dispatch("REMOVE_LOT_DAYWORK_ITEM", {...params})
            const ind = this.dayWorkList.findIndex(work => work.item_no === no)
            this.dayWorkList.splice(ind, 1);
          } catch (err) {
            fire.title = this.$t('label.error'),
                fire.text = this.$t('label.record_was_not_deleted')
            fire.type = 'error'
            fire.footer = err.message ? err.message : err
          } finally {
            Swal.fire({
              ...fire,
              confirmButtonClass: "md-button md-success",
              buttonsStyling: false
            })
          }

        }
      });

    },
    subBillTotal(group) {
      const boq = this.boqList.find(boq => {
        return boq.billGroup === group
      })
      return boq.data.reduce((accumulator, current) => {
        return accumulator + (current.quantity * current.unit_price);
      }, 0);
    }
  },
  computed: {
    lotBoqAmount() {
      return this.boqList.reduce((accum, curr) => {
        return accum + curr.data.reduce((accumulator, current) => {
          return accumulator + current.quantity * current.unit_price;
        }, 0)

      }, 0);
    },
    lotDayWorksAmount() {
      return this.dayWorkList.reduce((accumulator, current) => {
        return accumulator + current.quantity * current.unit_price;
      }, 0)
    },
    lotTotalAmount() {
      return this.lotBoqAmount + this.lotDayWorksAmount
    }
  },


}
</script>

<style lang="scss">

.md-table-head:last-child:not(:first-child) .md-table-head-label {
  padding-right: 0;
}

.md-table-head {
  padding: 8px 0px 0px 8px;
}

.bill-total {
  background: white;
  border-radius: 6px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  min-height: 40px;
  box-shadow: 0 1px 4px 0 rgb(0 0 0 / 14%);
  padding: 0 2rem;
}
</style>