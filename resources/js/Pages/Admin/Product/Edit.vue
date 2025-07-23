<template>
  <div>
    <!-- Временный блок для отладки -->

    <div class="mb-4">
      <Link :href="route('admin.products.index')" class="inline-block py-2 px-3 bg-sky-600 border border-sky-700 text-white">Назад</Link>
    </div>
    <div>
      <div v-if="success" class="p-4 bg-green-100 mb-4">
        Успешно сохранено
      </div>

      <div class="mb-4">
        <input type="text" v-model="entries.product.title" class="border border-gray-200 p-2 w-1/4" placeholder="Название">
      </div>
       <div class="mb-4">
        <input type="number" v-model="entries.product.price" class="border border-gray-200 p-2 w-1/4" placeholder="Цена">
      </div>
       <div class="mb-4">
        <input type="number" v-model="entries.product.sklad" class="border border-gray-200 p-2 w-1/4" placeholder="Кол-во на складе">
      </div>
<!--        <div class="mb-4">
        <input type="file" v-model="entries.images" class="border border-gray-200 p-2 w-1/4" >
      </div>-->

        <div class="mb-4">
            <select v-model="entries.product.id_parent" class="border border-gray-200 p-2 w-1/4">
                <option :value="null" disabled selected>Выберите категорию</option>
                <option v-for="category in categories" :value="category.id">{{ category.title }}</option>
            </select>
        </div>
        <div class="mb-4">
            <input type="file" @change="setImages" multiple  class="border border-gray-200 p-2 w-1/4" >
        </div>

<!--        <div class="mb-4">
            <select  class="border border-gray-200 p-2 w-1/4">
                <option :value="null" disabled selected>Характеристики</option>
                <option v-for="param in params" :value="params.id">
                    {{ params.title }}
                </option>
            </select>
        </div>-->

      <div class="mb-4">
        <a href="#" @click.prevent="updateProduct"  class="inline-block py-2 px-3 bg-indigo-600 border border-indigo-700 text-white">Сохранить</a>
      </div>
    </div>
  </div>
    <div style=" grid-gap: 20px;" class="grid grid-cols-3">
        <div v-for="image in product.images "  class="">
            <img :src="image.url" :alt="product.title" class="mb-4">
            <div class="text-center">
                <a @click.prevent="deleteImg(image)" class="inline-block px-2 py-1 text-sm bg-red-800 text-gray-200 border-gray-200" href="#"> Удалить</a>
            </div>
        </div>
    </div>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";
import route from "ziggy-js/src/js/index.js";



export default {
  name: "Edit",

  layout: AdminLayout,

  props: {
    categories: Array,
    product: Object,
  },

  components: {
    Link
  },



    data() {

        return {
            success: false,
            entries: {
                product: this.product,
                images: null,
                _method: 'patch',

            },
        }
    },


  methods: {

    updateProduct() {
        axios.post(route('admin.products.update', this.product.id), this.entries,{
            headers: {
                "Content-Type": "multipart/form-data"
            }

        })
        .then(res => {
            this.product.images =  res.data.images;
            this.success = true

        })
    },

      deleteImg(image){
        axios.delete(route('admin.images.destroy', image.id))
          .then(res => {
                  this.product.images = this.product.images.filter(productImage => productImage.id !== image.id)
          })
      },

      setImages(e) {
          this.entries.images = e.target.files;
      }
  }
}
</script>

<style scoped>

</style>
