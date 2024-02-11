<template>
  <md-card>
    <md-card-header
        class="md-card-header-icon md-card-header-green card-icon"
    >
      <div class="card-icon">
        <md-icon>folder_open</md-icon>
      </div>
      <div class="card-toolbar">
        <h4 class="title">{{ $t('label.contract_documents') }}</h4>
        <div v-if="showAddButton">
          <drop-down direction="down">
            <md-button class="md-just-icon md-simple" :style="{top: '6px'}"
                       data-toggle="dropdown">
              <md-icon>more_vert</md-icon>
            </md-button>
            <ul class="dropdown-menu dropdown-menu-right">
              <li><a class="">Add</a></li>
            </ul>
          </drop-down>
        </div>
      </div>
    </md-card-header>
    <md-card-content>
      <slot name="fileCollection"></slot>
    </md-card-content>
  </md-card>
</template>

<script>
export default {
  name: "eArchiveGallery",
  props: {
    showAddButton: {
      type: Boolean, default: () => false
    }
  },
}
</script>

<style scoped>

</style>