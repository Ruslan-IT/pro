<template>
    <div>
        <!-- Временный блок для отладки -->

        <div class="mb-4">
            <Link :href="route('admin.products.index')"
                  class="inline-block py-2 px-3 bg-sky-600 border border-sky-700 text-white">Назад
            </Link>
        </div>
        <div>

            <div class="mb-4">
                <input type="text" v-model="entries.product.title" class="border border-gray-200 p-2 w-1/4"
                       placeholder="Название">
            </div>
            <div class="mb-4">
                <input type="number" v-model="entries.product.price" class="border border-gray-200 p-2 w-1/4"
                       placeholder="Цена">
            </div>
            <div class="mb-4">
                <input type="number" v-model="entries.product.sklad" class="border border-gray-200 p-2 w-1/4"
                       placeholder="Кол-во на складе">
            </div>
            <div class="mb-4">
                <input ref="image_input" type="file" @change="setImages" multiple class="border border-gray-200 p-2 w-1/4">
            </div>

            <div class="mb-4">
                <select v-model="entries.product.id_parent" class="border border-gray-200 p-2 w-1/4">
                    <option :value="null" disabled selected>Выберите категорию</option>
                    <option v-for="category in categories" :value="category.id">{{ category.title }}</option>
                </select>
            </div>

            <div class="mb-4 flex">
                <div class="mr-2">
                    <select v-model="paramOption.paramObj" class="border border-gray-200 p-2 pr-8">
                        <option :value="{}" disabled selected>Выберите характеристики</option>
                        <option v-for="param in params" :value="param">
                            {{ param.title }}
                        </option>
                    </select>
                </div>
                <div class="mr-2">
                    <input v-model="paramOption.value" type="text" class="border border-gray-200 p-2 "
                           placeholder="Значение">
                </div>
                <div>
                    <a @click.prevent="setParam" href="#"
                       class="inline-block bg-white border-gray-200 border px-3 py-2">+</a>
                </div>

            </div>

            <div class="mr-4">
                <div v-for="paramEntries in entries.params">
                    {{ paramEntries.title }} - {{ paramEntries.value }} - {{ paramEntries.title_translit }}
                </div>
            </div>


            <div class="mb-4">
                <a href="#" @click.prevent="storeCategory"
                   class="inline-block py-2 px-3 bg-indigo-600 border border-indigo-700 text-white">Создать</a>
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
        categories: Array,
        params: Array
    },

    components: {
        Link
    },


    data() {
        return {
            errors: [],
            paramOption: {
                paramObj: {}
            },
            entries: {
                product: {
                    categories: null,
                },
                images: null,
                params: [],
            },
        }
    },


    methods: {
        storeCategory() {
            axios.post(route('admin.products.store'), this.entries, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }

            })
                .then(res => {
                    this.entries = {
                        product: {
                            categories: null,
                        },
                        images: null,
                        params: [],
                    }
                })

            this.$refs.image_input.value = null
        },
        setImages(e) {
            this.entries.images = e.target.files;
        },

        setParam() {
            this.entries.params.push({
                id: this.paramOption.paramObj.id,
                title: this.paramOption.paramObj.title,
                title_translit: this.paramOption.paramObj.title_translit,
                value: this.paramOption.value,
            })
        }

    }
}
</script>

<style scoped>

</style>
