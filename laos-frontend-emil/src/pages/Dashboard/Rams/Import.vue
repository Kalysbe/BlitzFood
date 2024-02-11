<template>
  <form slot="form">
    <div class="md-layout">
      <md-card class="md-layout-item md-size-50 md-medium-size-80 md-small-size-100">
        <md-card-header class="md-card-header-icon md-card-header-green">
          <div class="card-icon">
            <md-icon>snippet_folder</md-icon>
          </div>
          <h4 class="title">{{ $t("import.upload_form") }}</h4>
        </md-card-header>
        <md-card-content>
          <div class="md-layout md-size-100">
            <label class="md-layout-item md-size-15  md-small-size-100  md-form-label">{{
                `${$t("import.data_description")}:`
              }}</label>
            <div class="md-layout-item md-size-85 md-small-size-100">
              <md-field>
                <md-input v-model="dataDescription"></md-input>
              </md-field>
            </div>
          </div>
          <div class="md-layout md-size-100">
            <label class="md-layout-item md-size-15 md-small-size-100  md-form-label">{{
                `${$t("import.file_type")}:`
              }}</label>
            <div class="md-layout-item md-size-85 md-small-size-100">
              <div class="md-layout radio-store">
                <div class="md-layout-item md-small-size-100 md-text-alignment-right" v-for="type of fileTypes"
                     :key="type.name">
                  <md-radio v-model="selectedFileType" :value="type.name" @change="fileTypeChanged">{{
                      type.value
                    }}
                  </md-radio>
                </div>
              </div>
            </div>
          </div>
          <div class="md-layout md-size-100">
            <label
                class="md-layout-item md-size-15  md-small-size-100  md-form-label">{{
                `${$t("import.import_data_file")}:`
              }}</label>
            <div
                class="md-layout-item  md-layout md-size-85  md-small-size-100 md-alignment-center-space-around file-store">

              <div class="md-layout-item md-text-alignment-right">
                <template v-if="fileStatus==='none'">
                  <span :style="{color:'#aaa'}">{{ $t("import.no_file_chosen") }}</span>
                </template>
                <template v-if="fileStatus==='downloading'">
                  <md-progress-bar
                      class="md-warning"
                      md-mode="buffer"
                      :md-value="progress.percent"
                  ></md-progress-bar>
                </template>
                <template v-if="fileStatus==='ready'">
                  <span><b>{{ fullFileName }}</b></span>
                </template>
              </div>
              <div class="md-layout-item md-size-5">
                <template v-if="!file">
                  <md-button class="md-primary md-just-icon md-simple" :disabled="!isChooseButtonEnable"
                             @click.prevent.stop="selectFile">
                    <md-icon :style="'font-size: 30px !important;'">
                      note_add
                    </md-icon>
                  </md-button>
                </template>
                <template v-else>
                  <md-button class="md-danger md-just-icon md-simple" :disabled="fileStatus==='downloading'"
                             type="submit"
                             form="importDataa">
                    <md-icon :style="'font-size: 30px !important;'">
                      restore_from_trash
                    </md-icon>
                  </md-button>
                </template>
                <input
                    v-show="false"
                    type="file"
                    id="file"
                    ref="customInput"
                    class="custom-file-input"
                    :accept="allowFileTypes.join(',')"
                    @change="addCustomFiles($event)"
                />
              </div>
            </div>
          </div>

          <md-content></md-content>
          <div class="md-layout md-alignment-bottom-right">
            <md-button class="md-success " :disabled="!file || dataDescription.length===0" @click="sendForm">
              {{ $t("button.import_data") }}
            </md-button>
          </div>

        </md-card-content>
      </md-card>
    </div>
  </form>
</template>

<script>
import Swal from "sweetalert2"

export default {
  name: "rams-import",
  data() {
    return {
      selectedFileType: 'xls',
      progress: {percent: 0},
      allowFileTypes: [
        'application/vnd.ms-excel'
      ],
      dataDescription: "",
      fileTypes: [
        {name: "xls", value: "XLS", allowFileTypes: ['application/vnd.ms-excel']},
        {name: "csv", value: "CSV", allowFileTypes: ['text/csv']}
      ],
      fileStatus: "none",
      file: null
    }
  },
  methods: {
    sendForm() {
      let formData = new FormData()
      formData.append('document', this.file)
      formData.append('data_description', this.dataDescription)

      const alert = {
        type: 'success',
        text: this.$t(`label.record_was_added`),
        footer: ''
      }

      this.$store.dispatch("RAMS_IMPORT", formData).then(
          () => {
            Swal.fire(alert).then(() => {
            })
          },
          () => {
            alert.type = 'error'
            alert.text = this.$t(`label.record_was_not_added`)
            Swal.fire(alert).then(() => {
            })
          }
      )
    },
    selectFile() {
      //evt.preventDefault()
      this.$refs.customInput.click()
    },
    dropFile() {
      this.file = null
    },
    addCustomFiles(evt) {
      this.file = evt.target.files[0]
      this.fileStatus = "ready"
    },
    fileTypeChanged() {
      const selectedFileType = this.selectedFileType
      let allowTypes = this.fileTypes.map(type => type.allowFileTypes)
      const ind = this.fileTypes.findIndex(type => type.name === selectedFileType)
      if (~ind) {
        allowTypes = [...this.fileTypes[ind].allowFileTypes]
      }
      this.allowFileTypes = [...allowTypes]
    }
  },
  computed: {
    fullFileName() {
      let name = ""
      if (this.file) {
        name = `${this.file.name.toUpperCase()} (${(this.file.size / 1024 / 1024).toFixed(2)}Mb)`
      }
      return name
    },
    isChooseButtonEnable() {
      return true //this.data_type && this.data_type !== "" && this.selectedFileType
    }
  }
}
</script>

<style lang="scss" scoped>

.md-progress-bar {
  margin: 24px;
  width: 100%;
}

label {
  color: #aaa;
  font-weight: 400;
  margin-bottom: 0;
  font-size: inherit;
  line-height: 1.5;
  padding: 20px 5px 0 0;
  text-align: right;
}

.md-content {
  height: 10px;
  border-bottom: solid 1px #d2d2d2 !important;
  margin-bottom: 15px;
}

.md-text-alignment-right {
  text-align: right;
  display: flex;
  align-items: center;
}

.radio-store {
  padding-top: 4.5px;
}

.file-store {
  padding-top: 4.5px;
}

.icon-file-manage {
  font-size: 30px !important;
}
</style>
