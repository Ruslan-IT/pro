<style>
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
@import url('https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');
@import url('https://web-ruslan.ru/css/catalog.css');
@import url('https://web-ruslan.ru/css/style.css');
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
                                            <img src="https://web-ruslan.ru/img/cart.png" alt="">
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
                        <img src="https://web-ruslan.ru/img/logo.png" alt="logo">
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
                                    <img src="https://web-ruslan.ru/img/ser.png" alt="search">
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

<!--                    <div class="col-xl-8">
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
                                    &lt;!&ndash; Кнопка закрытия (крестик) - видна только в мобильном меню &ndash;&gt;
                                    <button class="btn-close d-lg-none ms-auto" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#navbarNav" aria-controls="navbarNav"
                                            aria-label="Close"></button>
                                </div>
                                <section v-if="showCatalogDrop" class="catalog_drop"
                                         @mouseenter="handleMenuMouseEnter"
                                         @mouseleave="handleMenuMouseLeave">
                                    <div class="wrap_c">
                                        <div class="list">
                                            &lt;!&ndash;                                            :href="`/catalog/${category.url}/`"&ndash;&gt;
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

                                                &lt;!&ndash; Подкатегории &ndash;&gt;
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

                                                    &lt;!&ndash; Под-подкатегории &ndash;&gt;
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

                    </div>-->

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
<!--                                    <h1> {{ catalogs.title }} </h1>-->

<!--                                    <div class="breadcrumbs">

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

                                    </div>-->

                                </div>
                            </div>

                            <div class="col-xl-2"></div>
                        </div>
                    </div>
                </div>

            </section>

            <div class="container ">
                <div class="product-container">

                    <!-- Левая часть - фотогалерея -->
                    <div class="col-md-5">
                        <!-- Основное изображение -->
                        <img id="mainImage"
                             :src="currentImage"
                             data-fancybox="gallery"
                             :data-src="currentImage"
                             alt="Основное фото товара"
                             class="main-image">

                        <!-- Миниатюры вариантов -->
                        <div class="row product__block">
                            <div class="col-4" v-for="(img, index) in allImages" :key="index">
                                <img :src="img"
                                     alt="Миниатюра"
                                     class="thumbnail"
                                     :class="{ 'active': currentImage === img }"
                                     @click="changeMainImage(img)">
                            </div>
                        </div>
                    </div>

                    <!-- Правая часть - информация о товаре -->
                    <div class="col-md-6">
                        <h1 class="product-title">{{  getShortProductName(currentProduct)  }}</h1>

                        <div class="row__order__desc">
                            <!-- Описание товара -->
                            <div class="col-md-5">
                                <div class="product-details">
                                    <div class="detail-item">
                                        <span class="detail-label">Артикул:</span> {{ currentArticle }}
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Склад:</span> {{ currentWarehouse }}
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Количество:</span> {{ currentStock > 0 ? currentStock + ' шт.' : 'по запросу' }}
                                    </div>

                                    <div class="detail-item">
                                        <span class="detail-label">Срок доставки:</span>
                                        <a href=""> по запросу</a>
                                    </div>

                                    <div class="custom-checkbox-container" id="customCheckboxContainer">
                                        <label for="customCheckbox" class="custom-checkbox-label">без нанесения</label>
                                        <input type="checkbox" class="custom-checkbox" id="customCheckbox">
                                    </div>

                                    <div class="product-price">{{ currentProduct.price }} ₽</div>
                                </div>
                            </div>

                            <!-- Вертикальные миниатюры -->
                            <div class="vertical__block">
                                <div class="vertical-thumbnails">
                                    <img v-for="(variant, index) in uniqueColorVariants"
                                         :key="'variant-'+index"
                                         :src="getVariantImage(variant)"
                                         alt="Миниатюра"
                                         class="small-thumbnail"
                                         :class="{ 'active': currentProduct.id === variant.id }"
                                         @click="selectVariant(variant)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </main>

    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
});

const currentImage = ref(getProductImage(props.product));
const activeVariant = ref(null);
const hoverVariant = ref(null);

// Вычисляемые свойства
const currentProduct = computed(() => activeVariant.value || props.product);
const currentStock = computed(() => currentProduct.value.total || 0);
const currentArticle = computed(() => currentProduct.value.article || '');
const currentWarehouse = computed(() => currentProduct.value.sklad || 'Москва');

const uniqueColorVariants = computed(() => {
    if (!props.product.variants?.length) return [];

    const variants = [...props.product.variants];

    if (props.product.color) {
        variants.unshift({ ...props.product, isMain: true });
    }

    const colorMap = new Map();
    variants.forEach(variant => {
        if (variant.color && !colorMap.has(variant.color)) {
            colorMap.set(variant.color, variant);
        }
    });

    return Array.from(colorMap.values());
});

