<template>
  <div class="md-layout text-center">
    <div
      class="md-layout-item md-size-33 md-medium-size-50 md-small-size-70 md-xsmall-size-100"
    >
      <login-card header-color="danger ">
        <h3 slot="title" class="title">{{ $t('label.app_title') }}</h3>
        <p slot="description" class="description">{{ $t('login.title') }}</p>

        <div
          slot="lang-name"
          v-for="(lang, index) in locales"
          :key="lang.code"
          class="lang-name-box"
        >
          <span
            class="lang-name"
            @click="onLangChange(lang.code)"
            :class="{
              'lang-name-active': lang.code === active_locale,
              'lang-div': index !== 0
            }"
          >
            {{ lang.code }}
          </span>
        </div>


        <form slot="form" id="login_form" @submit.prevent="validate">
          <md-field
            class="md-form-group"
            slot="inputs"
            :class="[
              {'md-valid': !errors.has('login') && touched.login},
              {'md-error': errors.has('login')}
            ]"
          >
            <md-icon>face</md-icon>
            <label>{{ $t('login.user_login') }}</label>
            <md-input
              v-model="login"
              data-vv-name="login"
              type="login"
              required
              v-validate="modelValidations.login"
            ></md-input>
            <slide-y-down-transition>
              <md-icon class="error" v-show="errors.has('login')">
                close
              </md-icon>
            </slide-y-down-transition>
            <slide-y-down-transition>
              <md-icon
                class="success"
                v-show="!errors.has('login') && touched.login"
              >
                done
              </md-icon>
            </slide-y-down-transition>
          </md-field>
          <md-field
            class="md-form-group"
            slot="inputs"
            :class="[
              {'md-error': errors.has('password')},
              {'md-valid': !errors.has('password') && touched.password}
            ]"
          >
            <md-icon>lock</md-icon>
            <label>{{ $t('login.user_password') }}</label>
            <md-input
              v-model="password"
              data-vv-name="password"
              type="password"
              required
              v-validate="modelValidations.password"
              autocomplete="on"
            ></md-input>
            <slide-y-down-transition>
              <md-icon class="error" v-show="errors.has('password')">
                close
              </md-icon>
            </slide-y-down-transition>
            <slide-y-down-transition>
              <md-icon
                class="success"
                v-show="!errors.has('password') && touched.password"
              >
                done
              </md-icon>
            </slide-y-down-transition>
          </md-field>
          <div class="md-error">{{ errMessage }}</div>
          <div class="md-layout">
            <div class="md-layout-item">
              <md-button
                slot="footer"
                class="md-simple md-success md-lg"
                type="submit"
                form="login_form"
              >
                {{ $t('login.enter') }}
              </md-button>
            </div>
          </div>
          <a href @click.stop.prevent="onPassModalShow" class="md-caption">
            {{ $t('label.lnkPassRec') }}
          </a>
        </form>
      </login-card>
    </div>
    <modal
      v-if="passwdModalShow"
      @close="passwdModalHide"
      class="small-alert-modal"
    >
      <template slot="header">
        <h4 class="modal-title">{{ $t('label.lnkPassRec') }}</h4>
        <md-button
          class="md-simple md-just-icon md-round modal-default-button"
          @click="passwdModalHide"
        >
          <md-icon>clear</md-icon>
        </md-button>
      </template>

      <template slot="body">
        <p>{{ $t('info.forgot_pass_descr') }}</p>
        <md-field
          :class="[
            {'md-valid': !errors.has('reqEmail') && touched.reqEmail},
            {'md-error': errors.has('reqEmail')}
          ]"
        >
          <label>{{ $t('label.email') }}</label>
          <md-input
            v-model="reqEmail"
            data-vv-name="reqEmail"
            type="email"
            required
            v-validate="modelValidations.reqEmail"
          ></md-input>
          <slide-y-down-transition>
            <md-icon class="error" v-show="errors.has('reqEmail')">
              close
            </md-icon>
          </slide-y-down-transition>
          <slide-y-down-transition>
            <md-icon
              class="success"
              v-show="!errors.has('reqEmail') && touched.reqEmail"
            >
              done
            </md-icon>
          </slide-y-down-transition>
        </md-field>
      </template>

      <template slot="footer">
        <md-button class="md-success" @click="onReqPassRecovery">
          {{ $t('button.send') }}
        </md-button>
      </template>
    </modal>
  </div>
</template>
<script>
import {LoginCard, Modal} from '@/components'
import {SlideYDownTransition} from 'vue2-transitions'
import {mapGetters, mapState} from 'vuex'
export default {
  components: {
    LoginCard,
    Modal,
    SlideYDownTransition
  },
  watch: {
    email() {
      this.touched.email = true
    },
    password() {
      this.touched.password = true
    },
    reqEmail() {
      this.touched.reqEmail = true
    }
  },
  data() {
    return {
      login: null,
      password: null,
      passwdModalShow: false,
      reqEmail: '',
      errMessage: '',
      touched: {
        login: false,
        password: false,
        reqEmail: false
      },
      modelValidations: {
        login: {
          required: true
          //email: true
        },
        reqEmail: {
          required: true,
          email: true
        },
        password: {
          required: true,
          min: 5
        }
      }
    }
  },
  methods: {
    validate() {
      this.$validator.validateAll().then((isValid) => {
        if (isValid) {
          this.onEnter()
        }
        //this.$emit('on-submit', this.registerForm, isValid)
      })

      this.touched.login = true
      this.touched.password = true
    },
    onEnter() {
      this.errMessage = ''
      const {login, password} = this
      this.$store.dispatch('LOGIN', {login, password}).then(() => {
        if (this.authStatus === 'success') {
          const path = this.pathAfterLogin ? this.pathAfterLogin : '/dashboard'
          this.$store.commit('SET_REDIRECT_AFTER_LOGIN', '')
          this.$router.push(path)
        } else if (this.authStatus === 'error') {
          this.errMessage = this.$t('info.auth_error')
          this.password = ''
        }
      })
    },
    async onLangChange(code) {
      if (!this.isLangLoginMessagesExist(code)) {
        await this.$store.dispatch('LOAD_LOGIN_TRANSLATE', code)
      }
      this.$store.commit('CHANGE_LANG', code)
    },
    passwdModalHide() {
      this.passwdModalShow = false
    },
    onPassModalShow() {
      this.passwdModalShow = true
    },
    onReqPassRecovery() {
      this.$validator.validate('reqEmail').then((isValid) => {
        if (isValid) {
          this.passwdModalHide()
        }
      })

      this.touched.reqEmail = true

      if (!this.reqEmail) {
        return
      }
    }
  },
  computed: {
    ...mapState({
      authStatus: (state) => state.Login.authStatus,
      active_locale: (state) => state.i18nStore.active,
      locales: (state) =>
        state.i18nStore.locales.sort((a, b) => a.index - b.index),
      pathAfterLogin: (state) => state.Login.pathAfterLogin
    }),
    ...mapGetters({
      isLangLoginMessagesExist: 'isLangLoginMessagesExist'
    })
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/md/_variables.scss';
.md-error {
  color: $brand-danger;
  //margin-bottom: 5px;
  min-height: 30px;
}
.lang-name-box {
  min-width: 45px;
  text-align: center;
  .lang-name {
    padding: 0 10px;
    font-size: 2em;
    color: $grey-400;
    cursor: pointer;
    &:hover {
      color: $brand-danger;
    }
  }
  .lang-div {
    border-left: 1px solid $grey-200;
  }
  .lang-name-active {
    color: $brand-success;
    &:hover {
      color: $brand-success;
    }
  }
}
</style>
