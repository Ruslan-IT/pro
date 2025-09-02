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
                <div class="drawing-detail-page">
        <Head>
            <title>{{ seo_title }}</title>
            <meta name="description" :content="seo_description">
        </Head>

        <div class="container">
            <div class="drawing-layout">
                <!-- Боковое меню -->
                <div class="drawing-sidebar">
                    <h3>Все виды </h3>
                    <ul>
                        <li v-for="d in drawings" :key="d.id">
                            <Link
                                :href="route('client.drawing.show', d.url)"
                                :class="{'active': d.url === drawing.url}"
                            >
                                {{ d.title }}
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Контент -->
                <div class="drawing-content">
                    <h1>{{ seo_h1 }}</h1>
                    <div class="drawing-text" v-html="formatText(drawing.text)"></div>
                </div>
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
        drawing: Object,
        drawings: Array,
        categories: Array,
        seo_title: String,
        seo_description: String,
        seo_h1: String
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
.drawing-layout {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: 40px;
    margin-top: 30px;
}

.drawing-sidebar {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 5px;
    height: fit-content;
}

.drawing-sidebar h3 {
    margin-bottom: 15px;
    color: #333;
}

.drawing-sidebar ul {
    list-style: none;
    padding: 0;
}

.drawing-sidebar li {
    margin-bottom: 10px;
}

.drawing-sidebar a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.drawing-sidebar a:hover {
    color: #e53935;
}

.drawing-sidebar a.active {
    color: #e53935;
    font-weight: bold;
}

.drawing-content h1 {
    color: #333;
    margin-bottom: 20px;
}

.drawing-text {
    line-height: 1.6;
}

.drawing-text p {
    margin-bottom: 15px;
}

.drawing-sidebar ul[data-v-0cba24da] {
    list-style: none;
    padding: 0;
    text-align: left;

}
</style>
