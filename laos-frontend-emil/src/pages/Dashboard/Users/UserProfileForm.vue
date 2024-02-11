<template>
  <div class='md-layout'>
    <div class='md-layout-item'>
      <form>
        <md-card>
          <md-card-header
            :class='getClass(headerColor)'
            class='md-card-header-icon'
          >
            <div class='card-icon'>
              <md-icon>person_outline</md-icon>
            </div>
            <h4 class='title'>
              {{ $t(`user.properties`) }}
              <small></small>
            </h4>
          </md-card-header>
          <md-card-content>
            <div class='md-layout md-size-50'>
              <div class='md-layout-item md-small-size-100 md-size-50'>
                <div class='md-layout-item md-small-size-100 md-size-50'>
                  <template v-for='field in fields'>
                    <md-field
                      v-if='act!=="upd" || field!=="login"'
                      :key='field'
                      :class="[
                      {'md-valid': !errors.has(field) && touched[field]},
                      {'md-error': errors.has(field)}
                    ]"
                    >

                      <label>
                        {{ $t(`user.${field}`) }}
                      </label>
                      <md-input
                        v-model='userProps[field]'
                        v-validate='modelValidations[field]'
                        :data-vv-name='`${field}`'
                        :type='`${field}`'
                        @input='onFieldChange(field)'
                      ></md-input>
                      <slide-y-down-transition>
                        <md-icon v-show='errors.has(field)' class='error'>
                          close
                        </md-icon>
                      </slide-y-down-transition>
                      <slide-y-down-transition>
                        <md-icon
                          v-show='!errors.has(field) && touched[field]'
                          class='success'
                        >
                          done
                        </md-icon>
                      </slide-y-down-transition>

                    </md-field>
                  </template>
                  <md-field>

                    <label>
                      {{ $t(`user.role`) }}
                    </label>
                    <md-select
                      v-model='userProps.role_id'
                    >
                      <md-option v-for='role in roles' :key='role.id' :value='role.id'>
                        {{ $t(`role.name_${role.role_name}`) }}
                      </md-option>
                    </md-select>
                    <slide-y-down-transition>
                      <md-icon v-show="errors.has('inspectorName')" class='error'>close</md-icon>
                    </slide-y-down-transition>
                  </md-field>
                </div>
              </div>
              <div class='md-layout-item md-size-100 text-right'>
                <md-button
                  :disabled='nothingSave'
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
    act: String

  },
  components: {
    SlideYDownTransition
  },
  created() {
    if (this.act === 'upd') {
      this.$store.dispatch('LOAD_USER_BY_LOGIN', this.userLogin).then(user => {
        this.userProps = {...user}
      })
    }
    this.$store.dispatch('LOAD_ROLES').then(roles => {
      this.roles = [...roles]
      if (this.act === 'new') {
        this.userProps.role_id = roles[0].id
      }
    })
  },
  data() {
    return {
      userLogin: this.$route.params.login,
      userProps: {},
      roles: [],
      nothingSave: true,
      touched: {
        login: false,
        email: false,
        last_name: false,
        first_name: false
      },
      modelValidations: {
        login: {
          required: true,
          min: 5
        },
        email: {
          required: true,
          email: true
        }
      }
    }
  },
  methods: {
    onFieldChange(field) {
      this.nothingSave = false
      this.touched[field] = true
    },
    onCancel() {
      this.$router.go(-1)
    },
    getClass: function(headerColor) {
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
          text: this.$t(`user.user_was_${operType}ed`),
          footer: ''
        }
        try {
          if (this.act === 'new') {
            await this.$store.dispatch('ADD_USER', {...this.userProps})
          } else if (this.act === 'upd') {
            const {login, ...data} = this.userProps
            await this.$store.dispatch('UPD_USER', {login: login, data})
          } else {
            throw `bad operation type`
          }

          this.nothingSave = true
          Swal.fire(alert).then(() => {
            this.$nextTick(() => this.$validator.reset())
          })

        } catch (err) {
          //console.log(err, this.act)
          alert.type = 'error'
          alert.text = this.$t(`user.user_was_not_${operType}`)
          alert.footer = this.$t(err.message ? err.message : err)
          Swal.fire(alert)
        }
      }
    }
  },
  watch: {},

  computed: {
    ...mapState({}),
    fields() {
      return ['login', 'email', 'first_name', 'last_name']
    }
  }
}
</script>
<style>
.md-button + .md-button {
  margin-left: 10px;
}
</style>
