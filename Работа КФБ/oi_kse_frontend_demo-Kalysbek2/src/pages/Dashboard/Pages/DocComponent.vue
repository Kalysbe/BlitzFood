<template>
  <div v-if="ViewType">
    <div class="section-document toggle-section">
      <div width="100%" style="width: 100%">
        <a data-toggle="collapse" :aria-expanded="!isClosedDocument" @click.stop="toggleDocument"
          @click.capture="clicked">
          <span style="
                    width: 100%;
                    display: flex;
                    justify-content: space-between;
                    cursor: pointer;
                  ">
            <h3>Заполнить в ручную</h3>
            <h3 style="border: 1px solid #49b9c4; border-radius: 100%">
              <md-icon class="caret material-icons" style="width: 40px; height: 40px; color: #49b9c4">
                keyboard_arrow_down
              </md-icon>
            </h3>
          </span>
        </a>
        <collapse-transition>
          <div v-show="!isClosedDocument">
            <ReportView :id="id" :mode="mode" :selectView="true" ></ReportView>
          </div>
        </collapse-transition>
      </div>
    </div>
    <div class="section-document toggle-section">
      <div width="100%" style="width: 100%">
        <a data-toggle="collapse" :aria-expanded="!isClosedDocument2" @click.stop="toggleDocument2"
          @click.capture="clicked">
          <span style="
                    width: 100%;
                    display: flex;
                    justify-content: space-between;
                    cursor: pointer;
                  ">
            <h3>Загрузить файл
            </h3>
            <h3 style="border: 1px solid #49b9c4; border-radius: 100%">
              <md-icon class="caret material-icons" style="width: 40px; height: 40px; color: #49b9c4">
                keyboard_arrow_down
              </md-icon>
            </h3>
          </span>
        </a>
        <collapse-transition>
          <div v-show="!isClosedDocument2">
            <upload-file :document="DocType"></upload-file>
          </div>
        </collapse-transition>
      </div>
    </div>
  </div>
  <div v-else>
    <ReportView :id="id" :mode="mode"></ReportView>
  </div>
</template>
<script>
import ReportView from '../Components/ReportView.vue'
import { CollapseTransition } from 'vue2-transitions'
import UploadFile from './UploadFile.vue'
import { mapGetters } from 'vuex'
export default {
  components: {
    ReportView,
    CollapseTransition,
    UploadFile
  },
  computed: {
    ...mapGetters('documents', ['getTitle']),
    ViewType() {
      let id = this.id
      if (id == 'anex_2_1' || id == 'anex_1' || id == 'anex_2')
        return true
      return false
    },
    DocType() {
      return [
         {id: 10, title: this.getTitle, value: null, type: this.id}
      ]
    }
  },
  data() {
    return {
      id: this.$route.params.id,
      mode: this.$route.params.mode,
      expandSingle: false,
      isClosedDocument: true,
      expandSingle2: false,
      isClosedDocument2: true,
    }
  },
  methods: {
    clicked: function (e) {
      e.preventDefault()
    },
    toggleDocument: function () {
      this.isClosedDocument = !this.isClosedDocument
    },
    toggleDocument2: function () {
      this.isClosedDocument2 = !this.isClosedDocument2
    }
  }

}
</script>
<style lang="scss" scoped>
.section-document {
  padding: 15px;
  background: #f1f5f5;
  border-bottom: 1px solid;
}
</style>