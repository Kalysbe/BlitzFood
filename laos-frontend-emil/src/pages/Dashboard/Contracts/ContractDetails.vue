<template>
    <div class="md-layout">
        <div class="md-layout-item md-layout md-size-100">
            <div class="md-layout-item md-size-100 mng-button-area">
                <md-button
                        class="md-success"
                        @click.native.prevent="onContractEnv"
                >
                    {{ $t('button.monitoring_forms') }}
                </md-button>

                <!--md-button
                    class="md-success"
                    @click.native.prevent="onContractEnv"
                >
                  {{ $t('button.inspections') }}
                </md-button-->
                <!--md-button
                    class="md-success"
                    @click.native.prevent="onContractDailyInspections"
                >
                  {{ $t('button.daily_inspections') }}
                </md-button-->

                <md-button
                    class="md-success"
                    @click="onContractVariations"
                >
                    {{ $t('button.variations') }}
                </md-button>
                <md-button
                    class="md-success"
                    @click="onContractPayments"
                >
                  {{ $t('button.payments') }}
                </md-button>
                <!--md-button class="md-accent" @click.stop.prevent="onGoToList">
                  {{ $t('button.close') }}
                </md-button-->
            </div>
            <div class="md-layout-item md-layout md-size-100">
                <div class="md-layout-item md-size-40 md-medium-size-100">
                    <md-card>
                        <transition name="fade">
                            <div v-if="isDataLoading" class="load-progress">
                                <md-progress-bar
                                        md-mode="indeterminate"
                                        class="progress-bar"
                                ></md-progress-bar>
                            </div>
                        </transition>
                        <md-card-header
                                class="md-card-header-icon md-card-header-green card-icon"
                        >
                            <div class="card-icon">
                                <md-icon>view_list</md-icon>
                            </div>
                            <h4 class="title">{{ $t('label.contract_details') }}</h4>
                        </md-card-header>
                        <md-card-content>
                            <!--div class="details-scroll-area"-->
                            <md-table>
                                <md-table-row slot="md-table-row">
                                    <md-table-cell>{{ $t(`contract.e_archive_url`) }}</md-table-cell>
                                    <md-table-cell>
                                        <a href="#">{{ $t(`label.link`) }}</a>
                                    </md-table-cell>
                                </md-table-row>
                                <md-table-row slot="md-table-row">
                                    <md-table-cell>{{ $t(`contract.contract_variations`) }}</md-table-cell>
                                    <md-table-cell>
                                        <a href="#" @click.prevent="onContractVariations">{{ $t(`label.list`) }}</a>
                                    </md-table-cell>
                                </md-table-row>
                                <md-table-row slot="md-table-row">
                                    <md-table-cell>{{ $t(`contract.payments`) }}</md-table-cell>
                                    <md-table-cell>
                                        <a href="#" @click.prevent="onContractPayments">{{ $t(`label.list`) }}</a>
                                    </md-table-cell>
                                </md-table-row>
                                <md-table-row slot="md-table-row" v-for="item in Object.keys(details)" :key="item">
                                    <md-table-cell>{{ $t(`contract.${item}`) }}</md-table-cell>
                                    <md-table-cell>
                                        <template v-if="Array.isArray(details[item])">
                                            {{ details[item].join(', ') }}
                                        </template>
                                        <template v-else>
                                            {{ details[item] }}
                                        </template>
                                    </md-table-cell>
                                </md-table-row>
                            </md-table>
                        </md-card-content>
                    </md-card>
                </div>
                <div class="md-layout ">
                    <div class="md-layout-item md-size-100">
                        <ImageGallery>
                            <template v-slot:imageCollection>
                                <ImageList
                                        :images="photoCollection"
                                        @preview="openPhotoPreview"
                                ></ImageList>
                            </template>
                        </ImageGallery>

                    </div>
                </div>

            </div>

        </div>
        <div id="fullpage"
             @click="previewDisplay='none'"
             :style="{backgroundImage:previewBackgroundImage, display:previewDisplay}"
        ></div>
    </div>
</template>

<script>
import ImageList from "@/components/ImageList/index.vue";
import ImageGallery from "@/components/ImageGallery.vue";
import EArchiveGallery from "@/components/eArchiveGallery.vue";
import EArchiveList from "@/components/eArchiveList/index.vue";

export default {
    name: "ContractDetails",
    components: {
        EArchiveList,
        EArchiveGallery,
        ImageGallery,
        ImageList
    },
    props: ["contractId"],
    data() {
        return {
            previewBackgroundImage: "",
            previewDisplay: "none",
            details: {},
            isDataLoading: false,
            photoCollection: [],
        }
    },
    async created() {
        this.isDataLoading = true
        for (let m = 1; m < 4; m++) {
            for (let i = 1; i < 8; i++) {
                this.photoCollection.push({
                    thumbnail: `/images/images/road${i}.jpg`,
                    meta: `Some image ${m} - ${i} meta very-very-very long data `,
                    previewUrl: `/images/images/road${i}.jpg`
                })
            }
        }

        try {
            this.details = await this.$store.dispatch("LOAD_CONTRACT_DETAILS", this.contractId)
        } finally {
            this.isDataLoading = false
        }

    },
    methods: {
        openPhotoPreview(image) {
            this.previewBackgroundImage = 'url(' + image + ')';
            this.previewDisplay = 'block';
        },
        onContractPayments() {
            this.$router.push({name: "contract-payments", params: {contractId: this.contractId}})
        },
        onContractVariations() {
            this.$router.push({name: "contract-variations", params: {contractId: this.contractId}})
        },
        onContractEnv() {
            this.$router.push({name: "contract-environment", params: {contractId: this.contractId}})
        },
    },
    computed: {}
}
</script>

<style lang="scss" scoped>
@import "@/assets/scss/md/_variables.scss";

.text-align-right {
  text-align: right
}

.mng-button-area {
  display: flex;
  justify-content: flex-end;
  flex-wrap: wrap;

  .md-button {
    margin-left: 3px;
  }
}

.details-scroll-area {
  height: 935px;
  overflow-y: auto;
}

.files-scroll-area {
  height: 300px;
  overflow-y: auto;
}


.image-container {
  max-width: 500px;
}

.underline-row {
  border-bottom: solid 1px $btn-default-border;
}
</style>

<style lang="scss" scoped>
#fullpage {
  display: none;
  position: fixed;
  z-index: 9999;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-size: contain;
  background-repeat: no-repeat no-repeat;
  background-position: center center;
  background-color: black;
}
</style>