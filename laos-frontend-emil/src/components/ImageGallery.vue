<template>
    <md-card>
      <md-card-header
          class="md-card-header-icon md-card-header-green card-icon"
      >
        <div class="card-icon">
          <md-icon>local_see</md-icon>
        </div>
        <div class="card-toolbar">
          <h4 class="title">{{ $t('label.contract_photos') }}</h4>
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
        <slot name="imageCollection"></slot>
      </md-card-content>
    </md-card>
</template>

<script>
export default {
  name: "ImageGallery",
  props: {
    showAddButton: {
      type: Boolean, default: () => false
    }
  },
  data() {
    return {}
  },
  methods: {},
}
</script>

<style lang="scss">
.card-toolbar {
  display: flex;
  justify-content: space-between;
}

.md-card .md-card-header a {
  color: black !important;
}
</style>

