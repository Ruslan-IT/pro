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
                <div class="contact-page">
                    <Head>
                        <title>{{ seo_title }}</title>
                        <meta name="description" :content="seo_description">
                    </Head>

                    <h1>{{ seo_h1 }}</h1>

                    <div class="contact-info">
                        <div class="contact-item">
                            <strong>Телефон:</strong> {{ page.phone }}
                        </div>
                        <div class="contact-item">
                            <strong>Email:</strong> <a :href="`mailto:${page.email}`">{{ page.email }}</a>
                        </div>
                        <div class="contact-item" v-if="page.address">
                            <strong>Адрес:</strong> {{ page.address }}
                        </div>
                        <div class="contact-item">
                            <strong>Время работы:</strong> {{ page.work_time }}
                        </div>
                    </div>

                    <div class="company-details" v-if="page.company_name">
                        <h2>Реквизиты</h2>
                        <div class="contact-item">
                            <strong>Название компании:</strong> {{ page.company_name }}
                        </div>
                        <div class="contact-item">
                            <strong>ИНН:</strong> {{ page.inn }}
                        </div>
                        <div class="contact-item">
                            <strong>КПП:</strong> {{ page.kpp }}
                        </div>
                        <div class="contact-item">
                            <strong>ОГРН:</strong> {{ page.ogrn }}
                        </div>
                        <div class="contact-item">
                            <strong>Юридический адрес:</strong> {{ page.legal_address }}
                        </div>
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
    }
}
</script>

<style scoped>
.contact-info, .company-details {
    margin-bottom: 40px;
}

.contact-item {
    margin-bottom: 15px;
    font-size: 16px;
}

.company-details h2 {
    color: #333;
    margin-bottom: 20px;
    font-size: 24px;
}

.contact-item strong {
    display: inline-block;
    min-width: 150px;
    color: #333;
}
.contact-page{
    text-align: left;
}

</style>
