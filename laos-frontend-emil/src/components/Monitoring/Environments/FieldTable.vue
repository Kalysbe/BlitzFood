<template>
  <div>
    <md-table>
      <md-table-row>
        <md-table-head v-for="head in table.headers" :key="head">
          {{ head }}
        </md-table-head>
      </md-table-row>
      <template v-if="table.rows && table.rows.length > 0">
        <md-table-row v-for="(row, indexRow) in table.rows" :key="indexRow">
          <md-table-cell v-for="(value, key, i) in row" :key="key + i">
            {{ value }}
          </md-table-cell>
          <md-table-cell style="width: 100px">
            <div class="cell-actions">
              <md-button
                class="md-raised md-sm md-primary"
                @click.stop.prevent="openEditDialog(row, indexRow)"
              >
                {{ $t('button.edit') }}
              </md-button>
              <md-button
                class="md-raised md-sm md-danger"
                @click.stop.prevent="deleteTableRow(indexRow)"
              >
                {{ $t('button.delete') }}
              </md-button>
            </div>
          </md-table-cell>
        </md-table-row>
      </template>
      <template v-else>
        <md-table-row>
          <md-table-cell colspan="5" class="text-center">
            <h5>{{ $t(`environment.no_tables`) }}</h5>
          </md-table-cell>
        </md-table-row>
      </template>
    </md-table>
    <!-- dialog actions start -->
    <md-dialog
      :md-active.sync="isTableDialog"
      :md-click-outside-to-close="false"
    >
      <md-dialog-title>Add list</md-dialog-title>
      <div class="md-layout md-size-70">
        <div class="md-layout">
          <template v-for="field in table.template">
            <div
              :class="`md-layout-item md-size-${field.row}`"
              :key="field.field"
            >
              <template v-if="field.element === 'select'">
                <md-field>
                  <label>{{ $t(`environment.${field.field}`) }}</label>
                  <md-select v-model="field.value" return-object>
                    <md-option
                      v-for="option in field.options"
                      :value="option.name"
                      :key="option.id"
                    >
                      {{ option.name }}
                    </md-option>
                  </md-select>
                </md-field>
              </template>
              <template v-if="field.element === 'textarea'">
                <md-field>
                  <label>{{ $t(`environment.${field.field}`) }}</label>
                  <md-textarea
                    v-model="field.value"
                    :md-counter="field.counter"
                    :md-autogrow="field.autogrow"
                  ></md-textarea>
                </md-field>
              </template>
            </div>
          </template>
          <!-- dialog actions start-->
          <div class="md-layout-item md-size-100 text-right">
            <template v-if="isEdit">
              <md-button
                class="md-success"
                native-type="submit"
                @click.native.prevent="updateTableRow"
              >
                {{ $t('button.update') }}
              </md-button>
            </template>
            <template v-else>
              <md-button
                class="md-success"
                native-type="submit"
                @click.native.prevent="addTableRow(table.template)"
              >
                {{ $t('button.save') }}
              </md-button>
            </template>
            <md-button
              class="md-accent"
              @click.stop.prevent="toggleTableDialog"
            >
              {{ $t('button.close') }}
            </md-button>
          </div>
        </div>
      </div>
    </md-dialog>
    <!-- dialog actions end -->
  </div>
</template>

<script>
export default {
  props: ['table', 'isTableDialog'],
  data: () => ({
    isEdit: false,

    editableRowIndex: null
  }),
  methods: {
    toggleTableDialog() {
      this.$emit('toggleTableDialog')
    },
    addTableRow(data) {
      let obj = data.reduce((acc, {field, value}) => {
        acc = {...acc, [field]: value}
        return acc
      }, {})
      this.table.rows.push(obj)
    },
    updateTableRow() {
      let obj = this.table.template.reduce((acc, {field, value}) => {
        acc = {...acc, [field]: value}
        return acc
      }, {})
      this.table.rows[this.editableRowIndex] = obj
      this.$emit('toggleTableDialog')
    },
    deleteTableRow(rowIndex) {
      this.table.rows.splice(rowIndex, 1)
    },
    openEditDialog(row, rowIndex) {
      this.$emit('toggleTableDialog')
      this.editableRowIndex = rowIndex
      this.isEdit = true
      this.table.template = this.table.template.map((f) => {
        for (const [key, value] of Object.entries(row)) {
          if (key == f.field) {
            f.value = value
          }
        }
        return f
      })
    }
  }
}
</script>

<style>
</style>