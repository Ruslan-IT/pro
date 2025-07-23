<style>
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
@import url('https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');
@import url('http://14mvgifts.local/css/catalog.css');
@import url('http://14mvgifts.local/css/style.css');
</style>

<template>
    <div class="wrapper">
        <header class="header">

            <div class="row header__top__block__main">
                <div class="container__header">
                    <div class="container__header__flex">
                        <div class="">
                            <div class="header__top d-flex ">
                                <!-- Мобильный телефон (видно только на мобильных) -->
                                <div class="d-block d-md-none">
                                    <a href="tel:+74993943841" class="header__phone">8 (499) 394-38-41</a>
                                </div>

                                <span class="company">|</span>
                                <div class="header__top__block company">
                                    <a href="">О компании </a>
                                </div>
                                <span>|</span>
                                <div class="header__top__block">
                                    <button type="submit" class="btn btn-primary submit-btn btn__red ">ЗАКАЗАТЬ ЗВОНОК
                                    </button>
                                </div>
                                <span>|</span>
                                <div class="header__top__block">

                                    <div class="header__top__cart">
                                        <div class="header__top__img">
                                            <img src="http://14mvgifts.local/img/cart.png" alt="">
                                        </div>
                                        <div class="header__top__info">
                                            <p class="min__order"> Минимальный заказ</p>
                                            <p class="rub">15 000 Р </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <div class="container">

                <div class="row header__search">

                    <div class="col-xl-2">
                        <img src="http://14mvgifts.local/img/logo.png" alt="logo">
                    </div>
                    <div class="col-xl-8 ">

                        <button class="navbar-toggler ds-mob" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                                aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="input-group">
                            <input type="text" class="form-control"
                                   placeholder="Поиск товаров по названию или артикулу">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button">
                                    <img src="http://14mvgifts.local/img/ser.png" alt="search">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 phone__mob__none">
            <span>
                <a href=""> 8 (499) 394 38 41</a>

            </span>
                    </div>
                    <div class="catalogmobile__my">
                        <div class="nav-item catalog ">
                            <a class="nav-link" href="#">КАТАЛОГ</a>
                            <span></span>
                        </div>
                    </div>

                </div>

                <div class="row header__menu ">
                    <div class="col-xl-2"></div>

                    <div class="col-xl-8">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <div class="container-fluid header__menu">

                                <div class="collapse navbar-collapse" id="navbarNav">
                                    <ul class="navbar-nav">
                                        <li class="nav-item catal catalog__desc"
                                            @mouseenter="openCatalogMenu"
                                            @mouseleave="handleMenuMouseLeave">

                                            <a class="nav-link catalog__mar" href="#">КАТАЛОГ</a>
                                            <span></span>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">ПОРТФОЛИО</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">НАНЕСЕНИЕ</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">КОНТАКТЫ</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">НОВОСТИ</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">ОПЛАТА И ДОСТАВКА</a>
                                        </li>


                                        <li class="nav-item  nav__block__none">
                                            <a class=" more_menu nav-link" href="#">Преимущества</a>
                                        </li>
                                        <li class="nav-item nav__block__none">
                                            <a class="  more_menu nav-link" href="#">Награды</a>
                                        </li>
                                        <li class="nav-item nav__block__none">
                                            <a class=" more_menu nav-link" href="#">Благодарности</a>
                                        </li>
                                        <li class="nav-item nav__block__none">
                                            <a class=" more_menu nav-link" href="#">Новости</a>
                                        </li>
                                        <li class="nav-item nav__block__none">
                                            <a class=" more_menu nav-link" href="#">Статьи</a>
                                        </li>
                                        <li class="nav-item nav__block__none ">
                                            <a class=" more_menu nav-link" href="#">Вопросы и ответы</a>
                                        </li>

                                        <li class="nav-item nav__block__none menu__phone">
                                            <a class="nav-link" href="#">8 (499) 394 38 41</a>
                                        </li>
                                        <li class="nav-item nav__block__none ">
                                            <a class="nav-link menu__email" href="#">info@mvgifts.ru</a>
                                        </li>


                                    </ul>
                                    <!-- Кнопка закрытия (крестик) - видна только в мобильном меню -->
                                    <button class="btn-close d-lg-none ms-auto" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#navbarNav" aria-controls="navbarNav"
                                            aria-label="Close"></button>
                                </div>
                                <section v-if="showCatalogDrop" class="catalog_drop"
                                         @mouseenter="handleMenuMouseEnter"
                                         @mouseleave="handleMenuMouseLeave">
                                    <div class="wrap_c">
                                        <div class="list">
                                            <!--                                            :href="`/catalog/${category.url}/`"-->
                                            <a :href="`/catalog/${category.url}/`" class="item"
                                               v-for="category in categories" :key="category.id"
                                               @mouseenter="showSubcategories(category.id)">

                                                    <span>
                                                        <div class="table">
                                                            <div class="margin">
                                                                <p style="text-transform: uppercase;">{{
                                                                        category.title
                                                                    }}</p>
                                                            </div>
                                                        </div>
                                                    </span>

                                                <!-- Подкатегории -->
                                                <div class="subcategories"
                                                     v-if="activeCategory === category.id && category.children?.length"
                                                     @mouseenter="cancelClose">
                                                    <div class="subcategory-column">
                                                        <a v-for="subcategory in category.children"
                                                           :key="subcategory.id"
                                                           :href="`/categories/${subcategory.id}/products`"
                                                           @mouseenter="showSubSubcategories(subcategory.id)">
                                                            {{ subcategory.title }}
                                                        </a>
                                                    </div>

                                                    <!-- Под-подкатегории -->
                                                    <div class="sub-subcategories"
                                                         v-if="activeSubcategory"
                                                         @mouseenter="cancelClose">
                                                        <div
                                                            v-for="subsubcategory in getSubSubcategories(activeSubcategory)"
                                                            :key="subsubcategory.id">
                                                            <a :href="`/catalog/${subsubcategory.url}/`">
                                                                {{ subsubcategory.title }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </a>
                                        </div>
                                    </div>
                                </section>
                            </div>

                        </nav>

                    </div>

                    <div class="col-xl-2"></div>

                </div>

            </div>


        </header>
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
                                                      :href="route('client.categories.products.index', product_count_subcategorie.id)"
                                                      class="">
                                                    {{ product_count_subcategorie.title }}
                                                    <span> {{ product_count_subcategorie.count_product }}</span><br>
                                                </Link>
                                            </div>
                                        </div>


                                        <div class="h3">Остаток</div>
                                        <div class="residue ">
                                            <div class="row__block">
                                                <label for="residue_from">от</label>
                                                <input type="text" name="count_from" id="residue_from">
                                                <label for="residue_to">до</label>
                                                <input type="text" name="count_to" id="residue_to">
                                            </div>
                                            <div class="row mgt10">
                                                <div id="residue_range"
                                                     class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                                                    <div class="ui-slider-range ui-corner-all ui-widget-header"
                                                         style="left: 0%; width: 100%;"></div>
                                                    <span tabindex="0"
                                                          class="ui-slider-handle ui-corner-all ui-state-default"
                                                          style="left: 0%;"></span><span tabindex="0"
                                                                                         class="ui-slider-handle ui-corner-all ui-state-default"
                                                                                         style="left: 100%;"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="h3">Склад</div>
                                        <div class="row">
                                            <ul id="warehouse">
                                                <li>
                                                    <input id="sklad_1" type="checkbox" name="sklad[]" value="Москва">
                                                    <label for="sklad_1">Москва</label>
                                                </li>
                                            </ul>

                                            <!--                                            <div class="h3">Цвет</div>
                                                                                        <div class="rows__color">
                                                                                            <input type="hidden" name="color" value="">

                                                                                            <div id="colors" class="">
                                                                                                <a class="" href="#" alt="бежевый" style="background: #f5f5dc"></a>
                                                                                                <a class="" href="#" alt="белый" style="background: #ffffff"></a>
                                                                                                <a class="" href="#" alt="бирюзовый" style="background: #30d5c8"></a>
                                                                                                <a class="" href="#" alt="бордовый" style="background: #9b2d30"></a>
                                                                                                <a class="" href="#" alt="голубой" style="background: #42aaff"></a>
                                                                                                <a class="" href="#" alt="желтый" style="background: #ffff00"></a>
                                                                                                <a class="" href="#" alt="зеленый" style="background: #008000"></a>
                                                                                                <a class="" href="#" alt="коричневый" style="background: #964b00"></a>
                                                                                                <a class="hidden" href="#" alt="красный" style="background: #ff0000"></a>
                                                                                                <a class="hidden" href="#" alt="оранжевый" style="background: #ffa500"></a>
                                                                                                <a class="hidden" href="#" alt="розовый" style="background: #ffc0cb"></a>

                                                                                                <a class="hidden" href="#" alt="светло-зеленый" style="background: #90ee90"> </a>
                                                                                                <a class="hidden" href="#" alt="серебряный" style="background: #c0c0c0"> </a>
                                                                                                <a class="hidden" href="#" alt="серый" style="background: #bbbbbb"></a>
                                                                                                <a class="hidden" href="#" alt="синий" style="background: #184a6d"> </a>
                                                                                                <a class="hidden" href="#" alt="темно-зеленый" style="background: #013220"></a>
                                                                                                <a class="hidden" href="#" alt="темно-коричневый" style="background: #654321"></a>


                                                                                                <a class="hidden" href="#" alt="темно-серый" style="background: #808080"></a>
                                                                                                <a class="hidden" href="#" alt="темно-синий" style="background: #002137"></a>
                                                                                                <a class="hidden" href="#" alt="фиолетовый" style="background: #8b00ff"></a>
                                                                                                <a class="hidden" href="#" alt="черный" style="background: #000000"></a>
                                                                                            </div>

                                                                                        </div>
                                                                                        <a href="#colors" class="more">
                                                                                            <span>Еще</span></a>-->
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

                                                    <div class="h3">Цена, <i class="fa fa-rub "></i></div>

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
                                               class="block text-center px-3 py-2 text-gray-300 bg-indigo-800 border border-indigo-900">Фильтр</a>


                                        </div>
                                    </div>
                                </form>
                            </aside>
                        </div>
                        <div class="product__card__block__main product__color">

                            <ProductItem v-for="product in productsData" :product="product"></ProductItem>

                        </div>
                    </div>
                </div>
            </section>

        </main>

    </div>
</template>


<script>
import {ref} from 'vue'

import MainLayout from '@/Layouts/MainLayout.vue';
import ProductItem from "@/Components/Client/Product/Productitem.vue";
import {Link} from "@inertiajs/vue3";

import noUiSlider from 'nouislider';
import 'nouislider/dist/nouislider.css';


export default {

    name: 'ProductIndex',
    layout: MainLayout,

    mounted() {
        this.initPriceSlider();
    },


    computed: {
        productWord() {
            const count = this.totalCount % 100;
            if (count >= 11 && count <= 19) return 'товаров';

            const lastDigit = count % 10;
            if (lastDigit === 1) return 'товар';
            if (lastDigit >= 2 && lastDigit <= 4) return 'товара';
            return 'товаров';
        }
    },

    components: {
        ProductItem,
        Link,
    },

    props: {
        catalogs: Object,
        products: Array,
        breadcrumbs: Array,
        subcategories: Array,
        product_count_subcategories: Array,
        categories: Array, //  дерево категорий
        params: Object,
        total_count: Number
    },

    data() {

        return {

            productsData: this.products,
            totalCount: this.total_count, // Или начальное значение
            filters: {
                integer: {
                    from: {},
                    to: {},
                },
                select: {},
                checkbox: {},

            },


        }
    },

    methods: {
        setFilter(item, value) {
            if (this.filters.checkbox[item.type]) {
                this.toggleItem(this.filters.checkbox[item.type], value)
                return;
            }

            this.filters.checkbox[item.type] = [];
            this.filters.checkbox[item.type].push(value);
        },

        toggleItem(arr, value) {
            let index = arr.indexOf(value);
            index === -1 ? arr.push(value) : arr.splice(index, 1);
        },

        //поиск по фильтру
        getPosts() {
            //this.clean(this.filters.integer.from);
            axios.get(route('client.categories.products.index', this.catalogs.id), {
                params: {
                    filters: this.filters
                }
            })
                .then(res => {
                    console.log('Полный ответ:', res); // Для отладки

                    // Проверяем разные форматы ответа
                    if (res.data.data && res.data.meta) {

                        this.productsData = res.data.data;
                        this.totalCount = res.data.meta.total_count;
                    } else {
                        console.error('Неизвестный формат ответа:', res.data);
                    }

                })


        },

        clean(obj) {
            Object.keys(obj).forEach(key => {

            })

        },


        initPriceSlider() {
            const slider = document.getElementById('price-slider');
            const paramType = 'drawing'; // или this.currentParamType если у вас несколько

            noUiSlider.create(slider, {
                start: [
                    this.filters.integer.from[paramType] || 0,
                    this.filters.integer.to[paramType] || 10000
                ],
                connect: true,
                range: {
                    'min': 0,
                    'max': 10000
                },
                step: 100
            });

            slider.noUiSlider.on('update', (values) => {
                this.filters.integer.from[paramType] = Math.round(values[0]);
                this.filters.integer.to[paramType] = Math.round(values[1]);
            });
        },

        // Добавим метод для обновления ползунка при изменении полей ввода
        updateSlider() {
            const slider = document.getElementById('price-slider');
            const paramType = 'drawing'; // или this.currentParamType

            if (slider && slider.noUiSlider) {
                slider.noUiSlider.set([
                    this.filters.integer.from[paramType] || 0,
                    this.filters.integer.to[paramType] || 10000
                ]);
            }
        },
        mounted() {
            this.$nextTick(() => {
                this.initPriceSlider();
            });
        }


    }

}


// Создаем реактивную ссылку для таймера закрытия меню
const closeTimer = ref(null)

// Функция открытия меню каталога
const openCatalogMenu = () => {
    // Сбрасываем таймер закрытия (если он был запущен)
    clearTimeout(closeTimer.value)
    // Устанавливаем флаг показа меню в true
    showCatalogDrop.value = true
}

// Функция закрытия меню каталога
const closeCatalogMenu = () => {
    // Устанавливаем таймер, который закроет меню через 3 секунды
    closeTimer.value = setTimeout(() => {
        // Скрываем меню
        showCatalogDrop.value = false
        // Сбрасываем активную категорию
        activeCategory.value = null
        // Сбрасываем активную подкатегорию
        activeSubcategory.value = null
    }, 3000) // Задержка 3 секунды перед закрытием
}

// Функция отмены закрытия меню
const cancelClose = () => {
    // Сбрасываем таймер закрытия
    clearTimeout(closeTimer.value)
}

// Функция запуска таймера закрытия
const startCloseTimer = () => {
    // Вызываем функцию закрытия меню
    closeCatalogMenu()
}

// Реактивное состояние для отображения/скрытия меню каталога
const showCatalogDrop = ref(false)

// Реактивное состояние для хранения ID активной категории
const activeCategory = ref(null)

// Реактивное состояние для хранения ID активной подкатегории
const activeSubcategory = ref(null)

// Функция отображения подкатегорий для выбранной категории
const showSubcategories = (categoryId) => {
    // Устанавливаем активную категорию
    activeCategory.value = categoryId
    // Сбрасываем активную подкатегорию
    activeSubcategory.value = null
}

// Функция отображения под-подкатегорий для выбранной подкатегории
const showSubSubcategories = (subcategoryId) => {
    // Устанавливаем активную подкатегорию
    activeSubcategory.value = subcategoryId
}

// Функция получения под-подкатегорий для выбранной подкатегории
const getSubSubcategories = (subcategoryId) => {
    // Ищем активную категорию в переданных props.categories
    const category = props.categories.find(c => c.id === activeCategory.value)
    // Если категория не найдена - возвращаем пустой массив
    if (!category) return []

    // Ищем подкатегорию в children активной категории
    const subcategory = category.children.find(sc => sc.id === subcategoryId)
    // Возвращаем children подкатегории или пустой массив, если их нет
    return subcategory?.children || []
}


</script>


<script setup>

// Импортируем необходимые функции из Vue
import {ref, onMounted} from 'vue'

// Создаем реактивное состояние для отслеживания видимости выпадающего меню
const showCatalogDrop = ref(false)

// Создаем реактивное состояние для отслеживания монтирования компонента
const mounted = ref(false)

// Создаем реактивную ссылку для хранения таймера закрытия
const closeTimer = ref(null)

// Создаем реактивное состояние для отслеживания наведения курсора
const isHovering = ref(false)

// Хук жизненного цикла, срабатывает после монтирования компонента
onMounted(() => {
    // Устанавливаем флаг монтирования в true
    mounted.value = true
})

// Функция открытия меню каталога
const openCatalogMenu = () => {
    // Очищаем предыдущий таймер закрытия (если был)
    clearTimeout(closeTimer.value)
    // Показываем выпадающее меню
    showCatalogDrop.value = true
    // Устанавливаем флаг наведения в true
    isHovering.value = true
}

// Функция закрытия меню каталога
const closeCatalogMenu = () => {
    // Устанавливаем новый таймер закрытия
    closeTimer.value = setTimeout(() => {
        // Проверяем, что курсор больше не наводится
        if (!isHovering.value) {
            // Скрываем выпадающее меню
            showCatalogDrop.value = false
        }
    }, 300) // Задержка 300 мс перед закрытием
}

// Функция обработки наведения на меню
const handleMenuMouseEnter = () => {
    // Устанавливаем флаг наведения в true
    isHovering.value = true
    // Очищаем таймер закрытия (чтобы меню не закрылось)
    clearTimeout(closeTimer.value)
}

// Функция обработки ухода курсора с меню
const handleMenuMouseLeave = () => {
    // Устанавливаем флаг наведения в false
    isHovering.value = false
    // Запускаем таймер закрытия меню
    closeCatalogMenu()
}


</script>

<style>


.catalog_drop {
    position: absolute;
    background: white;
    z-index: 1000;
    width: 100%;
    left: 0;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: opacity 0.3s ease;
}

.subcategories {
    position: absolute;
    left: 100%;
    top: 0;
    background: white;
    min-width: 250px;
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1);
    padding: 0;
}

.sub-subcategories {
    position: absolute;
    left: 100%;
    top: 0;
    background: white;
    min-width: 250px;
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1);
    padding: 15px;
}

/* Для плавного появления/исчезновения */
.catalog-enter-active, .catalog-leave-active {
    transition: all 0.3s;
}

.catalog-enter-from, .catalog-leave-to {
    opacity: 0;
    transform: translateY(10px);
}

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
    height: 100%;
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
    left: 100%;
    top: -10px;
    background: white;
    min-width: 250px;
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1);
    padding: 10px 0 0 0;
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
    padding: 10px 10px;
    text-transform: uppercase;
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

</style>

