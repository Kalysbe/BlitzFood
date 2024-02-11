<template>
  <div>
      <ul>
            <li class="md-list-item">
                <a
                  href="javascript:void(0)"
                  class="dropdown">
                  <div class="md-list-item-content">
                    <drop-down direction="down">
                      <div
                        slot="title"
                        data-toggle="dropdown"
                        style="display:flex;">
                        <md-icon>language</md-icon>
                          {{$i18n.locale}}
                          <md-icon class="caret material-icons">keyboard_arrow_down</md-icon>
                      </div>
                      <ul class="dropdown-menu dropdown-menu-right select-language-list">
                          <li @click="setLocale('ru')">
                            RU
                          </li>
                          <li @click="setLocale('kg')">
                      
                            KG
                          </li>
                            <li @click="setLocale('eng')">
          
                              ENG
                          </li>
                      </ul>
                    </drop-down>
                  </div>
                </a>
              </li>
      </ul>

  </div>
</template>

<script>

export default {
  methods: {
    setLocale(locale) {
      this.$i18n.locale = locale
      this.$router.push({
        params: { lang: locale }
      })
    }

  }
}
</script>

<style scoped>
.dropdown-menu-right {
  margin: 0px;
  padding: 0px;
}
.dropdown-menu {
  min-width: 100px;
}
.dropdown-menu-right li {
  margin: 0px;
}
.select-language-list {

  width: 10px;
}
.select-language-list li:hover {
  background: #78c3cc;
  color:white;
  cursor: pointer;
}
</style>
