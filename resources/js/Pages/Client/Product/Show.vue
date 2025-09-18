<style>
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
@import url('https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');


@import '/public/css/catalog.css';
@import '/public/css/style.css';


</style>


<template>

    <Head>
        <title>{{ getShortProductName(currentProduct)  }}</title>

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
                <h1 class="product-title">{{  getShortProductName(currentProduct)  }}</h1>
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


                        <!-- Миниатюры дополнительных изображений -->
                        <div class="product__block thumbnails-slider" v-if="hasAdditionalImages">
                            <div class="thumb-item"
                                 v-for="(img, index) in validAdditionalImages"
                                 :key="index">
                                <img :src="img"
                                     alt="Дополнительное фото"
                                     class="thumbnail"
                                     :class="{ 'active': currentImage === img }"
                                     @click="changeMainImage(img)"
                                     @error="handleImageError(index)">
                            </div>
                        </div>
                    </div>

                    <!-- Правая часть - информация о товаре -->
                    <div class="col-md-6">


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
                                        <label
                                            for="customCheckbox"
                                            :class="{ 'custom-checkbox-label': true, 'active': withPrinting }"
                                        >
                                            {{ withPrinting ? 'С нанесением' : 'Без нанесения' }}
                                            <span v-if="withPrinting">(+ {{ printingCost }} ₽)</span>
                                        </label>
                                        <input
                                            type="checkbox"
                                            class="custom-checkbox"
                                            id="customCheckbox"
                                            v-model="withPrinting"

                                        >
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
                                         :alt="{variant}"
                                         class="small-thumbnail"
                                         :class="{ 'active': selectedColor === variant.color }"
                                         @click="selectVariant(variant)">
                                </div>
                            </div>


                        </div>

                        <!-- Блок с параметрами -->
                        <div class="order-block" v-if="selectedColor">
                            <!-- Шапка с колонками -->
                            <div class="grid-header">
                                <div class="header-item">Наличие</div>
                                <div class="header-item">Введите количество</div>
                                <div class="header-item">Размер</div>
                                <div class="header-item">Цена</div>
                            </div>

                            <!-- Строки с вариантами выбранного цвета -->
                            <div class="product-row" v-for="(variantGroup, index) in variantsForSelectedColor" :key="index">
                                <div class="stock">
                                    {{ variantGroup.total > 0 ? variantGroup.total + ' шт' : 'по запросу' }}
                                </div>
                                <div>
                                    <input type="text"
                                           min="0"

                                           class="quantity-input"
                                           :value="getQuantity(variantGroup)"
                                           @input="setQuantity(variantGroup, $event.target.value)">
                                </div>
                                <div>{{ variantGroup.size }}</div>
                                <div>{{ variantGroup.price }} ₽</div>
                            </div>

                            <!-- Итоговая сумма -->
                            <div class="total-section__bock">
                                <div class="total-section">
                                    <div>
                                        <div class="total-text">Итого</div>
                                        <div class="total-price">{{ calculateTotal() }} ₽</div>
                                    </div>
                                </div>
                                <div class="total-section__button">
                                    <a class="btn btn-primary submit-btn btn__red" @click="addToCart">
                                        ЗАПРОСИТЬ
                                    </a>
                                </div>
                            </div>

                            <div class="note">
                                *указанная сумма не включает в себя стоимость нанесения логотипа
                            </div>
                        </div>

                        <button class="order-btn">
                            Заказ принимается на сумму от 5000 Руб..
                        </button>

                        <div class="tabs-container">
                            <div class="tab-buttons">
                                <button
                                    class="tab-btn"
                                    :class="{ 'active': activeTab === 'description' }"
                                    @click="switchTab('description')"
                                >
                                    Описание
                                </button>
                                <button
                                    class="tab-btn"
                                    :class="{ 'active': activeTab === 'characteristics' }"
                                    @click="switchTab('characteristics')"
                                >
                                    Характеристики
                                </button>
                                <button
                                    class="tab-btn"
                                    :class="{ 'active': activeTab === 'payment' }"
                                    @click="switchTab('payment')"
                                >
                                    Оплата
                                </button>
                                <button
                                    class="tab-btn"
                                    :class="{ 'active': activeTab === 'delivery' }"
                                    @click="switchTab('delivery')"
                                >
                                    Доставка
                                </button>
                            </div>

                            <div id="description" class="tab-content" v-show="activeTab === 'description'">
                                <div class="property-item" v-html="tabData.description"></div>
                            </div>

                            <div id="characteristics" class="tab-content" v-show="activeTab === 'characteristics'">
                                <div class="property-item">
                                    <div class="property-title">Цвет</div>
                                    <div>{{ tabData.characteristics.color }}</div>
                                </div>
                                <div class="property-item">
                                    <div class="property-title">Размеры</div>
                                    <div>{{ tabData.characteristics.size }}</div>
                                </div>
                                <div class="property-item">
                                    <div class="property-title">Габариты</div>
                                    <div>{{ tabData.characteristics.dimensions }}</div>
                                </div>
                            </div>

                            <div id="payment" class="tab-content" v-show="activeTab === 'payment'">
                                <div class="property-item">
                                    <div class="property-title">Способы оплаты</div>
                                    <div>{{ tabData.payment.methods }}</div>
                                </div>
                                <div class="property-item">
                                    <div class="property-title">Рассрочка</div>
                                    <div>{{ tabData.payment.installment }}</div>
                                </div>
                            </div>

                            <div id="delivery" class="tab-content" v-show="activeTab === 'delivery'">
                                <div class="property-item">
                                    <div class="property-title">Сроки доставки</div>
                                    <div>{{ tabData.delivery.time }}</div>
                                </div>
                                <div class="property-item">
                                    <div class="property-title">Стоимость</div>
                                    <div>{{ tabData.delivery.cost }}</div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>



        </main>

        <Footer/>

    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import {Head, Link} from '@inertiajs/vue3';
