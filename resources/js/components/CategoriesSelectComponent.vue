<template>
  <div class="row">
    <div class="col">
<!--    <div :class="children.length ? 'col-md-6' : 'col-md-12'">-->
      <div class="form-group">
        <label for="shop_id" v-if="label">{{ label }}</label>
        <select name="shop_id"
                id="shop_id"
                @change="loadSubcategories($event.target.value)"
                class="form-control">
          <option v-for="shop in shops.data"
          :key="shop.id"
                  :selected="shop.id == value"
                  :value="shop.id">{{ shop.name }}
          </option>
        </select>
      </div>
    </div>
    <div v-for="(subcategory, i) in children" class="col" :key="i">
      <div class="form-group">
        <label :for="`category_id_${i}`">{{ nestedLabel }}</label>
        <select name="category_id"
                :id="`category_id_${i}`"
                @change="loadSubcategories($event.target.value)"
                class="form-control">
          <option v-for="category in subcategory.data"
          :key="category.id"
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
    },
    categoryValue: {
      required: false,
      type: String,
    }
  },
  data() {
    return {
      loaded: false,
      shops: {
        data: [],
      },
      values: [],
      children: [],
    }
  },
  created() {
    axios.get('/api/shops').then(response => {
      this.shops = response.data;
      if (this.categoryValue) {
        this.loadSubcategories(this.categoryValue);
      }
    })
  },
  updated(){
    console.log("this.props updates", this.$props)
     console.log("this.children updates", this.$children)
  },
  mounted(){
    console.log("this.props", this.$props)
  },
  methods: {
    loadSubcategories(id) {
      console.log("LoadSubcategories ID", id)
      if (!id) {
        this.children = [];
        return;
      }
      axios.get(`/api/select/categories/${id}`).then(response => {
        console.log("loadSubcategories response", response)
        this.values = response.data.data.parents;
        this.children = response.data.data.children;
      })
    },
  }
}
</script>