<style  >
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
@import url('https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');


@import '/public/css/catalog.css';
@import '/public/css/style.css';

</style  >

<template>

    <Head>
        <title>{{ catalogs.title }}</title>

    </Head>

    <div class="wrapper">



        <Header :categories="categories" />

        <main class="main">
            <section class="breadcrumbs__block">
                <div class="container">
                    <div class="breadcrumbs-container">
                        <div class="row">

                            <div class="col-xl-2"></div>

                            <div class="col-xl-8 crumbs">
                                <div class="breadcrumbs-content">
                                    <h1> {{ catalogs.title }} </h1>

                                    <div class="breadcrumbs">

                                        <a href="#">Главная</a>
                                        <span class="separator">/</span>

                                        <span v-if="breadcrumbs.length > 0" class="">

                                            <Link v-for="breadcrumb in breadcrumbs"
                                                  :href="route('client.categories.products.index', breadcrumb.id)"
                                                  class="">
                                                {{ breadcrumb.title }}
                                            </Link>

                                            <span class="separator">/</span>

                                        </span>

                                        <span> {{ catalogs.title }}</span>

                                    </div>

                                </div>
                            </div>

                            <div class="col-xl-2"></div>
                        </div>
                    </div>
                </div>

            </section>

            <section>
                <div class="row">

                    <div class="container">
                        <div class="catalogs d__none">
                            <aside class="filter" style="position: relative;">

                                <form action="/catalog/futbolki/" method="GET" id="filtr_form">
                                    <div class="result_with_filtr" style="position: relative; display: inline-block;">
                                        <button type="button">Найдено
                                            <span style="font-weight: bold">{{ totalCount }}</span>
                                            <div v-if="totalCount > 0">{{ productWord }}</div>
                                            <div v-else>товаров не найдено</div>
                                        </button>
                                    </div>

                                    <div class="h3">Все разделы</div>
                                    <div class="">
                                        <div id="catalog" v-if="product_count_subcategories.length > 0">
                                            <div>
                                                <Link v-for="product_count_subcategorie in product_count_subcategories"
                                                      :href="route('client.categories.products.index', product_count_subcategorie.url)"
                                                      :class="{ 'active-category': product_count_subcategorie.id === catalogs.id }"
                                                      class="">
                                                    {{ product_count_subcategorie.title }}
                                                    <span> {{ product_count_subcategorie.count_product }}</span><br>
                                                </Link>
                                            </div>
                                        </div>


                                        <div class="h3">Остаток</div>
                                        <div class="residue">
                                            <div class="row__block">
                                                <label for="residue_from">от</label>
                                                <input
                                                    v-model="filters.integer.from.quantity"
                                                    type="number"
                                                    name="count_from"
                                                    @change="updateResidueSlider"
                                                    id="residue_from"
                                                    min="0">

                                                <label for="residue_to">до</label>
                                                <input
                                                    v-model="filters.integer.to.quantity"
                                                    type="number"
                                                    name="count_to"
                                                    @change="updateResidueSlider"
                                                    id="residue_to"
                                                    min="0">
                                            </div>
                                            <div id="residue-slider" class="mt-3 mb-3"></div>
                                        </div>

                                        <div class="h3">Склад</div>
                                        <div class="row">
                                            <ul id="warehouse">
                                                <li>
                                                    <input id="sklad_1" type="checkbox" name="sklad[]" value="Москва">
                                                    <label for="sklad_1">Москва</label>
                                                </li>
                                            </ul>

                                            <template v-for="(param, paramType)  in params " :key="paramType">

                                                <div v-if="paramType === 'material' ">
                                                    <div class="h3">Материал</div>
                                                    <div class="row">
                                                        <ul id="material">
                                                            <li v-for="(item, index) in param" :key="index">

                                                                <input
                                                                    @change="setFilter(item, item.change)"
                                                                    :id="'material_' + item.param_id"
                                                                    type="checkbox"
                                                                    name=""
                                                                    :value="item.type">
                                                                <label :for="'material_' + item.param_id">

                                                                    {{ item.change }}

                                                                </label>
                                                            </li>
                                                        </ul>

                                                    </div>
                                                </div>

                                                <div v-if="paramType === 'brand' ">
                                                    <div class="h3">Бренд</div>
                                                    <div class="row">
                                                        <ul id="brand">
                                                            <li v-for="(item, index) in param" :key="index">

                                                                <input
                                                                    @change="setFilter(item, item.change)"
                                                                    :id="'brand_' + item.param_id"
                                                                    type="checkbox" name=""
                                                                    :value="item.change">
                                                                <label :for="'brand_' + item.param_id">

                                                                    {{ item.change }}

                                                                </label>
                                                            </li>
                                                        </ul>

                                                    </div>


                                                </div>

                                                <div v-if="paramType === 'drawing' ">

                                                    <div class="h3">Цена <i class="fa fa-rub "></i></div>

                                                    <div class="price ">
                                                        <div class="row row__block">

                                                            <label for="amount_from">от</label>
                                                            <input
                                                                v-model="filters.integer.from[paramType]"
                                                                type="number"
                                                                name="price_from"
                                                                @change="updateSlider"
                                                                id="amount_from"
                                                                min="0"
                                                                max="10000">

                                                            <label for="amount_to">до</label>
                                                            <input
                                                                v-model="filters.integer.to[paramType]"
                                                                type="number"
                                                                name="price_to"
                                                                @change="updateSlider"
                                                                id="amount_to"
                                                                min="0"
                                                                max="10000">
                                                        </div>
                                                        <div id="price-slider" class="mt-3 mb-3"></div>

                                                    </div>

                                                </div>

                                            </template>

                                            <a @click.prevent="getPosts"
                                               href="#"
                                               class="block text-center px-3 py-2 text-gray-300 bg-indigo-800 border border-indigo-900">Фильтр
                                            </a>


                                        </div>
                                    </div>
                                </form>
                            </aside>
                        </div>
                        <div class="product__card__block__main product__color">

                            <ProductItem v-for="product in productsData" :product="product"></ProductItem>

                        </div>

                        <div class="pagination-container mt-4" v-if="pagination && pagination.links">
                            <div class="pagination">

                                <template v-for="(link, index) in visibleLinks" :key="index">
                                    <a
                                        v-if="link.url"
                                        :href="link.url"
                                        v-html="link.label"
                                        :class="{ 'active': link.active }"
                                        class="pagination-link"
                                        @click.prevent="handlePagination(link.url)"
                                    ></a>
                                    <span v-else v-html="link.label" class="pagination-disabled"></span>
                                </template>

                            </div>
                        </div>


                    </div>
                </div>
            </section>

        </main>

        <Footer/>

    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import ProductItem from "@/Components/Client/Product/Productitem.vue"

