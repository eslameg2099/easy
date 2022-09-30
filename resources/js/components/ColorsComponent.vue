<template>
  <div class="row">
    <div class="col">
      <label>{{ $t('products.attributes.colors') }}</label>
      <table class="table table-bordered align-items-center table-sm">
        <thead class="thead-light">
        <tr>
          <th>#</th>
          <th>{{ $t('products.attributes.color_name') }}</th>
          <th>{{ $t('products.attributes.color_hex') }}</th>
          <th>...</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(field, index) in fields" :key="index">
          <td v-text="index + 1"></td>
          <td>
            <input type="text"
                   v-model="field.name"
                   :name="`colors[${index}][name]`"
                   class="form-control">
          </td>
          <td>
            <input type="color"
                   v-model="field.hex"
                   :name="`colors[${index}][hex]`"
                   class="form-control">
          </td>
          <td>
            <button type="button"
                    class="btn btn-danger btn-small"
                    @click="removeField(field)">
              <i class="fas fa-times"></i>
            </button>
          </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
          <td colspan="4" class="text-right">
            <button type="button" class="btn btn-info" @click="addNewField()">
              <i class="fas fa-plus"></i>
            </button>
          </td>
        </tr>
        </tfoot>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  props: ['colors'],
  data() {
    return {
      fields: [
        {
          name: '',
          hex: ''
        }
      ],
    }
  },
  created() {
    if (this.colors) {
      this.fields = this.colors;
    }
  },
  methods: {
    addNewField() {
      this.fields.push({
        name: '',
        hex: ''
      });
    },
    removeField(field) {
      this.fields = this.fields.filter(f => {
        return this.fields.indexOf(f) !== this.fields.indexOf(field);
      })
      // this.$delete(this.fields, this.fields.indexOf(field));
    }
  }
}
</script>

<style scoped>

</style>
