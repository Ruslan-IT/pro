<style>
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
@import '/public/css/catalog.css';
@import '/public/css/style.css';
</style>

<template>
    <div class="wrapper">
        <Header :categories="categories" />
        <div>
            <Head :title="`Результаты поиска: ${query}`" />

            <!-- Отображаем заголовок -->
            <div class="container py-4">
                <h1 class="mb-4">Результаты поиска: "{{ query }}"</h1>

                <!-- Отображаем товары -->
                <div class="row g-3" v-if="products && products.length">
                    <div
                        v-for="product in products"
                        :key="product.id"
                        class="col-6 col-sm-4 col-md-3 col-lg-2"
                    >
                        <ProductItem :product="product" />
                    </div>
                </div>


                <!-- Сообщение, если товаров нет -->
                <div v-else class="alert alert-info">
                    По вашему запросу "{{ query }}" ничего не найдено.
                </div>
            </div>

            <Footer />
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import Header from "@/Components/Client/Header.vue";
import ProductItem from "@/Components/Client/Product/Productitem.vue";
import Footer from "@/Components/Footer.vue"


defineProps({
    articles: Object,
    categories: Array,
    products: Array,
    query: String
});

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('ru-RU', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const formatPrice = (price) => {
    return new Intl.NumberFormat('ru-RU').format(price)
}
</script>

<style>

.row{
    justify-content: center;
}

.product-card[data-v-8f09e388] {
    width: 100%;
}
.product-main-image[data-v-8f09e388] {
    border:none;
}
@media (max-width: 1024px) {
    .product-card[data-v-9c4114e3] {
        width: 100%;
    }
}

@media (max-width: 800px) {
    .product-card[data-v-9c4114e3] {
        width: 100%;
    }
}

@media (max-width: 600px) {
    .product-card[data-v-9c4114e3] {
        width: 100%;
    }
}
@media (max-width: 4000px) {
    .product-card[data-v-9c4114e3] {
        width: 100%;
    }
}

</style>
