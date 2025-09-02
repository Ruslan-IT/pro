<template>
    <header class="header">
        <!-- Верхняя часть header -->
        <div class="row header__top__block__main">
            <div class="container__header">
                <div class="container__header__flex">
                    <div class="">
                        <div class="header__top d-flex">
                            <!-- Мобильный телефон -->
                            <div class="d-block d-md-none">
                                <a href="tel:+74993943841" class="header__phone">8 (499) 394-38-41</a>
                            </div>

                            <span class="company">|</span>
                            <div class="header__top__block company">
                                <a href="">О компании</a>
                            </div>
                            <span>|</span>
                            <div class="header__top__block">
                                <button type="submit" class="btn btn-primary submit-btn btn__red">ЗАКАЗАТЬ ЗВОНОК</button>
                            </div>
                            <span>|</span>
                            <div class="header__top__block">
                                <div class="header__top__cart">
                                    <div class="header__top__img">
                                        <img src="/img/cart.png" alt="">
                                    </div>
                                    <div class="header__top__info">
                                        <p class="min__order">Минимальный заказ</p>
                                        <p class="rub">15 0007 Р</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Поиск и логотип -->
        <div class="container">
            <div class="row header__search">
                <div class="col-xl-2">
                    <img src="https://web-ruslan.ru/img/logo.png" alt="logo">
                </div>
                <div class="col-xl-8">
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
                        <div class="search-results-dropdown"
                             v-show="showSearchResults && searchResults.length > 0"
                             @mouseenter="keepResultsVisible"
                             @mouseleave="hideSearchResults">
                            <div class="search-result-item"
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
                        <a href="">8 (499) 394 38 41</a>
                    </span>
                </div>
                <div class="catalogmobile__my">
                    <div class="nav-item catalog">
                        <a class="nav-link" href="#">КАТАЛОГ</a>
                        <span></span>
                    </div>
                </div>
            </div>

            <!-- Основное меню -->
            <div class="row header__menu">
                <div class="col-xl-2"></div>
                <div class="col-xl-8">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="container-fluid header__menu">
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav">
                                    <!-- Каталог -->
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
                                                                    {{ category.title }}
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
                                                                <div v-for="subsubcategory in getSubSubcategories(activeSubcategory)"
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

                                    <!-- Портфолио -->
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">ПОРТФОЛИО</a>
                                    </li>

                                    <!-- Нанесение -->
                                    <li class="nav-item drawing-menu"
                                        @mouseenter="openDrawingMenu"
                                        @mouseleave="closeDrawingMenu">
                                        <a class="nav-link" href="#">НАНЕСЕНИЕ</a>
                                        <span></span>

                                        <!-- Выпадающее меню нанесения -->
                                        <div v-if="showDrawingDropdown" class="drawing-dropdown">
                                            <div class="drawing-dropdown-content">
                                                <Link v-for="drawing in drawingsToShow"
                                                      :key="drawing.id"
                                                      :href="route('client.drawing.show', drawing.url)"
                                                      class="drawing-dropdown-item">
                                                    {{ drawing.title }}
                                                </Link>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- Остальные пункты меню -->
                                    <li class="nav-item">
                                        <Link class="nav-link" :href="route('client.contacts.index')">КОНТАКТЫ</Link>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/news">НОВОСТИ</a>
                                    </li>
                                    <li class="nav-item">
                                        <Link class="nav-link" :href="route('client.payment-delivery.index')">ОПЛАТА И ДОСТАВКА</Link>
                                    </li>

                                    <!-- Дополнительные пункты меню (только для десктопа) -->
                                    <li class="nav-item nav__block__none">
                                        <a class="more_menu nav-link" href="#">Преимущества</a>
                                    </li>
                                    <li class="nav-item nav__block__none">
                                        <a class="more_menu nav-link" href="#">Награды</a>
                                    </li>
                                    <li class="nav-item nav__block__none">
                                        <a class="more_menu nav-link" href="#">Благодарности</a>
                                    </li>
                                    <li class="nav-item nav__block__none">
                                        <a class="more_menu nav-link" href="#">Новости</a>
                                    </li>
                                    <li class="nav-item nav__block__none">
                                        <a class="more_menu nav-link" href="#">Статьи</a>
                                    </li>
                                    <li class="nav-item nav__block__none">
                                        <a class="more_menu nav-link" href="#">Вопросы и ответы</a>
                                    </li>

                                    <li class="nav-item nav__block__none menu__phone">
                                        <a class="nav-link" href="#">8 (499) 394 38 41</a>
                                    </li>
                                    <li class="nav-item nav__block__none">
                                        <a class="nav-link menu__email" href="#">info@mvgifts.ru</a>
                                    </li>
                                </ul>

                                <!-- Кнопка закрытия для мобильного меню -->
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
import { ref, computed, watch, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import axios from 'axios'

// Определяем props
const props = defineProps({
    categories: Array,
    drawings: Array
})

// Реактивные состояния для каталога
const showCatalogDrop = ref(false)
const activeCategory = ref(null)
const activeSubcategory = ref(null)
const closeTimer = ref(null)
const isHovering = ref(false)

// Реактивные состояния для поиска
const searchQuery = ref('')
const searchResults = ref([])
const showSearchResults = ref(false)
const searchDebounce = ref(null)
const searchLoading = ref(false)

// Реактивные состояния для меню нанесения
const showDrawingDropdown = ref(false)
const localDrawings = ref([])

// Вычисляемое свойство для отображаемых видов нанесения
const drawingsToShow = computed(() => {
    return localDrawings.value.length > 0 ? localDrawings.value : (props.drawings || [])
})

// Следим за изменениями props.drawings
watch(() => props.drawings, (newDrawings) => {
    if (newDrawings && newDrawings.length > 0) {
        localDrawings.value = newDrawings
    }
}, { immediate: true })

// Функции для работы с каталогом
const openCatalogMenu = () => {
    clearTimeout(closeTimer.value)
    showCatalogDrop.value = true
    isHovering.value = true
}

const closeCatalogMenu = () => {
    closeTimer.value = setTimeout(() => {
        if (!isHovering.value) {
            showCatalogDrop.value = false
            activeCategory.value = null
            activeSubcategory.value = null
        }
    }, 300)
}

const handleMenuMouseEnter = () => {
    isHovering.value = true
    clearTimeout(closeTimer.value)
}

const handleMenuMouseLeave = () => {
    isHovering.value = false
    closeCatalogMenu()
}

const showSubcategories = (categoryId) => {
    activeCategory.value = categoryId
    activeSubcategory.value = null
}

const showSubSubcategories = (subcategoryId) => {
    activeSubcategory.value = subcategoryId
}

const getSubSubcategories = (subcategoryId) => {
    if (!activeCategory.value) return []

    const category = props.categories.find(c => c.id === activeCategory.value)
    if (!category || !category.children) return []

    const subcategory = category.children.find(sc => sc.id === subcategoryId)
    return subcategory?.children || []
}

const cancelClose = () => {
    clearTimeout(closeTimer.value)
}

// Функции для поиска
const handleSearchInput = () => {
    clearTimeout(searchDebounce.value)

    if (!searchQuery.value.trim()) {
        searchResults.value = []
        return
    }

    searchDebounce.value = setTimeout(() => {
        searchProducts()
    }, 300)
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

// Функции для меню нанесения
const openDrawingMenu = async () => {
    // Если данные уже есть, просто показываем меню
    if (localDrawings.value.length > 0) {
        showDrawingDropdown.value = true
        return
    }

    // Если данных нет, пытаемся загрузить
    try {
        const response = await axios.get(route('client.drawing.list'))
        localDrawings.value = response.data
        showDrawingDropdown.value = true
    } catch (error) {
        console.error('Failed to fetch drawings', error)
        // В случае ошибки используем статичный список
        localDrawings.value = [
            { id: 1, url: 'tampopechat', title: 'Тампопечать' },
            { id: 2, url: 'tisnenie', title: 'Тиснение' },
            { id: 3, url: 'gravirovka', title: 'Гравировка' },
            { id: 4, url: 'shelkografiya', title: 'Шелкография' },
            { id: 5, url: 'dekol', title: 'Деколь' },
            { id: 6, url: 'cifrovaya-pechat', title: 'Цифровая печать' },
            { id: 7, url: 'vyshivka', title: 'Вышивка' },
            { id: 8, url: 'uf-pechat', title: 'УФ печать' }
        ]
        showDrawingDropdown.value = true
    }
}

const closeDrawingMenu = () => {
    setTimeout(() => {
        showDrawingDropdown.value = false
    }, 300)
}

onMounted(() => {
    // Инициализация компонента после монтирования
})
</script>

<style>
/* Стили для выпадающего меню нанесения */
.drawing-menu {
    position: relative;
}

.drawing-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    z-index: 1000;
    min-width: 200px;
}

.drawing-dropdown-content {
    padding: 10px 0;
}

.drawing-dropdown-item {
    display: block;
    padding: 8px 20px;
    color: #333;
    text-decoration: none;
    transition: all 0.3s ease;
}

.drawing-dropdown-item:hover {
    background: #f5f5f5;
    color: #e53935;
}

/* Остальные стили остаются без изменений */
</style>
