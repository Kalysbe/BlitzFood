<template>
  <div class="md-layout">
    <div class="md-layout-item">
      <md-card>
        <md-card-header class="md-card-header-icon md-card-header-primary">
          <div class="card-icon">
            <md-icon>image </md-icon>
          </div>
          <h4 class="title">Новости</h4>
        </md-card-header>
        <md-card-content>
          <md-table style="width: 100%; margin-top: 50px">
            <md-table-row v-for="img in slideImage" :key="img.id">
              <md-table-cell>
                <img
                  :src="
                    'http://localhost:8088/api/' + img.dataslide.image.file"
                  alt=""
                  style="margin-bottom: 20px; height: 100px; width: 30%"
                />
              </md-table-cell>
              <md-table-cell>
                <button class="removeSlideBtn" @click="removeSlide(img.id)">
                  Удалить
                </button>
              </md-table-cell>
            </md-table-row>
          </md-table>
        </md-card-content>
      </md-card>
      <div style="text-align: center">
          <a
                data-toggle="collapse"
                :aria-expanded="!isClosedNewSlide"
                @click.stop="toggleNewSlide"
                @click.capture="clicked"
              >
        <button class="toggleButton">
          Добавить новый слайд
            <md-icon
                      class="caret material-icons">keyboard_arrow_down
            </md-icon>
        </button>
          </a>
        <collapse-transition>
          <div v-show="!isClosedNewSlide">
              <md-table class="templateAddSlide">
                <md-table-row v-for="doc in docs" :key="doc.id" v-show="doc.type == 'image' || typeNews == 'doc'">
                <md-table-cell width="50%" class="md-title"> <b> {{ doc.title }} </b></md-table-cell>
                <md-table-cell width="50%">
                <input
                id="file-upload"
                :type="doc.type == 'image' || doc.type == 'doc' ? 'file' : 'text'"
                @change="uploadFile(doc)"
                :ref="doc.type"
                :accept="doc.type == 'image' ? '.jpg,.jpeg,.gif,.png' : '' "
              />
            </md-table-cell>
          </md-table-row>
          <md-table-row v-show="typeNews == 'link'">
            <md-table-cell width="50%"><b>Ссылка на новость</b></md-table-cell>
            <md-table-cell>
                <input type="text" placeholder="Введите ссылку" v-model="link" class="linkNews">
            </md-table-cell>
          </md-table-row>
          <md-table-row>
               <md-radio v-model="typeNews" value="link">Указать ссылку</md-radio>
               <md-radio v-model="typeNews" value="doc" class="md-primary">Загрузить файл</md-radio>
          </md-table-row>
        </md-table>
              <md-button class="md-primary" @click="sendFile">
                  Сохранить
              </md-button>
          </div>
        </collapse-transition>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from 'sweetalert2'
import {mapActions, mapGetters} from 'vuex'
import {CollapseTransition} from 'vue2-transitions'
export default {
  components: {
        CollapseTransition
  },
  data: () => ({
    url_api: process.env,
    placeholder: [],
    slideImage: [],
    isClosedNewSlide:true,
    typeNews:'doc',
    link:'',
    docs: [
      {id: 1, title: 'Основное изображение', value: null, type: 'image'},
      {id: 2, title: 'Загрузка файла', value: null, type: 'doc'},
    ]
  }),
  methods: {
    ...mapActions('company', [
      'GET_SLIDER_IMAGE',
      'addNewSlide',
      'DELETE_SLIDE_IMAGE'
    ]),
    async updatePage() {
         Swal.fire({
              title: 'Добавлен!',
              text: 'Ваш слайд успешно добавлен!',
              type: 'success',
              confirmButtonClass: 'md-button md-success',
              buttonsStyling: false
            }).then(() => {
                   location.reload()
            })
    
    },
    uploadFile({type}) {
      for (let i = 0; i < this.docs.length; i++) {
        if (this.docs[i].type == type) {
          this.docs[i].value = this.$refs[type][0].files[0]
        }
        else {
        
        }
      }
    },
    async sendFile() {
      if(this.docs[0].value) {
      const formData = new FormData()
      for (let i = 0; i < this.docs.length; i++) {
        if (this.docs[i].value != null) {
          formData.append(this.docs[i].type, this.docs[i].value)
          formData.append(this.docs[i].type, this.docs[i].title)
        }
      }
      formData.append('link', this.link)
      const res = await this.addNewSlide(formData)
      if(res.status === 200) {
          this.updatePage()
      } else {
        Swal.fire({
                title: `Ошибка при добавлении`,
                type: 'error',
                buttonsStyling: false,
                confirmButtonClass: 'md-button md-error'
                })
      }
  
        } else {
          Swal.fire({
                title: `Заполните все поля!`,
                type: 'warning',
                buttonsStyling: false,
                confirmButtonClass: 'md-button md-success'
          })
        }
    },
    removeSlide(id) {
      Swal.fire({
        title: '',
        text: `Вы уверены, что хотите удалить? После удаления невозможно будет восстановить документ!`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'md-button md-success',
        cancelButtonClass: 'md-button md-danger',
        cancelButtonText: 'Закрыть',
        confirmButtonText: 'Да, удалить!',
        buttonsStyling: false
      }).then((result) => {
        if (result.value) {
          if (this.DELETE_SLIDE_IMAGE(id)) {
            let index = this.slideImage.findIndex((el) => el.id === id)
            this.slideImage.splice(index, 1)
            Swal.fire({
              title: 'Удален!',
              text: 'Ваш документ был  успешно удален!',
              type: 'success',
              confirmButtonClass: 'md-button md-success',
              buttonsStyling: false
            })
          }
        }
      })
    },
    clicked: function (e) {
      e.preventDefault()
    },
    toggleNewSlide: function () {
      this.isClosedNewSlide = !this.isClosedNewSlide
    }
  },
  async mounted() {
    this.res = await this.GET_SLIDER_IMAGE()
    this.slideImage = this.res.data
  },

  
}
</script>
<style lang="css" scoped>
.md-card .md-card-actions {
  border: 0;
  margin-left: 20px;
  margin-right: 20px;
}
.removeSlideBtn {
  background: #d33;
  color: white;
  border: none;
  border-radius: 10px;
  padding: 5px 15px;
  cursor: pointer;
  font-weight: bold;
}
.removeSlideBtn:hover {
  background: rgb(201, 24, 24);
}
.toggleButton {
color:#49b9c4;
border-radius: 20px;
border:#49b9c4 solid 0.5px;
font-size: 16px;
cursor:pointer;
margin-bottom:35px;
}
.toggleButton .md-icon {
  width: 40px; height: 40px; color: #49b9c4
}
.templateAddSlide {
  width: 90%;
  margin:0 auto 0 auto;
}
.linkNews {
  border-radius: 5px;
  padding: 5px 10px;
  font-size: 14px;

}
</style>