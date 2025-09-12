<style>
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');


@import '/public/css/catalog.css';
@import '/public/css/style.css';
</style>
<template>
    <div class="wrapper">
        <Header :categories="categories" />
        <div class="row">
            <div class="container">
                <div class="payment-delivery-page">
                    <Head>
                        <title>{{ seo_title }}</title>
                        <meta name="description" :content="seo_description">
                    </Head>

                    <h1 class="mt-5 mb-5">{{ seo_h1 }}</h1>

                    <div class="content-section">
                        <h2>Оплата</h2>
                        <div class="payment-content" v-html="formatText(page.payment_content)"></div>
                    </div>

                    <div class="content-section">
                        <h2>Доставка</h2>
                        <div class="delivery-content" v-html="formatText(page.delivery_content)"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3';
import Header from "@/Components/Client/Header.vue";

export default {
    components: {
        Header,
        Head,
        Link
    },
    props: {
        page: Object,
        seo_title: String,
        seo_description: String,
        seo_h1: String,
        categories: Array
    },
    methods: {
        formatText(text) {
            // Преобразуем переносы строк в абзацы
            return text.replace(/\n\n/g, '</p><p>').replace(/\n/g, '<br>');
        }
    }
}
</script>

<style scoped>
.content-section {
    margin-bottom: 40px;
}

.content-section h2 {
    color: #333;
    margin-bottom: 20px;
    font-size: 24px;
}

.payment-content,
.delivery-content {
    line-height: 1.6;
}

.payment-content p,
.delivery-content p {
    margin-bottom: 15px;
}


.payment-content, .content-section {
    text-align: left;
}


</style>
