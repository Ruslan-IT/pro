<template>
    <div>
        <div class="mb-4">
            <Link :href="route('admin.params.index')" class="inline-block py-2 px-3 bg-sky-600 border border-sky-700 text-white">Назад</Link>
        </div>
        <div>
            <div class="mb-4">
                <input type="text" v-model="param.title" class="border border-gray-200 p-2 w-1/4" placeholder="Заголовок">
            </div>
            <div class="mb-4">
                <select v-model="param.filter_type" class="border border-gray-200 p-2 w-1/4">
                    <option :value="null" disabled selected>Выберите тип фильтра</option>
                    <option v-for="filterType in filterTypes" :value="filterType.value">{{ filterType.title }}</option>
                </select>
            </div>
            <div class="mb-4">
                <a href="#" @click.prevent="storeParam"  class="inline-block py-2 px-3 bg-indigo-600 border border-indigo-700 text-white">Создать</a>
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
            param: {
                filter_type: null
            }
        }
    },

    methods: {
        storeParam() {
            axios.post(route('admin.params.store'), this.param)
            .then(res => {
                this.param = {
                    filter_type: null
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
