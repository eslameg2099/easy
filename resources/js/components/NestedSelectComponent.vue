<template>
  <div class="row">
    <div class="col">
<!--    <div :class="children.length ? 'col-md-6' : 'col-md-12'">-->
      <div class="form-group">
        <label for="category_id" v-if="label">{{ label }}</label>
        <select name="category_id"
                id="category_id"
                @change="loadSubcategories($event.target.value)"
                class="form-control">
          <option hidden value="">{{ placeholder }}</option>
          <option v-for="category in categories.data"
                  :selected="values.includes(category.id)"
                  :value="category.id">{{ category.name }}
          </option>
        </select>
      </div>
    </div>
    <div v-for="(subcategory, i) in children" class="col">
<!--    <div v-for="(subcategory, i) in children" :class="getClassName(i)">-->
      <div class="form-group">
        <label :for="`category_id_${i}`">{{ nestedLabel }}</label>
        <select name="category_id"
                :id="`category_id_${i}`"
                @change="loadSubcategories($event.target.value)"
                class="form-control">
          <option hidden value="">{{ nestedPlaceholder }}</option>
          <option v-for="category in subcategory.data"
                  :selected="values.includes(category.id)"
                  :value="category.id">{{ category.name }}
          </option>
        </select>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    remoteUrl: {
      required: true,
      type: String,
    },
    name: {
      required: false,
      type: String,
      default: 'category_id'
    },
    label: {
      required: false,
      type: String,
      default: ''
    },
    nestedLabel: {
      required: false,
      type: String,
      default: ''
    },
    placeholder: {
      required: false,
      type: String,
      default: ''
    },
    nestedPlaceholder: {
      required: false,
      type: String,
      default: ''
    },
    value: {
      required: false,
      type: String,
    }
  },
  data() {
    return {
      loaded: false,
      categories: {
        data: [],
      },
      values: [],
      children: [],
    }
  },
  created() {
    axios.get(this.remoteUrl).then(response => {
      this.categories = response.data;
    })
    if (this.value) {
      this.loadSubcategories(this.value);
    }
  },
  methods: {
    loadSubcategories(id) {
      if (!id) {
        this.children = [];
        return;
      }
      axios.get(`${this.remoteUrl}/${id}`).then(response => {
        this.values = response.data.data.parents;
        this.children = response.data.data.children;
      })
    },
    getClassName(i) {
      let className = 'col-md-6';
      let lastIndex = this.children.length - 1;
      if (i === lastIndex && (this.children.length + 1) % 2) {
        className = 'col-md-12';
      }
      return className;
    }
  }
}
</script>