import Header from "@/Components/Client/Header.vue";
import { useCartStore } from '@/store/cart'
import Footer from "@/Components/Footer.vue";

const cartStore = useCartStore()
const withPrinting = ref(false)
const printingCost = cartStore.printingCost

function togglePrinting() {

    withPrinting.value = !withPrinting.value
}


// Инициализация при загрузке компонента
onMounted(() => {
    if (props.product.variants && props.product.variants.length > 0) {
        // Берем первый вариант из списка
        const firstVariant = props.product.variants[0];
        selectVariant(firstVariant);
    }
});

const props = defineProps({
    product: {
        type: Object,
        required: true
    },
    categories: Array,        // Все категории для меню
    subcategories: Array,      // Подкатегории

});



const currentImage = ref(getProductImage(props.product));
const activeVariant = ref(null);
const selectedColor = ref(null);


const activeTab = ref('description'); // По умолчанию активна вкладка "Оплата"

// Метод для переключения вкладок
const switchTab = (tabName) => {
    console.log('Switching to tab:', tabName);
    activeTab.value = tabName;
};

// Вычисляемые свойства для вкладок
const tabData = computed(() => {
    return {
        //description: currentProduct.value.content || 'Описание товара отсутствует',
        description: props.product.content || 'Описание товара отсутствует', // Берем из основного продукта, а не из варианта
        characteristics: {
            color: selectedColor.value || 'Не указан',
            size: variantsForSelectedColor.value.map(v => v.size).join(', ') || 'Не указан',
            dimensions: currentProduct.value.dimensions || 'Не указаны'
        },
        payment: {
            methods: 'Наличные, карта, безналичный расчет',
            installment: 'До 12 месяцев'
        },
        delivery: {
            time: '1-3 рабочих дня',
            cost: 'Бесплатно при заказе от 5000 Руб.'
        }
    };
});

