<template>
    <div>
        <div class="main-form md-layout">
            <form>
                <md-card>
                    <md-card-header
                            :class='getClass(headerColor)'
                            class='md-card-header-icon'
                    >
                        <div class='card-icon'>
                            <md-icon>{{ act === "add" ? "note_add" : "description" }}</md-icon>
                        </div>
                        <h4 class='title'>
                            {{ $t(`contract.variation`) }}
                            <small></small>
                        </h4>
                    </md-card-header>
                    <md-card-content>
                        <div class='md-layout'>
                            <div class='md-layout-item md-small-size-100 md-size-35'>
                                <md-field :class="[
                                    {'md-valid': !errors.has('variation_number') && touched.variation_number},
                                    {'md-error': errors.has('variation_number')}
                                    ]"
                                >

                                    <label>
                                        {{ $t(`contract.variation_number`) }}
                                    </label>
                                    <md-input
                                            v-model='variationProps.variation_number'
                                            :v-validate='modelValidations.variation_number'
                                            data-vv-name='variation_number'
                                            type='text'
                                    ></md-input>
                                    <slide-y-down-transition>
                                        <md-icon v-show='errors.has("variation_number")' class='error'>
                                            close
                                        </md-icon>
                                    </slide-y-down-transition>
                                </md-field>
                            </div>
                            <div class='md-layout-item md-small-size-100 md-size-35'>
                                <md-field>

                                    <label>
                                        {{ $t(`contract.work_type`) }}
                                    </label>
                                    <md-select v-model="variationProps.work_type_id">
                                        <md-option v-for="type in workTypes" :value="type.id" :key="type.id">{{ $t(type.name) }}</md-option>
                                    </md-select>

                                </md-field>
                            </div>
                            <div class='md-layout-item md-small-size-100 md-size-30'>
                                <md-datepicker v-model="variationProps.variation_date">
                                    <label>
                                        {{ $t(`contract.variation_date`) }}
                                    </label>
                                </md-datepicker>
                            </div>
                            <div class='md-layout-item md-small-size-100 md-size-100'>
                                <md-field>
                                    <label>
                                        {{ $t(`contract.comments`) }}
                                    </label>
                                    <md-input
                                            v-model='variationProps.comments'
                                            :v-validate='modelValidations.comments'
                                            data-vv-name='comments'
                                            type='text'
                                    ></md-input>
                                </md-field>
                            </div>
                            <div class='md-layout-item md-size-100 text-right'>
                                <md-button
                                        class='md-success'
                                        native-type='submit'
                                        @click.native.prevent='validate'
                                >
                                    {{ $t('button.save') }}
                                </md-button>
                                <md-button class='md-accent' @click.stop.prevent='onCancel'>
                                    {{ $t('button.close') }}
                                </md-button>
                            </div>
                        </div>
                    </md-card-content>
                </md-card>
            </form>
        </div>

        <ContractVariationWorks v-if="act==='upd'"
                                :contractId="contractId"
                                :variationId="variationId"/>

    </div>
</template>

<script>
import Swal from "sweetalert2";
import {SlideYDownTransition} from 'vue2-transitions'
import ContractVariationWorks from "@/components/Tables/ContractVariationWorks.vue";

export default {
    name: "ContractVariationProfile",
    components: {
        SlideYDownTransition,
        ContractVariationWorks
    },


    data() {
        let now = new Date()
        return {
            workTypes: [],
            variationProps: {
                variation_number: null,
                comments: "",
                work_type_id: null,
                variation_date: now
            },
            loadedContractProps: {},
            touched: {
                variation_number: false,
                comments: false,
            },
            modelValidations: {
                variation_number: {
                    require: true
                },
            },
            headerColor: "green",
            isDataLoading: false,
        }
    },

    props: {
        act: {type: String},
        contractId: {type: Number},
        variationId: {type: Number},
    },
    methods: {
        onFieldChange(field) {
            this.touched[field] = true
        },
        onCancel() {
            this.$router.push({name: "contract-variations"})
        },
        getClass: function (headerColor) {
            return 'md-card-header-' + headerColor + ''
        },
        async validate() {
            const isValid = await this.$validator.validateAll()
            const operType = this.act === 'add' ? 'added' : 'updated'
            if (!isValid) {
                return
            } else {
                const alert = {
                    type: 'success',
                    text: this.$t(`info.variation_order_was_${operType}`),
                    footer: ''
                }
                try {
                    if (this.act === 'add') {
                        await this.$store.dispatch('ADD_CONTRACT_VARIATION', {contractId: this.contractId, data: this.variationProps})

                    } else if (this.act === 'upd') {
                        await this.$store.dispatch('UPD_CONTRACT_VARIATION',
                            {contractId: this.contractId, variationId: this.variationId, data: this.variationProps})
                    } else {
                        throw `bad operation type`
                    }

                    Swal.fire(alert).then(() => {
                        this.$nextTick(() => this.$validator.reset())
                    })

                } catch (err) {
                    alert.type = 'error'
                    alert.text = this.$t(`info.variation_order_was_not_${operType}`)
                    alert.footer = this.$t(err.message ? err.message : err)
                    await Swal.fire(alert)
                }
            }
        }
    },
    async created() {
        this.$store.dispatch("LOAD_CONTRACT_WORK_TYPES").then(list => {
            this.workTypes = [...list]
        })
        if (this.act === "upd") {
            const res = await this.$store.dispatch("LOAD_CONTRACT_VARIATION_BY_ID", {
                contractId: this.contractId, variationId: this.variationId
            })
            this.variationProps = {...res}
        }
    },
    computed: {}
}
</script>

<style lang="scss" scoped>
.md-button + .md-button {
  margin-left: 10px;
}

.load-progress {
  position: absolute;
  width: 100%;
  /* height: 100%; */
  top: 0px;
  display: flex;
  flex-direction: column;
  align-items: center;

  .progress-bar {
    width: 100%;
  }
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