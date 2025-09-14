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
                                <div class="header__top__cart" @click="cartStore.toggleCart()">
                                    <div class="header__top__img">
                                        <img src="/img/cart.png" alt="">
                                        <span id="cart_qty" v-if="cartStore.totalItems > 0">{{ cartStore.totalItems }}</span>
                                    </div>
                                    <div class="header__top__info">
                                        <p class="min__order">Минимальный заказ</p>
                                        <p class="rub">15 000 Р</p>
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
                            <button class="btn btn-secondary" type="button" @click="submitSearch">
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
                            <div class="search-result-item view-all" v-if="searchQuery">
                                <a href="#" @click.prevent="goToSearchPage">
                                    Все результаты по запросу "{{ searchQuery }}"
                                </a>
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

                <!-- Это будет общий блок, видимый только на мобилке -->
                <div class="nav-item catalog mobile-only" @click="toggleMobileCatalog">
                    <a class="nav-link" href="#">КАТАЛОГ</a>
                    <span></span>
                </div>

                <!-- Мобильное меню каталога -->
                <div v-if="showMobileCatalog" class="mobile-catalog-menu">
                    <button class="close-btn" @click="toggleMobileCatalog">Закрыть</button>

                    <ul class="mobile-catalog-list">
                        <li v-for="category in categories" :key="category.id">
                            <!-- Категория -->
                            <div class="category-title" @click="toggleMobileSubcategory(category.id)">
                                {{ category.title }}
                            </div>

                            <!-- Подкатегории -->
                            <ul v-if="mobileActiveCategory === category.id && category.children?.length">
                                <li v-for="subcategory in category.children" :key="subcategory.id">
                                    <!-- теперь это ссылка -->
                                    <a
                                        class="subcategory-title"
                                        :href="`/categories/${subcategory.url}/products`"
                                        @click.stop="toggleMobileSubSubcategory(subcategory.id)"
                                    >
                                        {{ subcategory.title }}
                                    </a>

                                    <!-- Под-подкатегории -->
                                    <ul v-if="mobileActiveSubcategory === subcategory.id">
                                        <li v-for="subsubcategory in getSubSubcategories(subcategory.id)" :key="subsubcategory.id">
                                            <a :href="`/categories/${subsubcategory.url}/products`">
                                                {{ subsubcategory.title }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>

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
                                        <a class="nav-link" href="/portfolio">ПОРТФОЛИО</a>
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
        <!-- Popup корзины -->
        <div v-if="cartStore.isOpen" class="cart-popup-overlay" @click.self="cartStore.closeCart()">
            <div class="cart-popup">
                <div class="cart-popup-header">
                    <h3>Корзина</h3>
                    <button class="close-cart" @click="cartStore.closeCart()">×</button>
                </div>

                <div class="cart-popup-content">
                    <!-- Блок для отображения успешных сообщений -->
                    <div v-if="successMessage" class="success-message">
                        {{ successMessage }}
                    </div>

                    <!-- Блок для отображения ошибок -->
                    <div v-if="errorMessage" class="error-message">
                        {{ errorMessage }}
                        <button class="error-close" @click="errorMessage = ''">×</button>
                    </div>

                    <div v-if="cartStore.items.length === 0" class="empty-cart">
                        Корзина пуста
                    </div>

                    <div v-else>
                        <div v-for="(item, index) in cartStore.items" :key="index" class="cart-item">
                            <div class="cart-item-image">
                                <img :src="item.image" :alt="item.title">
                            </div>

                            <div class="cart-item-details">
                                <h4>{{ item.title }}</h4>
                                <p>Цвет: {{ item.color }}, Размер: {{ item.size }}</p>
                                <p>Артикул: {{ item.article }}</p>

                                <!-- Переключатель нанесения -->
                                <div class="printing-option">
<!--                                    <span class="printing-label">Нанесение:</span>-->
                                    <div class="printing-buttons">
                                        <button
                                            :class="{ 'printing-btn': true, 'active': !item.withPrinting }"
                                            @click="setPrinting(index, false)"
                                        >
                                            Без нанесения
                                        </button>
                                        <button
                                            :class="{ 'printing-btn': true, 'active': item.withPrinting }"
                                            @click="setPrinting(index, true)"
                                        >
                                            С нанесением (+ {{ cartStore.printingCost }} ₽)
                                        </button>
                                    </div>
                                </div>

                                <div class="cart-item-price">
                                    {{ itemPrice(item) }} ₽ × {{ item.quantity }} = {{ (itemPrice(item) * item.quantity) }} ₽
                                </div>
                            </div>

                            <div class="cart-item-controls">
                                <div class="quantity-controls">
                                    <button @click="cartStore.updateQuantity(index, item.quantity - 1)">-</button>
                                    <span>{{ item.quantity }}</span>
                                    <button @click="cartStore.updateQuantity(index, item.quantity + 1)">+</button>
                                </div>
                                <button class="remove-item" @click="cartStore.removeItem(index)">Удалить</button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="cart-popup-footer" v-if="cartStore.items.length > 0">
                    <!-- Форма для данных пользователя -->
                    <form @submit.prevent="submitOrder" class="order-form">
                        <div class="form-group">
                            <label for="name"></label>
                            <input
                                type="text"
                                id="name"
                                v-model="orderForm.name"
                                placeholder="Ваше имя"
                            >
                        </div>

                        <div class="form-group">
                            <label for="phone"></label>
                            <input
                                type="tel"
                                id="phone"
                                v-model="orderForm.phone"
                                placeholder="+7 (999) 999-99-99"
                            >
                        </div>

                        <div class="form-group">
                            <label for="email"></label>
                            <input
                                type="email"
                                id="email"
                                v-model="orderForm.email"
                                placeholder="your@email.com"
                            >
                        </div>

                        <div class="form-group checkbox">
                            <input
                                type="checkbox"
                                id="privacy"
                                v-model="orderForm.agreedToPrivacy"
                            >
                            <label for="privacy">
                                Я согласен с <a style="text-decoration: underline " href="/privacy-policy" target="_blank">политикой конфиденциальности</a>
                            </label>
                        </div>

                        <div class="cart-total">
                            Общая сумма: {{ cartStore.totalPrice }} Р
<!--                            <div v-if="hasPrinting" class="printing-total">
                                (включая нанесение: {{ printingTotal }} ₽)
                            </div>-->
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary submit-btn btn__red"
                        >
                            Оформить заказ
                        </button>
                    </form>
                </div>
            </div>
        </div>


    </header>
</template>

<script setup>
import { ref, computed, watch, onMounted, reactive} from 'vue'
import { Link, router } from '@inertiajs/vue3'
import axios from 'axios'
import { useCartStore } from '@/store/cart'




const cartStore = useCartStore()
// Данные формы заказа
const orderForm = reactive({
    name: '',
    phone: '',
    email: '',
    agreedToPrivacy: false
})

// Отправка заказа
const errorMessage = ref('')
const successMessage = ref('');

// Обновите метод submitOrder
async function submitOrder() {

    // Сброс предыдущей ошибки
    errorMessage.value = ''

    if (!orderForm.name) {
        errorMessage.value = 'Введите имя'
        return;
    }

    if (!orderForm.phone) {
        errorMessage.value = 'Введите телефон'
        return;
    }

    if (!orderForm.email) {
        errorMessage.value = 'Введите email'
        return;
    }


    if (!orderForm.agreedToPrivacy) {
        console.log('Нет согласия с политикой');
        errorMessage.value = 'Необходимо согласие с политикой конфиденциальности'
        return;
    }

    // Проверка заполнения обязательных полей
    if (!orderForm.name || !orderForm.phone || !orderForm.email) {
        errorMessage.value = 'Заполните все обязательные поля'
        return;
    }

    const orderData = {
        name: orderForm.name,
        phone: orderForm.phone,
        email: orderForm.email,
        agreed_to_privacy: orderForm.agreedToPrivacy,
        items: cartStore.items.map(item => ({
            id: item.id,
            title: item.title,
            price: item.price,
            with_printing: item.withPrinting,
            printing_cost: item.withPrinting ? cartStore.printingCost : 0,
            color: item.color,
            size: item.size,
            quantity: item.quantity,
            article: item.article,
            image: item.image
        })),
        total_price: cartStore.totalPrice
    }

    try {
        const result = await cartStore.submitOrder(orderData)

        if (result.success) {
            // Показываем сообщение об успехе
            successMessage.value = result.message;

            // Ждем 2 секунды перед закрытием корзины, чтобы пользователь увидел сообщение
            setTimeout(() => {
                // Сброс формы
                Object.assign(orderForm, {
                    name: '',
                    phone: '',
                    email: '',
                    agreedToPrivacy: false
                });

                // Закрытие корзины после успешного заказа
                cartStore.closeCart();

                // Очищаем сообщение об успехе
                successMessage.value = '';
            }, 2000);
        }

        else {
            errorMessage.value = result.message
        }
    } catch (error) {
        errorMessage.value = 'Произошла ошибка при отправке заказа'
        console.error('Ошибка при отправке заказа:', error)
    }
}

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

// Функция для перехода на страницу поиска (использует Inertia)
const goToSearchPage = () => {
    if (searchQuery.value.trim()) {
        router.get(route('client.products.search-page'), {
            query: searchQuery.value.trim()
        })
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
            /*{ id: 1, url: 'tampopechat', title: 'Тампопечать' },
            { id: 2, url: 'tisnenie', title: 'Тиснение' },
            { id: 3, url: 'gravirovka', title: 'Гравировка' },
            { id: 4, url: 'shelkografiya', title: 'Шелкография' },
            { id: 5, url: 'dekol', title: 'Деколь' },
            { id: 6, url: 'cifrovaya-pechat', title: 'Цифровая печать' },
            { id: 7, url: 'vyshivka', title: 'Вышивка' },
            { id: 8, url: 'uf-pechat', title: 'УФ печать' }*/
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


//метод для установки нанесения
function setPrinting(index, withPrinting) {
    if (cartStore.items[index].withPrinting === withPrinting) return;
    cartStore.togglePrinting(index);
}

//метод для расчета цены товара
function itemPrice(item) {
    return item.price + (item.withPrinting ? cartStore.printingCost : 0);
}

//вычисляемые свойства для отображения информации о нанесении
const hasPrinting = computed(() => {
    return cartStore.items.some(item => item.withPrinting);
});

const printingTotal = computed(() => {
    return cartStore.items.reduce((total, item) => {
        return total + (item.withPrinting ? cartStore.printingCost * item.quantity : 0);
    }, 0);
});











</script>


<script>
export default {
    data() {
        return {
            showMobileCatalog: false,
            mobileActiveCategory: null,
            mobileActiveSubcategory: null,
        };
    },
    methods: {
        toggleMobileCatalog() {
            this.showMobileCatalog = !this.showMobileCatalog;
            this.mobileActiveCategory = null;
            this.mobileActiveSubcategory = null;
        },
        toggleMobileSubcategory(categoryId) {
            this.mobileActiveCategory =
                this.mobileActiveCategory === categoryId ? null : categoryId;
            this.mobileActiveSubcategory = null;
        },
        toggleMobileSubSubcategory(subcategoryId) {
            this.mobileActiveSubcategory =
                this.mobileActiveSubcategory === subcategoryId ? null : subcategoryId;
        },
        getSubSubcategories(subcategoryId) {
            const category = this.categories.find((cat) =>
                cat.children?.some((child) => child.id === subcategoryId)
            );
            const subcategory = category?.children?.find(
                (child) => child.id === subcategoryId
            );
            return subcategory?.children || [];
        },
    },
};
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



/* Стили для корзины */
.cart-popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: flex-end;
    z-index: 10000;

}

.cart-popup {
    width: 400px;
    height: 100%;
    background-color: white;
    display: flex;
    flex-direction: column;
    overflow-y:  auto;
}

.cart-popup-header {
    padding: 15px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.close-cart {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
}

.cart-popup-content {
    flex: 1;
    overflow-y: auto;
    padding: 15px;
}

.empty-cart {
    text-align: center;
    padding: 30px;
    color: #666;
}

.cart-item {
    display: flex;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.cart-item-image {
    width: 80px;
    height: 80px;
    margin-right: 15px;
}

.cart-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cart-item-details {
    flex: 1;
}

.cart-item-details h4 {
    margin: 0 0 5px 0;
    font-size: 14px;
}

.cart-item-details p {
    margin: 0 0 3px 0;
    font-size: 14px;
    color: #666;
}

.cart-item-price {
    font-weight: bold;
    margin-top: 5px;
}

.cart-item-controls {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: flex-end;
}

.quantity-controls {
    display: flex;
    align-items: center;
}

.quantity-controls button {
    width: 25px;
    height: 25px;
    background: #f5f5f5;
    border: 1px solid #ddd;
    cursor: pointer;
}

.quantity-controls span {
    margin: 0 10px;
}

.remove-item {
    background: none;
    border: none;
    color: #e53935;
    cursor: pointer;
    font-size: 12px;
}

.cart-popup-footer {
    padding: 15px;
    border-top: 1px solid #eee;
}

.cart-total {
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 5px;
    text-align: center;
}

.header__top__img {
    position: relative;
    cursor: pointer;
}

#cart_qty {
    position: absolute;
    top: -8px;
    right: 2px;
    background-color: #e53935;
    color: white;
    border-radius: 50%;
    width: 17px;
    height: 17px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}
.header__top span{
    padding: 0 3px 0 0!important;
}

/* Стили для формы */
.order-form {
    padding: 0px 0;
}

.form-group {
    margin-bottom: 7px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input[type="text"],
.form-group input[type="tel"],
.form-group input[type="email"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

.form-group.checkbox {
    display: flex;
    align-items: center;
}

.form-group.checkbox input {
    margin-right: 10px;
}

.form-group.checkbox label {
    margin-bottom: 0;
    font-weight: normal;
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}


.error-message {
    background-color: #ffebee;
    color: #c62828;
    padding: 12px;
    border-radius: 4px;
    margin-bottom: 15px;
    border-left: 4px solid #c62828;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.error-close {
    background: none;
    border: none;
    color: #c62828;
    font-size: 18px;
    cursor: pointer;
    padding: 0;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.success-message {
    background-color: #e8f5e9;
    color: #2e7d32;
    padding: 12px;
    border-radius: 4px;
    margin-bottom: 15px;
    border-left: 4px solid #2e7d32;
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}


/*********************************/
.printing-option {
    margin: 10px 0;
    display: flex;
    align-items: center;
}

.printing-label {
    font-weight: bold;
    margin-right: 10px;
    min-width: 80px;
}

.printing-buttons {
    display: flex;
    gap: 10px;
}

.printing-btn {
    padding: 0px 1px;
    border: 1px solid #ddd;
    background: #f5f5f5;
    cursor: pointer;
    border-radius: 4px;
    transition: all 0.3s ease;
    font-size: 10px;
}

.printing-btn.active {
    background: #3498db;
    color: white;
    border-color: #3498db;
}

.printing-btn:hover {
    background: #e0e0e0;
}

.printing-btn.active:hover {
    background: #2980b9;
}

.printing-total {
    font-size: 0.8em;
    color: #666;
    margin-top: 5px;
}
.form-group checkbox{
    cursor: pointer;
}


/*********************************************/
/* Скрыть блок по умолчанию, кроме мобилок */
.mobile-only {
    display: none;
}

/* Показать на мобилке */
@media (max-width: 768px) {
    .mobile-only {
        display: block;
    }

    .mobile-catalog-menu {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: white;
        z-index: 1000;
        overflow-y: auto;
        padding: 20px;
    }

    .mobile-catalog-menu .close-btn {
        background: none;
        border: none;
        font-size: 18px;
        margin-bottom: 10px;
    }

    .mobile-catalog-list li {
        margin-bottom: 10px;
    }

    .category-title,
    .subcategory-title {
        font-weight: bold;
        cursor: pointer;
    }
    /* Базовый список */
    .mobile-catalog-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    /* Категории */
    .mobile-catalog-list > li {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }

    /* Заголовок категории */
    .category-title {
        font-weight: bold;
        font-size: 16px;
        padding: 5px 0;
    }

    /* Подкатегории */
    .mobile-catalog-list ul {
        list-style: none;
        padding-left: 15px; /* смещение вправо */
        margin-top: 5px;
        border-left: 2px solid #eee; /* визуальное выделение вложенности */
    }

    /* Заголовок подкатегории */
    .subcategory-title {
        font-size: 14px;
        font-weight: 500;
        padding: 5px 0;
    }

    /* Под-подкатегории */
    .mobile-catalog-list ul ul {
        padding-left: 20px; /* ещё глубже */
        border-left: 2px dashed #ddd;
    }

    /* Ссылки */
    .mobile-catalog-list a {
        display: block;
        padding: 5px 0;
        font-size: 13px;
        color: #333;
        text-decoration: none;
    }

    .mobile-catalog-list a:hover {
        color: #007bff;
    }
}
/*********************************************/

</style>
