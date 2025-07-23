<template>
  <div>
    <!-- Временный блок для отладки -->

    <div class="mb-4">
      <Link :href="route('admin.global_original_param_changes.index')" class="inline-block py-2 px-3 bg-sky-600 border border-sky-700 text-white">Назад</Link>
    </div>
      <div v-if="success" class="p-4 bg-green-100 mb-4">
          Успешно сохранено!
      </div>

      <div>
      <div class="mb-4">
        <input type="text" v-model="global_original_param_change.original" class="border border-gray-200 p-2 w-1/4" placeholder="Заголовок">

      </div>
      <div class="mb-4">

        <select v-model="global_original_param_change.id_parent" class="border border-gray-200 p-2 w-1/4">
          <option :value="null" disabled selected>Выберите категорию</option>
          <option v-for="global_original_param_change in global_original_param_changes" :value="global_original_param_change.id">{{ global_original_param_change.type }}</option>
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
      global_original_param_change: Object,
    global_original_param_changes: Array
  },

  components: {
    Link
  },


    data() {
        return {
            success: false
        }
    },



    methods: {
    storeCategory() {
      axios.patch(route('admin.global_original_param_changes.update', this.global_original_param_change), this.global_original_param_change)

          .then(res => {
              this.success = true
          })

    }
  },

    watch: {
        global_original_param_change: {
            handler(new_val, old_val){
                this.success = false
            },
            deep: true
        }
    }

}
</script>

<style scoped>

</style>
