<template>
   <md-snackbar
      md-position="center"
      :md-active="getShowSnackbarUPE"
      md-persistent
    >
      <span>ИНН обновлен</span>
    </md-snackbar>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
  computed: {
      ...mapGetters('auth', ['getShowSnackbarUPE']),
  }
}
</script>

<style>

</style>