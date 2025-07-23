<template>
  <div>
    <!-- Временный блок для отладки -->

    <div class="mb-4">
      <Link :href="route('admin.catalogs.index')" class="inline-block py-2 px-3 bg-sky-600 border border-sky-700 text-white">Назад</Link>
    </div>
    <div>
      <div class="mb-4">
        <input type="text" v-model="catalog.title" class="border border-gray-200 p-2 w-1/4" placeholder="Заголовок">

      </div>
      <div class="mb-4">

        <select v-model="catalog.id_parent" class="border border-gray-200 p-2 w-1/4">
          <option :value="null" disabled selected>Выберите категорию</option>
          <option v-for="catalog in catalogs" :value="catalog.id">{{ catalog.title }}</option>
        </select>

      </div>
      <div class="mb-4">
        <a href="#" @click.prevent="storeCategory"  class="inline-block py-2 px-3 bg-indigo-600 border border-indigo-700 text-white">Обновить</a>
      </div>
    </div>
  </div>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";

export default {
  name: "Edit",

  layout: AdminLayout,

  props: {
      catalog: Object,
    catalogs: Array
  },

  components: {
    Link
  },




  methods: {
    storeCategory() {
      axios.patch(route('admin.catalogs.update', this.catalog), this.catalog)

          .then(res => {
            this.catalogs.push(res.data)
            this.catalog = {

            }
          })
    }
  }
}
</script>

<style scoped>

</style>
