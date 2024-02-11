<template>
    <md-card>
        <transition name="fade">
            <div v-if="isDataLoading" class="load-progress">
                <md-progress-bar
                        md-mode="indeterminate"
                        class="progress-bar"
                ></md-progress-bar>
            </div>
        </transition>
        <md-card-header class='md-card-header-blue md-card-header-icon'>

            <div class='card-icon'>
                <md-icon>list</md-icon>
            </div>
            <h4 class='title'>
                {{ $t(`contract.variation_works`) }}
                <small></small>
            </h4>

            <drop-down style="position: absolute; right:20px; top:12px">
                <md-button
                        slot="title"
                        class="md-button md-success md-just-icon md-round"
                        data-toggle="dropdown"
                >
                    <md-icon>add</md-icon>
                </md-button>
                <ul
                        class="dropdown-menu"
                        :class="{ 'dropdown-menu-right': !responsive }"
                >
                    <li><a href="#" @click.prevent="onAddBoq">{{ $t("lot.add_boq") }}</a></li>
                    <li><a href="#" @click.prevent="onAddMac">{{ $t("lot.add_mac") }}</a></li>
                </ul>
            </drop-down>
        </md-card-header>
        <md-card-content>

            <md-table v-model="works">
                <md-table-row slot="md-table-row" slot-scope="{ item, index }">
                    <md-table-cell :md-label="$t('label.item_no')" :md-tooltip="$t('label.item_no')" md-numeric>{{ index + 1 }}</md-table-cell>
                    <md-table-cell :md-label="$t('contract.work_category')" :md-tooltip="$t('contract.work_category')">
                        {{ $t(`contract.work_category_${item.type}`) }}
                    </md-table-cell>
                    <md-table-cell :md-label="$t('contract.work_category_id')" :md-tooltip="$t('contract.work_category_id')" md-numeric>
                        {{ item.type_id }}
                    </md-table-cell>
                    <md-table-cell :md-label="$t('contract.work_description')" :md-tooltip="$t('contract.work_description')" md-numeric>
                        {{ $t(`${item.type}.${item.description}`) }}
                    </md-table-cell>
                    <md-table-cell :md-label="$t('label.unit')" :md-tooltip="$t('label.unit')">{{
                        item.unit
                        }}
                    </md-table-cell>
                    <md-table-cell :md-label="$t('label.quantity')" :md-tooltip="$t('label.quantity')" md-numeric>{{
                        item.quantity | formatNumber
                        }}
                    </md-table-cell>
                    <md-table-cell :md-label="$t('label.unit_cost')" :md-tooltip="$t('label.unit_cost')" md-numeric>{{
                        item.unit_cost | formatNumber
                        }}
                    </md-table-cell>
                    <md-table-cell :md-label="$t('label.cost')" :md-tooltip="$t('label.cost')" md-numeric>
                        {{ item.quantity * item.unit_cost | formatNumber }}
                    </md-table-cell>
                    <md-table-cell md-label="Action" md-numeric>

                        <md-button
                                class="md-simple md-danger md-just-icon md-round" @click="removeWorkItem(item)"
                        >
                            <md-icon>delete</md-icon>
                        </md-button>

                    </md-table-cell>
                </md-table-row>
            </md-table>
            <div class="table table-stats table-striped">
                <div class="td-price">
                    <div class="td-total">
                        {{ $t('label.total') }}:
                    </div>
                    <span>
                {{ total_works | formatNumber }}
              </span>
                </div>
            </div>
        </md-card-content>
        <md-dialog :md-active.sync='showWorkAdd '>
            <md-dialog-content>
                {{
                $t(`contract.add_item`)
                }}
                <md-field>
                    <label>{{ $t("contract.work_item_no") }}</label>
                    <md-select v-model="newWork.item_no">
                        <md-option v-for="content in workItems" :value="content.id" :key="content.id">{{ content.id }} /
                            {{ $t(`contract.work_item_${content.name}`) }}
                        </md-option>
                    </md-select>
                </md-field>

                <md-field>
                    <label>{{ $t('label.quantity') }}</label>
                    <md-input v-model='newWork.quantity' type='number'></md-input>
                </md-field>
                <md-field>
                    <label>{{ $t('label.price') }}</label>
                    <md-input v-model='newWork.price' type='number'></md-input>
                </md-field>
            </md-dialog-content>
            <md-dialog-actions>
                <md-button :disabled='false' class='md-success' @click='addWorkToList'>{{ $t('button.apply') }}</md-button>
                <md-button class='md-simple' @click='showWorkAdd = false'>{{ $t('button.close') }}</md-button>
            </md-dialog-actions>
        </md-dialog>
    </md-card>


</template>

<script>
import Swal from "sweetalert2";

