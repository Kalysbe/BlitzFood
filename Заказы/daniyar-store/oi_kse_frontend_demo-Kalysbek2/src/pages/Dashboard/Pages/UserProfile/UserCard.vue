<template>
  <div>
    <form>
      <md-card>
        <md-card-header class="md-card-header-icon md-card-header-blue">
          <div class="card-icon">
            <md-icon>settings</md-icon>
          </div>
          <h4 class="title">Cменить пароль</h4>
        </md-card-header>
        <md-card-content>
          <md-field
            :class="[
              { 'md-valid': !errors.has('password') && touched.password },
              { 'md-error': errors.has('password') },
            ]"
          >
            <label>Новый пароль</label>
            <md-input
              v-model="password"
              data-vv-name="password"
              type="password"
              ref="password"
              required
              v-validate="modelValidations.password"
            >
            </md-input>
            <slide-y-down-transition>
              <md-icon class="error" v-show="errors.has('password')"
                >close</md-icon
              >
            </slide-y-down-transition>
            <slide-y-down-transition>
              <md-icon
                class="success"
                v-show="!errors.has('password') && touched.password"
                >done</md-icon
              >
            </slide-y-down-transition>
          </md-field>
          <md-field
            :class="[
              {
                'md-valid':
                  !errors.has('confirmPassword') && touched.confirmPass,
              },
              { 'md-error': errors.has('confirmPassword') },
            ]"
          >
            <label>Подтверждение пароля</label>
            <md-input
              v-model="confirmPassword"
              data-vv-name="confirmPassword"
              data-vv-as="password"
              type="password"
              required
              v-validate="modelValidations.confirmPassword"
            >
            </md-input>
            <slide-y-down-transition>
              <md-icon class="error" v-show="errors.has('confirmPassword')"
                >close</md-icon
              >
            </slide-y-down-transition>
            <slide-y-down-transition>
              <md-icon
                class="success"
                v-show="
                  !errors.has('confirmPassword') && touched.confirmPassword
                "
                >done</md-icon
              >
            </slide-y-down-transition>
          </md-field>
        </md-card-content>

        <md-card-actions md-alignment="space-between">
          <md-button
            native-type="submit"
            @click.native.prevent="validate"
            class="md-primary"
            >Сохранить</md-button
          >
        </md-card-actions>
      </md-card>
    </form>
  </div>
</template>
<script>
import { SlideYDownTransition } from "vue2-transitions";
export default {
  components: { SlideYDownTransition },
  name: "user-card",
  props: {
    cardUserImage: {
      type: String,
      default: "/img/default-user-img.png",
    },
    buttonColor: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      updatePassBlock: false,
      boolean: null,
      email: "",
      password: "",
      confirmPassword: "",
      touched: {
        password: false,
        confirmPass: false,
      },
      modelValidations: {
        password: {
          required: true,
          min: 5,
        },
        confirmPassword: {
          required: true,
          confirmed: "password",
        },
      },
    };
  },
  methods: {
    getColorButton: function (buttonColor) {
      return "md-" + buttonColor + "";
    },
    updatePassHandle: function (buttonColor) {
      this.updatePassBlock = true;
    },
    validate() {
      this.$validator.validateAll().then((isValid) => {
        // this.$emit("on-submit", this.registerForm, isValid);
      });
    },
  },
  watch: {
    password() {
      this.touched.password = true;
    },
    confirmPassword() {
      this.touched.confirmPass = true;
    },
  },
};
</script>
<style lang="scss" scoped>
.md-card .md-card-actions {
  border: none;
   margin-left: auto;
  
}

</style>
