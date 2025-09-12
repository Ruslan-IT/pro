<style>
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
@import '/public/css/catalog.css';
@import '/public/css/style.css';
</style>

<template>
    <div class="wrapper">
        <Header :categories="categories" />
        <div>
            <Head :title="``" />

            <!-- Отображаем заголовок -->
            <div class="container py-4">
                <h1 class="mb-4">Корзина</h1>

                <!-- Отображаем товары -->
                <div class="row" v-if="products && products.length">
                    <div v-for="product in products" :key="product.id" class="col-md-2 mb-5">
                        <ProductItem :product="product" />
                    </div>
                </div>

                <!-- Сообщение, если товаров нет -->
                <div v-else class="alert alert-info">
                    По вашему запросу "{{ query }}" ничего не найдено.
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import Header from "@/Components/Client/Header.vue";
import ProductItem from "@/Components/Client/Product/Productitem.vue";

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

.product-card[data-v-8f09e388] {
    width: 100%;
}
.product-main-image[data-v-8f09e388] {
    border:none;
}
.col-md-2 {
    width: 20.666667%;
}
</style>