import Header from "@/Components/Client/Header.vue" // Импортируем компонент Header
import Footer from "@/Components/Footer.vue"


import { Link, router, Head  } from "@inertiajs/vue3"
import noUiSlider from 'nouislider'
import 'nouislider/dist/nouislider.css'

const props = defineProps({
    catalogs: Object,         // Основная категория каталога
    products: Array,          // Список товаров
    breadcrumbs: Array,       // Хлебные крошки
    subcategories: Array,     // Подкатегории
    product_count_subcategories: Array, // Подкатегории с количеством товаров
    categories: Array,        // Все категории для меню
    params: Object,           // Параметры фильтрации
    total_count: Number,      // Общее количество товаров
    drawings: Array,
    pagination: Object,
})

// Реактивные состояния
const mounted = ref(false)               // Флаг монтирования компонента
const productsData = ref(props.products) // Реактивный список товаров
const totalCount = ref(props.total_count) // Реактивное общее количество товаров

/*******************************************/

const filters = ref({
    integer: {
        from: {},
        to: {},
    },
    select: {},
    checkbox: {},
})


// Функции для фильтров
const productWord = computed(() => {
    // Склонение слова "товар" в зависимости от количества
    const count = totalCount.value % 100
    if (count >= 11 && count <= 19) return 'товаров'

    const lastDigit = count % 10
    if (lastDigit === 1) return 'товар'
    if (lastDigit >= 2 && lastDigit <= 4) return 'товара'
    return 'товаров'
})