const allImages = computed(() => {
    const images = [getProductImage(currentProduct.value)];
    uniqueColorVariants.value.forEach(variant => {
        const variantImage = getVariantImage(variant);
        if (variantImage && !images.includes(variantImage)) {
            images.push(variantImage);
        }
    });
    return images;
});


const getShortProductName = (product) => {
    if (!product?.title) return '';

    // Находим индекс первой запятой
    const commaIndex = product.title.indexOf(',');

    // Берем часть до первой запятой или все название, если запятой нет
    let shortName = commaIndex > 0
        ? product.title.substring(0, commaIndex).trim()
        : product.title;

    // Добавляем цвет, если он есть и еще не указан в названии
    if (product.color) {
        const colorLower = product.color.toLowerCase();
        const nameLower = shortName.toLowerCase();

        // Проверяем, не содержится ли цвет уже в названии
        if (!nameLower.includes(colorLower)) {
            shortName += `, ${product.color}`;
        }
    }

    return shortName;
};

// Методы
function getVariantStock(variant) {
    return variant.total || 0;
}

function selectVariant(variant) {
    activeVariant.value = prepareVariantData(variant);
    currentImage.value = getVariantImage(variant);
}

function changeMainImage(newImage) {
    currentImage.value = newImage;
}

function getProductImage(product) {
    const explicitUrl = product.url_img || product.photo;
    if (explicitUrl && explicitUrl !== '1') return ensureImageUrl(explicitUrl);

    const sid = product.sid;
    const tovarId = product.tovar_id || product.id_parent || product.id;
    if (sid && tovarId) return `https://mvgifts.ru/img/tovars/${sid}/${tovarId}/${tovarId}.jpg`;

    return 'https://via.placeholder.com/200?text=No+Image';
}

function getVariantImage(variant) {
    const explicitUrl = variant.photo || variant.url_img;
    if (explicitUrl && explicitUrl !== '1') return ensureImageUrl(explicitUrl);

    const sid = variant.sid || props.product.sid;
    const tovarId = variant.tovar_id || variant.id_parent || variant.id;
    if (sid && tovarId) return `https://mvgifts.ru/img/tovars/${sid}/${tovarId}/${tovarId}.jpg`;

    return 'https://via.placeholder.com/40?text=No+Img';
}

function ensureImageUrl(url) {
    if (!url) return '';
    if (url.startsWith('http')) return url;
    return `https://mvgifts.ru${url.startsWith('/') ? '' : '/'}${url}`;
}

function prepareVariantData(variant) {
    return {
        ...variant,
        sid: variant.sid || props.product.sid,
        tovar_id: variant.tovar_id || variant.id_parent || variant.id,
        url_img: variant.photo || variant.url_img || props.product.url_img
    };
}
</script>


<style scoped>

.vertical-thumbnails[data-v-6a754aab][data-v-6a754aab] {
    display: flex;
    flex-direction: row;

}

.vertical-thumbnails[data-v-6a754aab] {
    display: flex;
    flex-direction: row-reverse;
    gap: 10px;
}


/* Стили для вертикальных миниатюр */
.vertical-thumbnails {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.small-thumbnail {
    width: 60px;
    height: 60px;
    object-fit: cover;
}

/* Стили для горизонтальных миниатюр */
.product__block {
    margin-top: 15px;
}

.thumbnail {
    width: 100%;
    height: auto;
}
.main-image {
    max-width: 100%;
    height: auto;
}

.variants {
    margin-top: 20px;
}

.variant {
    border: 1px solid #eee;
    padding: 10px;
    margin: 10px 0;
    display: flex;
    align-items: center;
    gap: 15px;
}

.variant img {
    width: 80px;
    height: 80px;
    object-fit: cover;
}

.loading {
    text-align: center;
    padding: 50px;
    font-size: 1.2rem;
}


.main-image {
    max-width: 100%;
    height: auto;
    margin-bottom: 15px;
    border: 1px solid #f0f0f0;
}

/* Горизонтальные миниатюры */
.product__block {
    margin-top: 15px;
}

.thumbnail {
    width: 100%;
    height: auto;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.thumbnail:hover {
    border-color: #ddd;
}

.thumbnail.active {
    border-color: #3498db;
}

/* Вертикальные миниатюры */
.vertical-thumbnails {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.small-thumbnail {
    width: 60px;
    height: 60px;
    object-fit: cover;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.small-thumbnail:hover {
    border-color: #ddd;
}

.small-thumbnail.active {
    border-color: #3498db;
}

/* Остальные ваши стили */
.product-title {
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.product-price {
    font-size: 1.5rem;
    font-weight: bold;
    color: #e53935;
}

.product-details {
    border-radius: 8px;
    margin-bottom: 20px;
    width: 245px;
    text-align: left;
}



/* Адаптивные стили */
@media (max-width: 768px) {
    .row__order__desc {
        flex-direction: column;
    }

    .vertical__block {
        margin-top: 15px;
    }
}

</style>