// Группируем варианты по цвету и размеру
const variantsGrouped = computed(() => {
    const grouped = {};

    props.product.variants.forEach(variant => {
        const key = `${variant.color}_${variant.size}`;

        if (!grouped[variant.color]) {
            grouped[variant.color] = {};
        }

        if (!grouped[variant.color][variant.size]) {
            grouped[variant.color][variant.size] = {
                ...variant,
                total: 0,
                variants: []
            };
        }

        // Суммируем количество для одинаковых размеров
        grouped[variant.color][variant.size].total += variant.total || 0;
        grouped[variant.color][variant.size].variants.push(variant);
    });

    return grouped;
});

// Вычисляемые свойства
const currentProduct = computed(() => activeVariant.value || props.product);
const currentStock = computed(() => currentProduct.value.total || 0);
const currentArticle = computed(() => currentProduct.value.article || '');
const currentWarehouse = computed(() => currentProduct.value.sklad || 'Москва');

// Уникальные цветовые варианты для миниатюр
const uniqueColorVariants = computed(() => {
    const colors = new Set();
    const result = [];

    props.product.variants.forEach(variant => {
        if (!colors.has(variant.color)) {
            colors.add(variant.color);
            result.push(variant);
        }
    });

    return result;
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

const currentAdditionalImages = computed(() => {
    if (!currentProduct.value) return [];

    const baseImageUrl = getProductImage(currentProduct.value);
    const baseUrlParts = baseImageUrl.split('/');
    const imageName = baseUrlParts[baseUrlParts.length - 1];
    const basePath = baseImageUrl.replace(imageName, '');

    const additionalImages = [];

    // Проверяем существование изображений с префиксами 1_, 2_ и т.д.
    for (let i = 1; i <= 5; i++) { // Проверяем до 5 дополнительных изображений
        const additionalImageName = `${i}_${imageName}`;
        const additionalImageUrl = `${basePath}${additionalImageName}`;


        // просто формируем URL по шаблону
        additionalImages.push(additionalImageUrl);
    }

    return additionalImages;
});

const imageErrors = ref([]);

// Проверяем, есть ли вообще дополнительные изображения
const hasAdditionalImages = computed(() => {
    return currentAdditionalImages.value.some(img => !imageErrors.value.includes(img));
});

// Получаем только валидные изображения (те, которые загрузились)
const validAdditionalImages = computed(() => {
    return currentAdditionalImages.value.filter(img => !imageErrors.value.includes(img));
});

// Обработчик ошибок загрузки изображений
function handleImageError(index) {
    const imgUrl = currentAdditionalImages.value[index];
    if (!imageErrors.value.includes(imgUrl)) {
        imageErrors.value.push(imgUrl);
    }
}

// Методы
function getVariantStock(variant) {
    return variant.total || 0;
}

function selectVariant(variant) {
    activeVariant.value = prepareVariantData(variant);
    currentImage.value = getVariantImage(variant);
    selectedColor.value = variant.color;
    // Сбрасываем активную вкладку при изменении варианта
    //activeTab.value = 'description';
}

// Варианты для выбранного цвета (уже сгруппированные по размеру)
const variantsForSelectedColor = computed(() => {
    if (!selectedColor.value || !variantsGrouped.value[selectedColor.value]) {
        return [];
    }
    return Object.values(variantsGrouped.value[selectedColor.value]);
});

function changeMainImage(newImage) {
    currentImage.value = newImage;
}

function getProductImage(product) {
    const explicitUrl = product.url_img || product.photo;
    if (explicitUrl && explicitUrl !== '1') return ensureImageUrl(explicitUrl);

    const sid = product.sid;
    const tovarId = product.tovar_id || product.id_parent || product.id;
    if (sid && tovarId) {
        // Основное изображение имеет вид: /img/tovars/{sid}/{tovarId}/{tovarId}.jpg
        return `https://mvgifts.ru/img/tovars/${sid}/${tovarId}/${tovarId}.jpg`;
    }

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

const quantities = ref({});

function calculateTotal() {
    let total = 0;
    if (variantsForSelectedColor.value) {
        variantsForSelectedColor.value.forEach(variantGroup => {
            const key = `${variantGroup.color}_${variantGroup.size}`;
            const quantity = quantities.value[key] || 0;
            total += quantity * variantGroup.price;
        });
    }
    return total.toLocaleString('ru-RU');
}

function getQuantity(variantGroup) {
    const key = `${variantGroup.color}_${variantGroup.size}`;
    return quantities.value[key] || 0;
}

function setQuantity(variantGroup, value) {
    const key = `${variantGroup.color}_${variantGroup.size}`;
    quantities.value[key] = Number(value);
}



function addToCart() {
    // Для каждого варианта в выбранном цвете, который имеет количество больше 0, добавляем в корзину
    variantsForSelectedColor.value.forEach(variantGroup => {
        const quantity = getQuantity(variantGroup)
        if (quantity > 0) {

            cartStore.addItem(
                {
                    id: `${props.product.id}_${variantGroup.color}_${variantGroup.size}`,
                    title: getShortProductName(currentProduct.value),
                    price: variantGroup.price,
                    article: currentArticle.value
                },
                variantGroup.color,
                variantGroup.size,
                quantity,
                currentImage.value,
                withPrinting.value // передаем состояние нанесения
            )
        }
    })

    // Открываем корзину после добавления
    cartStore.openCart()
}





</script>


<style >



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
    flex-direction: row!important;
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


/*********************************/
.order-block {
    margin-top: 20px;
    border: 1px solid #eee;
    padding: 15px;
    border-radius: 5px;
}

.grid-header {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    gap: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
    margin-bottom: 10px;
}

.product-row {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    gap: 10px;
    padding: 8px 0;
    border-bottom: 1px solid #f5f5f5;
}

.quantity-input {
    width: 100%;
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 3px;
}

.total-section__bock {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

.total-price {
    font-size: 1.2rem;
    font-weight: bold;
}

.note {
    font-size: 0.8rem;
    color: #666;
    margin-top: 10px;
}




.catalog_drop {
    position: absolute;
    background: white;
    z-index: 1000;
    width: 100%;
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

#catalog .active-category {
    font-weight: bold;
    color: #ee2a27; /* или любой другой цвет для выделения */
}

#catalog .active-category span {
    font-weight: bold;
    color: #ee2a27;
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

/*** Стили для характеристик ***/
.tab-btn.active {
    background-color: #f0f0f0;
    border-bottom: 2px solid #ee2a27;
}

.tab-content {
    display: block;
}

.tab-content {
    padding: 15px 0;
}

.tab-content[v-show="true"] {
    display: block !important;
}

.property-item >>> p {
    margin-bottom: 0.5rem;
}

.property-item >>> ul {
    padding-left: 1.5rem;
    margin-bottom: 0.5rem;
}

.property-item >>> li {
    margin-bottom: 0.25rem;
}
.tab-content[data-v-6a754aab]{
    display: block;
}
/************************************/
.product-price {
    font-size: 36px!important;
}



.collapse {
    visibility: visible;
}

/*************************************/
.custom-checkbox-container {
    margin: 15px 0;
}

.custom-checkbox-label {
   /* display: inline-block;
    padding: 10px 15px;
    border: 2px solid #ddd;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
    user-select: none;*/
}

.custom-checkbox-label.active {
    /*border-color: #3498db;
    background-color: #3498db;
    color: white;*/
}

.custom-checkbox-label:hover {
    /*border-color: #3498db;*/
}

/*input[type=checkbox] {
    display: block!important;
}*/
.custom-checkbox-container{
    max-width: 210px;
}
[type='checkbox'], [type='radio'] {
    /*color: black;*/
}
#privacy{
    display: none!important;
}

.thumbnails-slider {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    padding-bottom: 10px;
}

.thumb-item {
    flex: 0 0 auto;
    width: 90px; /* ширина миниатюры */
    scroll-snap-align: start;
}

.thumbnail {
    width: 100%;
    height: auto;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s;
}

.thumbnail.active {
    border-color: #3498db;
}
.product-title {
    font-size: 1.5rem;
    margin-bottom: 3rem;
}


</style>
