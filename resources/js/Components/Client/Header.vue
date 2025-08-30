<template>
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
                                        <img src="/img/cart.png" alt="">
                                    </div>
                                    <div class="header__top__info">
                                        <p class="min__order"> Минимальный заказ</p>
                                        <p class="rub">15 0007 Р </p>
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
                    <img src="https://web-ruslan.ru/img/logo.png" alt="logo">
                </div>
                <div class="col-xl-8 ">

                    <button class="navbar-toggler ds-mob" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="input-group">
                        <input type="text"
                               class="form-control"
                               placeholder="Поиск товаров по названию или артикулу"
                               v-model="searchQuery"
                               @input="handleSearchInput"
                               @focus="showSearchResults = true"
                               @blur="hideSearchResults">

                        <div class="input-group-append">

                            <button class="btn btn-secondary" type="button">
                                <img src="https://web-ruslan.ru/img/ser.png" alt="search">
                            </button>

                        </div>

                        <!-- Результаты поиска -->
                        <div
                            class="search-results-dropdown"
                            v-show="showSearchResults && searchResults.length > 0"
                            @mouseenter="keepResultsVisible"
                            @mouseleave="hideSearchResults">

                            <div
                                class="search-result-item"
                                v-for="result in searchResults"
                                :key="result.id">

                                <Link :href="route('client.products.show', result.url)">
                                    {{ result.title }} ({{ result.article }})
                                </Link>
                            </div>
                        </div>

                        <div class="search-results-dropdown" v-show="showSearchResults">
                            <div v-if="searchLoading" class="search-loading">
                                Загрузка...
                            </div>
                            <template v-else>

                                <div v-if="searchResults.length === 0 && searchQuery" class="no-results">
                                    Ничего не найдено
                                </div>
                            </template>
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

                                        <section v-if="showCatalogDrop" class="catalog_drop"
                                                 @mouseenter="handleMenuMouseEnter"
                                                 @mouseleave="handleMenuMouseLeave">
                                            <div class="wrap_c">
                                                <div class="list">

                                                    <a :href="`/categories/${category.url}/products`" class="item"
                                                       v-for="category in categories" :key="category.id"
                                                       @mouseenter="showSubcategories(category.id)">


                                                        <div class="table">
                                                            <div class="margin">
                                                                <p style="text-transform: uppercase;">

                                                                    {{category.title }}

                                                                </p>
                                                            </div>
                                                        </div>


                                                        <!-- Подкатегории -->
                                                        <div class="subcategories"
                                                             v-if="activeCategory === category.id && category.children?.length"
                                                             @mouseenter="cancelClose">
                                                            <div class="subcategory-column">
                                                                <a v-for="subcategory in category.children"
                                                                   :key="subcategory.id"
                                                                   :href="`/categories/${subcategory.url}/products`"
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
                                        <a class="nav-link" href="/news">НОВОСТИ</a>
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

                        </div>

                    </nav>

                </div>

                <div class="col-xl-2"></div>

            </div>

        </div>


    </header>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'

// Определяем props, которые будет принимать компонент
const props = defineProps({
    categories: Array
})

// Реактивные состояния для header
const showCatalogDrop = ref(false)       // Показывать/скрывать выпадающее меню каталога
const activeCategory = ref(null)         // ID активной категории
const activeSubcategory = ref(null)      // ID активной подкатегории
const closeTimer = ref(null)             // Таймер для закрытия меню
const isHovering = ref(false)            // Флаг наведения на меню

// Состояния для поиска
const searchQuery = ref('')
const searchResults = ref([])
const showSearchResults = ref(false)
const searchDebounce = ref(null)
const searchLoading = ref(false)

// Функции для работы с каталогом
const openCatalogMenu = () => {
    clearTimeout(closeTimer.value)      // Сброс таймера закрытия
    showCatalogDrop.value = true        // Показать меню
    isHovering.value = true            // Установить флаг наведения
}

const closeCatalogMenu = () => {
    closeTimer.value = setTimeout(() => { // Запустить таймер закрытия
        if (!isHovering.value) {          // Если не наведено
            showCatalogDrop.value = false // Скрыть меню
            activeCategory.value = null   // Сбросить активную категорию
            activeSubcategory.value = null // Сбросить подкатегорию
        }
    }, 300) // Задержка 300мс
}


const handleMenuMouseEnter = () => {
    isHovering.value = true          // Установить флаг наведения
    clearTimeout(closeTimer.value)   // Сбросить таймер закрытия
}

const handleMenuMouseLeave = () => {
    isHovering.value = false         // Сбросить флаг наведения
    closeCatalogMenu()               // Запустить закрытие меню
}

//Работа с подкатегориями:

const showSubcategories = (categoryId) => {
    activeCategory.value = categoryId      // Установить активную категорию
    activeSubcategory.value = null         // Сбросить подкатегорию
}

const showSubSubcategories = (subcategoryId) => {
    activeSubcategory.value = subcategoryId// Установить активную подкатегорию
}

const getSubSubcategories = (subcategoryId) => {
    // Найти под-подкатегории для активной подкатегории
    if (!activeCategory.value) return []

    const category = props.categories.find(c => c.id === activeCategory.value)
    if (!category || !category.children) return []

    const subcategory = category.children.find(sc => sc.id === subcategoryId)
    return subcategory?.children || []
}

const cancelClose = () => {
    clearTimeout(closeTimer.value)// Отменить закрытие меню
}

// Методы для поиска
const handleSearchInput = () => {
    // Очищаем предыдущий таймер
    clearTimeout(searchDebounce.value)

    // Если запрос пустой, очищаем результаты
    if (!searchQuery.value.trim()) {
        searchResults.value = []
        return
    }

    // Устанавливаем новый таймер для задержки запроса
    searchDebounce.value = setTimeout(() => {
        searchProducts()
    }, 300) // Задержка 300мс
}

const searchProducts = async () => {
    if (!searchQuery.value.trim()) {
        searchResults.value = []
        return
    }

    searchLoading.value = true
    try {
        const response = await axios.get(route('client.products.search'), {
            params: {
                query: searchQuery.value
            }
        })
        searchResults.value = response.data
    } catch (error) {
        console.error('Search error:', error)
        searchResults.value = []
    } finally {
        searchLoading.value = false
    }
}

const hideSearchResults = () => {
    setTimeout(() => {
        showSearchResults.value = false
    }, 200)
}

const keepResultsVisible = () => {
    showSearchResults.value = true
}

onMounted(() => {
    // Инициализация компонента после монтирования
})
</script>

<style>

</style>
