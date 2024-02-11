<template>
  <div class="md-layout">
    <div class="md-layout-item">
      <form>
        <md-card>
          <md-card-header
            class="md-card-header-icon"
            :class="getClass(headerColor)"
          >
            <div class="card-icon">
              <md-icon>translate</md-icon>
            </div>
            <h4 class="title">
              {{ $t(`translate.${oper}`) }}
              <small></small>
            </h4>
          </md-card-header>
          <md-card-content>
            <div class="md-layout md-size-50">
              <div class="md-layout-item md-small-size-100 md-size-50">
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field
                    v-for="field in fields"
                    :key="field"
                    :class="[
                      {'md-valid': !errors.has(field) && touched[field]},
                      {'md-error': errors.has(field)}
                    ]"
                  >
                    <label>
                      {{ $t(`translate.${field}`) }}
                    </label>
                    <md-input
                      v-model="tr[field]"
                      :type="`${field}`"
                      :data-vv-name="`${field}`"
                      v-validate="modelValidations[field]"
                      @input="onFieldChange(field)"
                    ></md-input>
                    <slide-y-down-transition>
                      <md-icon class="error" v-show="errors.has(field)">
                        close
                      </md-icon>
                    </slide-y-down-transition>
                    <slide-y-down-transition>
                      <md-icon
                        class="success"
                        v-show="!errors.has(field) && touched[field]"
                      >
                        done
                      </md-icon>
                    </slide-y-down-transition>
                  </md-field>
                </div>
              </div>
              <div class="md-layout-item md-size-100 text-right">
                <md-button
                  class="md-success"
                  native-type="submit"
                  @click.native.prevent="validate"
                >
                  {{ $t('button.save') }}
                </md-button>
                <md-button class="md-accent" @click.stop.prevent="onCancel">
                  {{ $t('button.close') }}
                </md-button>
              </div>
            </div>
          </md-card-content>
        </md-card>
      </form>
    </div>
  </div>
</template>
<script>
import {mapState} from 'vuex'
import {SlideYDownTransition} from 'vue2-transitions'
import Swal from 'sweetalert2'

export default {
  name: 'edit-profile-form',
  props: {
    headerColor: {
      type: String,
      default: ''
    },
    oper: String
  },
  components: {
    SlideYDownTransition
  },
  created() {
    this.locales.forEach((locale) => {
      this.tr[locale.code] = null
      this.touched[locale.code] = false
      this.modelValidations[locale.code] = {
        required: true,
        min: 2
      }
    })
  },
  data() {
    return {
      pid: null,
      tr: {category: null, key: null},
      touched: {
        category: false,
        key: false
      },
      modelValidations: {
        category: {
          required: true,
          min: 3
        },
        key: {
          required: true,
          min: 3
        }
      }
    }
  },
  methods: {
    onFieldChange(field) {
      this.touched[field] = true
    },
    onCancel() {
      this.$router.push('/localisation')
    },
    getClass: function(headerColor) {
      return 'md-card-header-' + headerColor + ''
    },
    async validate() {
      this.$validator.validateAll().then((isValid) => {
        if (isValid) {
          const translate = {...this.tr}
          const alert = {
            type: 'success',
            text: this.$t(`translate.key_was_${this.oper}ed`, {
              category: this.category
            }),
            footer: ''
          }

          const reqData = translate
          this.$store.dispatch(`ADD_TRANSLATE_ENTRY`, reqData).then(
            () => {
              Swal.fire(alert).then(() => {
                this.touched.category = false
                this.$nextTick(() => this.$validator.reset())
              })
            },
            (err) => {
              alert.type = 'error'
              alert.text = this.$t(`translate.key_was_not_${this.oper}ed`, {
                category: this.category
              })
              alert.footer = this.$t(err)
              Swal.fire(alert)
            }
          )
        }
      })
    }
  },
  watch: {},

  computed: {
    ...mapState({
      locales: (state) => state.i18nStore.locales
    }),
    fields() {
      const localesCodes = this.locales.map((locale) => locale.code)
      return ['category', 'key', ...localesCodes]
    }
  }
}
</script>
<style>
.md-button + .md-button {
  margin-left: 10px;
}
</style>