export default {
    name: "ContractVariationWorks",
    props: {
        variationId: null,
        contractId: null
    },
    data() {
        return {
            isDataLoading: false,
            responsive: false,
            works: [],
            boqs: [],
            macs: [],
            newWork: {
                item_no: "",
                quantity: 0,
                price: 0,
                type: "",
                description: ""
            },
            workItems: [],
            showWorkAdd: false,
        }
    },
    created() {
        this.$store.dispatch("LOAD_CONTRACT_VARIATION_WORKS_BY_ID", {contractId: this.contractId, variationId: this.variationId}).then(res => {
            this.works = [...res]
        })
        this.$store.dispatch("LOAD_BILLS_OF_QUANTITIES").then(list => {
            this.boqs = [...list]
        })
        this.$store.dispatch("LOAD_MAINTENANCE_ACTIVITY_CODES").then(list => {
            this.macs = [...list]
        })
    },
    methods: {
        async removeWorkItem(item) {
            try {
                Swal.fire({
                        title: this.$t("label.are_you_sure"),
                        text: this.$t("label.do_you_want_to_delete", {data: `${item}`}),
                        showCancelButton: true,
                        confirmButtonText: this.$t("label.yes_delete_it"),
                        cancelButtonText: this.$t("label.cancel"),
                        confirmButtonClass: "md-button md-danger",
                        cancelButtonClass: "md-button md-default",
                        buttonsStyling: false
                    }
                ).then(async result => {
                    if (result.value) {
                        const fire = {
                            title: this.$t('label.deleted'),
                            text: this.$t('label.record_was_deleted'),
                            type: "success",
                        }
                        try {
                            await this.$store.dispatch("DEL_CONTRACT_VARIATION_WORK", {
                                contractId: this.contractId,
                                variationId: this.variationId,
                                data: item
                            })
                            const ind = this.works.findIndex(work => work.type === item.type && work.type_id === item.type_id)
                            if (~ind) {
                                this.works.splice(ind, 1)
                            }
                        } catch (err) {
                            fire.title = this.$t('label.error')
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
                })

            } catch (err) {

            }
        },
        onAddBoq() {
            const list = this.boqs
                .sort((a, b) => {
                    return a.boq_id - b.boq_id
                })
                .map(boq => {
                    return {
                        id: boq.boq_id,
                        name: boq.boq_description,
                        unit: boq.unit,
                        description: boq.boq_description
                    }
                })
            this.onAddWork(list, "boq")
        },
        onAddMac() {
            const list = this.macs
                .sort((a, b) => {
                    return a.mac_id - b.mac_id
                })
                .map(mac => {
                    return {
                        id: mac.mac_id,
                        name: mac.work_task,
                        unit: mac.unit,
                        description: mac.work_task
                    }
                })
            this.onAddWork(list, "mac")
        },
        onAddWork(list, type) {
            this.workItems = [...list]
            this.newWork = {item_no: "", quantity: 1, price: 0, type, description: "",}
            this.showWorkAdd = true
        },

        async addWorkToList() {
            const contractId = this.contractId
            const variationId = this.variationId
            let workDescr = ""
            const {type, item_no: type_id, unit, price: unit_cost, quantity} = this.newWork
            const data = {type, type_id, unit, unit_cost, quantity}
            try {
                await this.$store.dispatch("ADD_CONTRACT_VARIATION_WORK", {contractId, variationId, data})
                if (type === 'boq') {
                    const find = this.boqs.find(boq => boq.boq_id === type_id)
                    workDescr = find.boq_description
                } else if (type === 'mac') {
                    const find = this.macs.find(mac => mac.mac_id === type_id)
                    workDescr = find.work_task
                }
                this.works.push({...data, description: workDescr})
            } catch (err) {
                await Swal.fire({
                    title: this.$t('label.error'),
                    text: this.$t('label.record_was_not_deleted'),
                    type: 'error',
                    footer: err.message ? err.message : err
                })
            } finally {
                this.showWorkAdd = false
            }
        }
    },
    computed: {
        total_works() {
            return this.works.reduce((accum, curr) => {
                return accum + (curr.quantity * curr.unit_cost)
            }, 0)
        }
    }
}
</script>

<style lang="scss">

.md-card .md-card-header a {
  color: unset !important;
}

.load-progress {
  position: absolute;
  width: 100%;
  /* height: 100%; */
  top: 0;
  display: flex;
  flex-direction: column;
  align-items: center;

  .progress-bar {
    width: 100%;
  }
}

.md-table-head-label {
  height: 40px;
  //max-width: 150px;
  //padding-right: 32px;
  //padding-left: 2px;
  //display: inline-block;
  //position: relative;
  line-height: 20px;
}

.md-table-head-container, .md-table-head-label {
  overflow: hidden;
  white-space: inherit;
}

.md-table-head:last-child:not(:first-child) .md-table-head-label {
  padding-right: 0;
}

.table-stats {
  display: flex;
  align-items: center;
  text-align: right;
  flex-flow: row wrap;

  .td-price .td-total {
    display: inline-flex;
    font-weight: 500;
    font-size: 1.0425rem;
    margin-right: 50px;
  }

  &.table-striped .td-price {
    border-bottom: 0;
  }

  .td-price {
    font-size: 22px;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
  }

  .td-price,
  > div {
    flex: 0 0 100%;
    padding: 12px 8px;
  }
}

</style>