//Управление фильтрами:
const setFilter = (item, value) => {
    // Установка фильтра по чекбоксу
    if (filters.value.checkbox[item.type]) {
        toggleItem(filters.value.checkbox[item.type], value)
        return
    }

    filters.value.checkbox[item.type] = []
    filters.value.checkbox[item.type].push(value)
}

const toggleItem = (arr, value) => {
    // Переключение элемента фильтра
    const index = arr.indexOf(value)
    index === -1 ? arr.push(value) : arr.splice(index, 1)
}


//Загрузка отфильтрованных товаров:
const getPosts = () => {
    // AJAX-запрос для фильтрации товаров
    axios.get(route('client.categories.products.index', props.catalogs.url), {
        params: {
            filters: filters.value
        }
    })
        .then(res => {
            if (res.data.data && res.data.meta) {
                productsData.value = res.data.data  // Обновить список товаров
                totalCount.value = res.data.meta.total_count  // Обновить количество
            }
        })
}


// Инициализация слайдеров
const initPriceSlider = () => {
    const slider = document.getElementById('price-slider')
    const paramType = 'drawing'

    if (slider && !slider.noUiSlider) {
        noUiSlider.create(slider, {
            start: [
                filters.value.integer.from[paramType] || 0,
                filters.value.integer.to[paramType] || 10000
            ],
            connect: true,
            range: {
                'min': 0,
                'max': 10000
            },
            step: 100
        })
        // Обновление значений фильтра при движении слайдера
        slider.noUiSlider.on('update', (values) => {
            filters.value.integer.from[paramType] = Math.round(values[0])
            filters.value.integer.to[paramType] = Math.round(values[1])
        })
    }
}

const initResidueSlider = () => {
    // Аналогично слайдеру цены, но для количества товаров
    const slider = document.getElementById('residue-slider')
    const paramType = 'quantity'

    if (slider && !slider.noUiSlider) {
        noUiSlider.create(slider, {
            start: [
                filters.value.integer.from[paramType] || 0,
                filters.value.integer.to[paramType] || 100
            ],
            connect: true,
            range: {
                'min': 0,
                'max': 100
            },
            step: 1
        })

        slider.noUiSlider.on('update', (values) => {
            filters.value.integer.from[paramType] = Math.round(values[0])
            filters.value.integer.to[paramType] = Math.round(values[1])
        })
    }
}

onMounted(() => {
    mounted.value = true      // Установить флаг монтирования
    initPriceSlider()        // Инициализировать слайдер цены
    initResidueSlider()      // Инициализировать слайдер количества
})



// Обработчик пагинации
const handlePagination = (url) => {
    window.location.href = url;
}


</script>


<script>
export default {
    props: {
        pagination: Object,
    },

    computed: {
        visibleLinks() {
            if (!this.pagination) return [];
            const current = this.pagination.current_page;

            return this.pagination.links
                .map((link) => {
                    let label = link.label;

                    // меняем текст
                    if (label.includes('Previous')) {
                        label = 'Назад';
                    } else if (label.includes('Next')) {
                        label = 'Вперёд';
                    }

                    return { ...link, label };
                })
                .filter((link) => {
                    if (!link.url || isNaN(link.label)) {
                        return true; // "Prev" и "Next" оставляем
                    }
                    const page = Number(link.label);
                    return page >= current - 1 && page <= current + 1;
                });
        },
    },
};
</script>

<style>
/* Стили для пагинации */
.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

.pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination-link,
.pagination-disabled {
    padding: 0.5rem 1rem;
    margin: 0 0.25rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
}

.pagination-link:hover {
    background-color: #f5f5f5;
}

.pagination-link.active {
    background-color: #ee2a27;
    color: white;
    border-color: #ee2a27;
}

.pagination-disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.catalog_drop {
    position: absolute;
    background: white;
    z-index: 1000;
    left: 0;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: opacity 0.3s ease;
}
.catalog__desc:hover .catalog_drop,
.catalog_drop:hover {
    display: block;
}


.sub-subcategories {
    position: absolute;
    left: 100%;
    top: 0;
    background: white;
    min-width: 250px;
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1);
    padding: 0
}

