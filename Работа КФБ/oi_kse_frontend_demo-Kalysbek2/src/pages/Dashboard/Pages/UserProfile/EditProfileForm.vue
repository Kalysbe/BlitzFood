<template>
  <form>
    <md-card>
      <md-card-header
        class="md-card-header-icon"
        :class="getClass(headerColor)"
      >
        <div class="card-icon">
          <md-icon>perm_identity</md-icon>
        </div>
        <h4 class="title">
          Профиль компании
          <small></small>
        </h4>
      </md-card-header>

      <md-card-content>
        <div class="md-layout">
          <div class="md-layout-item md-small-size-100 md-size-100">
            <md-field>
              <label>Имя компании</label>
              <md-input v-model="doc.name"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-40">
            <md-field>
              <label>Организационно-правовая форма</label>
              <md-input v-model="doc.opforma" type="text"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-60">
            <md-field>
              <label>Основной вид деятельности</label>
              <md-input v-model="doc.activity" type="email"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-60">
            <md-field>
              <label>Юридический и почтовый адрес</label>
              <md-input v-model="doc.address" type="text"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-40">
            <md-field>
              <label>Телефон</label>
              <md-input v-model="doc.phone" type="text"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-33">
            <md-field>
              <label>Факс</label>
              <md-input v-model="doc.fax" type="text"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-33">
            <md-field>
              <label>E-mail</label>
              <md-input v-model="doc.email" type="email"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-33">
            <md-field>
              <label>Должность руководителя</label>
              <md-input
                v-model="doc.sepervisor.position"
                type="text"
              ></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-50">
            <md-field>
              <label>ФИО руководителя</label>
              <md-input v-model="doc.sepervisor.dir" type="text"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-50">
            <md-field>
              <label>ФИО главного бухгалтера</label>
              <md-input v-model="doc.sepervisor.buh" type="text"></md-input>
            </md-field>
          </div>

          <div class="md-layout-item md-size-100 text-right">
            <md-button class="md-raised md-primary mt-4" @click="editProfile">
              Обновить
            </md-button>
          </div>
          <div
            class="md-layout-item md-size-100 text-right request"
            v-if="updatedSucces"
          >
            <p>{{ request }}</p>
          </div>
        </div>
      </md-card-content>
    </md-card>
  </form>
</template>
<script>
import { mapActions } from 'vuex'

export default {
  async created() {
    this.doc = await this.GET_COMPANY_DATA()
  },
  name: 'edit-profile-form',
  props: {
    headerColor: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      request: 'Данные успешно обновлены!',
      updatedSucces: false,
      doc: []
    }
  },
  methods: {
    ...mapActions('company', ['GET_COMPANY_DATA', 'EDIT_COMPANY_DATA']),
    getClass: function (headerColor) {
      return 'md-card-header-' + headerColor + ''
    },
    editProfile() {
      let name = this.doc.name
      let opforma = this.doc.opforma
      let activity = this.doc.activity
      let address = this.doc.address
      let phone = this.doc.phone
      let fax = this.doc.fax
      let email = this.doc.email
      let id = this.doc.id
      let supervisor = JSON.stringify(this.doc.sepervisor)
      this.EDIT_COMPANY_DATA({
          name,
          opforma,
          activity,
          address,
          phone,
          fax,
          email,
          supervisor,
          id
        })
        .then((resp) => {
          if (resp === true) {
            this.updatedSucces = true
          }
        })
        .catch((err) => console.log(err))
    }
  }
}
</script>
<style>
.request {
  color: green;
}
</style>
