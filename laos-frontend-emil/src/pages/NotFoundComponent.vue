<template>
  <div class="main-area">
    <div>
      <md-icon class="md-size-2x">warning</md-icon>
      <span>
        {{ $t("message.sorry_page_not_found") }}
      </span>
    </div>
    <div>
      <a href="#" @click="onReturn">{{ $t("message.go_to_default_page") }}</a>
    </div>
  </div>
</template>
<script>
export default {
  name: 'under-construction',
  methods: {
    onReturn() {
      this.$router.push("/")
    }
  }
}
</script>

<style lang="scss" scoped>
.main-area {
  display: flex;
  justify-content: center;
  margin: auto;
  width: 100%;
  align-items: center;
  top: 40%;
  position: absolute;
  flex-direction: column;

  div {
    text-align: center;
    display: flex;
    align-items: center;
  }

  span {
    padding: 0 5px;
    font-size: 2rem;
    color: red;
  }
}

</style>