/* Для плавного появления/исчезновения */
.catalog-enter-active, .catalog-leave-active {
    transition: all 0.3s;
}

.catalog-enter-from, .catalog-leave-to {
    opacity: 0;
    transform: translateY(10px);
}


/********************************************************************************************/

.header .catalog_drop .list {
    display: flex !important;
    flex-direction: column !important;
    border: none;
}

.header .catalog_drop .list .item .items a .table .margin p {
    padding-left: 0;
    margin-bottom: 0;
    font-size: 11px;
    color: #000;
}



.header .catalog_drop .list .item {
    border-right: 0;
    width: 100%;
    display: flex;
    align-items: flex-end;
    height: 40px;
    justify-content: center;
    padding: 10px 10px;
}


.header .catalog_drop .list .item .items a .table {
    padding-left: 0;
    height: 100%;
}

.header .catalog_drop .list {
    padding: 0;
    max-width: 300px;
}

.catalog_drop {
    background: none;
}

.wrap_c {
    max-width: 100%;
    width: 100%;
    text-align: left;
}

.header .catalog_drop .list .item .items a {
    display: block;
    text-decoration: none;
    color: #000;
    font-size: 13px;
    position: relative;
    transition: .3s all;
    margin: 0 0 10px 0;
    text-transform: uppercase
}

.subcategories {
    position: absolute;
    top: 0;
    left: 100%;
    background: white;
    min-width: 250px;
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1);
    padding: 0 0 0 0;
}

.item .table {
    margin: 0;

}

.item:hover {
    color: #ee2a27;
    background-color: #d6d6d6;
}

.subcategory-column {
    display: flex;
    flex-direction: column;
}

.subcategory-column a {
    padding: 9px 10px;
    text-transform: uppercase;
    font-size: 15px;
}

.subcategory-column a:hover {

    background-color: #d6d6d6;
}

.margin p {
    margin: 0;
}

input[type=checkbox] {
    display: none;
}

input[type=checkbox] + label {
    position: relative;
    color: #333;
    font-size: 16px;
    line-height: 22px;
    padding: 0 0 0 25px;
}





.noUi-connect {
    background: #ee2a27;
}

.noUi-handle {
    width: 12px!important;
    height: 12px!important;
    right: -6px!important;
    top: -5px!important;
    border-radius: 50%!important;
    background: #ee2a27!important;
    border: none!important;
    box-shadow: none!important;
    cursor: pointer!important;
}
/* Убираем дополнительные элементы ручки */
.noUi-handle:before,
.noUi-handle:after {
    display: none;
}

/* Стиль для зоны касания (необязательно) */
.noUi-touch-area {
    width: 100%;
    height: 100%;
}

/* Дополнительные стили для коннектора (соединительной линии) */
.noUi-connect {
    background: #ee2a27;
}

/* Стили для базовой линии слайдера */
.noUi-target {
    background: #f0f0f0;
    border-radius: 3px;
    border: none;
    box-shadow: none;
    height: 4px;
}
.filter .price input, .filter .residue input {
    width: 58px;
    padding: 0 5px 0 10px;

}
.filter .price label, .filter .residue label {
    margin: 0 7px 0 0;
}

.bg-indigo-800{
    background-color: red!important;
    color: #0a0a0a;
    font-weight: bold;
}

#catalog .active-category {
    font-weight: bold;
    color: #ee2a27; /* или любой другой цвет для выделения */
}

#catalog .active-category span {
    font-weight: bold;
    color: #ee2a27;
}


#residue-slider {
    margin: 15px 0;
    height: 4px;
}

#residue-slider .noUi-connect {
    background: #ee2a27;
}

#residue-slider .noUi-handle {
    width: 12px!important;
    height: 12px!important;
    right: -6px!important;
    top: -5px!important;
    border-radius: 50%!important;
    background: #ee2a27!important;
    border: none!important;
    box-shadow: none!important;
    cursor: pointer!important;
}

.collapse {
    visibility: visible;
}

.product-main-image[data-v-8f09e388]{
    border: 0;
}
.product-main-image {
    border: 0;
}



</style>

