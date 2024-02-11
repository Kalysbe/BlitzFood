<template>
  <md-list class="md-triple-line my-archive-list">
    <div v-for="file in files">
    <md-list-item >
      <md-icon>file_present</md-icon>

      <div class="md-list-item-text">
        <span>{{file.name}}</span>
        <span>{{file.date}}</span>
        <p>{{file.description}}</p>
      </div>

      <md-button class="md-just-icon md-list-action md-simple">
        <md-icon>more_vert</md-icon>
      </md-button>
    </md-list-item>

    <md-divider class="md-inset"></md-divider>
    </div>
  </md-list>

</template>

<script>
export default {
  name: "eArchiveList",
  props: {
    files: {type: Array}
  },
}
</script>

<style scoped>

.my-archive-list{
  max-width: 960px;
}

</style>