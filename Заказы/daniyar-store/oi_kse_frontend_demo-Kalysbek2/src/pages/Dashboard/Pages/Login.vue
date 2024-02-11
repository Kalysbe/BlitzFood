<template>
  <div class="md-layout text-center">
    <div class="md-layout-item md-size-33 md-medium-size-50 md-small-size-70 md-xsmall-size-100">
      <login-card header-color="white" style="width:90%;">
        <md-button slot="title" class="md-simple md-white">
          <img src="/logoznachok.png" />
        </md-button>
        //locale
        <!-- <div class="md-group" slot="buttons">
          <md-button
            @click="setLocale('ru')"
            class="md-just-icon md-simple md-white"
          >
            RU
          </md-button>
          <md-button
            @click="setLocale('kg')"
            class="md-just-icon md-simple md-white"
          >
            KG
          </md-button>
        </div> -->
        
        <p slot="description" class="description">{{ $t('pageLogin.labelAuthorization') }}</p>
        <template v-if="!INN">
          <md-field class="md-form-group" slot="inputs">
            <md-icon>account_circle</md-icon>
            <label>{{ $t('pageLogin.labelLogin') }}</label>
            <md-input v-model="username"></md-input>
          </md-field>
          <md-field class="md-form-group" slot="inputs">
            <md-icon>lock_outline</md-icon>
            <label>{{ $t('pageLogin.labelPassword') }}</label>
            <md-input v-model="password" type="password" v-on:keyup.enter="onEnter"></md-input>
          </md-field>
          <p class="request" slot="inputs" v-if="isHidden">
            {{ $t('pageLogin.errorAuthorization') }}
            {{ request }}
          </p>
          <md-button slot="footer" class="md-simple md-info md-lg" @click="handleLogin" onkeypress="clickPress(event)">
            {{ $t('loginButton') }}
          </md-button>
        </template>
        <template v-else-if="INN">
          <md-field class="md-form-group" slot="inputs">
            <md-icon>fingerprint</md-icon>
            <label>ИНН</label>
            <md-input v-model="inn"></md-input>
          </md-field>
          <md-button slot="footer" class="md-simple md-info md-lg" @click="loginWithINN">
            ИНН
          </md-button>
        </template>
         <button slot="inputs" class="select-login md-simple md-info md-lg" @click="selectLogin">{{selectText}}</button>
      </login-card>
    </div>
  </div>
</template>
<script>
import { LoginCard } from '@/components'
import Swal from 'sweetalert2'
import { mapActions } from 'vuex'
export default {
  components: {
    LoginCard
  },
  data() {
    return {
      isHidden: false,
      request: '',
      username: '',
      password: '',
      inn: '',
      withSetValue: null,
      selectText:'Войти с ИНН',
      INN:false
    }
  },
  methods: {
    ...mapActions('auth', ['LOGIN', 'LOGINWITHINN', 'CHECKPIN']),
    handleLogin() {
      let login = this.username
      let password = this.password
      this.LOGIN({ login, password })
        .then((resp) => {
          if (resp === true) {
            this.$router.push('/' + this.$i18n.locale + '/dashboard/home')
            Swal.fire({
              html: `
                <div>
                  <i 
                  class="md-size-3x md-icon md-icon-font md-theme-default"
                  
                  >
                  warning
                  </i>
                  <h5> <strong><span>ВНИМАНИЕ!</span> Уважаемые пользователи Open Information System.</strong></h5>
                  <p>Отправка отчетов и информации о существенных фактах на биржу через программу возможна только с использованием облачной электронно-цифровой подписи (ЭЦП), 
                  получить которую можно в Центрах обслуживания населения (ЦОН).</p>
                  <p>Список документов для получения ЭЦП на юридическое лицо доступен по 
                  <strong> <a href="https://infocom.kg/ru/pki/entity/" target="_blank">ссылке</a></strong></p>
                  
                </div>
              `,
              // html:'<div><h5>Уважаемые пользователи Open Information System. ЗАО "Кыргызская фондовая биржа" информирует Вас о том, что с 1 июля 2021г. прием и отправка информации будет производится с использованием облачной электронно-цифровой подписи (ЭЦП).В соответствии с Законом Кыргызской Республики «О цифровой подписи» электронная подпись выступает полноценной заменой рукописной подписи, и имеет полную юридическую силу. Информация в электронной форме, подписанная электронной подписью, признается электронным документом, равнозначным документу на бумажном носителе, подписанному собственноручной подписью.Выдача облачных ЭЦП осуществляется в Центрах обслуживания населения (ЦОН), список документов для получения облачной ЭЦП для юридического лица Вы можете найти по ссылке:</h5><a href="https://infocom.kg/ru/pki/entity/" target="_blank">https://infocom.kg/ru/pki/entity/</a></div>',
              // text:
              //   'https://infocom.kg/ru/pki/entity/',

              showCancelButton: false,
              customClass: 'oi_alert',
              cancelButtonClass: 'md-button md-success',
              cancelButtonText: 'Закрыть',
            })
          } else {
            this.request = resp
            this.isHidden = true
          }
        })
        .catch((err) => console.log(err))
    },
    loginWithINN() {
      Swal.fire({
        title: '',
        text: `Авторизоваться с помощью введенным ИНН?`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'md-button md-success',
        cancelButtonClass: 'md-button md-danger',
        cancelButtonText: 'Закрыть',
        confirmButtonText: 'Да!',
        buttonsStyling: false
      }).then((result) => {
        if (result.value) {
          this.LOGINWITHINN(this.inn)
            .then((response) => {
              if (
                response.request.status === 200
              ) {
                Swal.fire({
                  title: 'Введите Пин код!',
                  html:
                    `<div><h4>` +
                    response.data.message +
                    `</h4></div><div class="md-field md-theme-default"> 
                       <input type="number" required id="md-input" class="md-input"></div>`,
                  preConfirm: () => {
                    return [document.getElementById('md-input').value]
                  },
                  showCancelButton: true,
                  confirmButtonClass: 'md-button md-success',
                  cancelButtonClass: 'md-button md-danger',
                  cancelButtonText: 'Закрыть',
                  buttonsStyling: false,
                  allowOutsideClick: false
                }).then((res) => {
                  this.CHECKPIN({pin: res.value[0], inn: this.inn})
                    .then((resp) => {
                      if (resp === true) {
                        this.$router.push('/' + this.$i18n.locale + '/dashboard/home')
                      } else {
                        this.request = resp
                        this.isHidden = true
                      }
                      console.log('resp = ', resp)
                    })
                })
              }
            })
        }
      })
      
    },
    setLocale(locale) {
      this.$i18n.locale = locale
    },
    onEnter(event) {
      this.handleLogin()
    },
     selectLogin() {
      this.INN = !this.INN
      if(!this.INN) {
        this.selectText = "Войти через ИНН"
      } else {
        this.selectText = "Войти через Логин и Пароль"
      }
    }
  }
}
</script>

<style>
.request {
  color: darkred;
  margin-bottom: -25px;
}

.oi_alert {
  width: 60% !important;
  color: #155724;
  background-color: #d4edda;
}

.oi_alert span {
  color: #856404;
}
.select-login {
  cursor: pointer;
  margin: 0 5px;
  color:#6D767E;
  border:none;
  background: none;
  font-size: 16px;
  padding: 5px 10px;
}
</style>