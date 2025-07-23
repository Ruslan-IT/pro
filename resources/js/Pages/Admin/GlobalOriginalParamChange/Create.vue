<template>
  <div>
    <!-- Временный блок для отладки -->

    <div class="mb-4">
      <Link :href="route('admin.global_original_param_changes.index')" class="inline-block py-2 px-3 bg-sky-600 border border-sky-700 text-white">Назад</Link>
    </div>
    <div>
      <div class="mb-4">
        <input type="text" v-model="global_original_param_change.title" class="border border-gray-200 p-2 w-1/4" placeholder="Заголовок">

      </div>
      <div class="mb-4">

        <select v-model="global_original_param_change.original" class="border border-gray-200 p-2 w-1/4">
          <option :value="null" disabled selected>Выберите фильтр</option>
          <option v-for="filterType in filterTypes" :value="filterType.value">{{ filterType.title }}</option>
        </select>

      </div>
      <div class="mb-4">
        <a href="#" @click.prevent="storeGlobal_original_param_changes"  class="inline-block py-2 px-3 bg-indigo-600 border border-indigo-700 text-white">Создать</a>
      </div>
    </div>
  </div>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";

export default {
  name: "Create",

  layout: AdminLayout,

  props: {
      filterTypes: Array
  },

  components: {
    Link
  },



  data() {
    return {
      global_original_param_change: {
          original: null
      }
    }
  },

  methods: {
    storeGlobal_original_param_changes() {
      axios.post(route('admin.global_original_param_changes.store'), this.global_original_param_change)

          .then(res => {
            this.global_original_param_changes.push(res.data)
            this.global_original_param_change = {
              original: null
            }
          })
    }
  }
}
</script>

<style scoped>

</style>
