<style  >
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
@import url('https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');


@import '/public/css/catalog.css';
@import '/public/css/style.css';

</style  >

<template>

    <div class="wrapper">

        <Header :categories="categories" />

        <div class="row">
            <div class="container">
                <div class="news-detail">
                    <div class="container">
                        <Link href="/news" class="back-link">← Назад к списку новостей</Link>

                        <article class="news-article">
                            <h1 class="name">{{ newsItem.title }}</h1>

                            <div class="news-meta">
                                <span class="news-date">{{ formatDate(newsItem.published_at) }}</span>
                            </div>

<!--                            <div class="news-image" v-if="newsItem.image">
                                <img :src="newsItem.image" :alt="newsItem.title">
                            </div>-->

                            <div class="news-content" v-html="newsItem.content"></div>
                        </article>
                    </div>
                </div>
            </div>

        </div>

        <Footer />

    </div>

</template>

<script setup>

import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import Header from "@/Components/Client/Header.vue";
import Footer from "@/Components/Footer.vue"

defineProps({
    newsItem: Object,
    categories: Array
});

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('ru-RU', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script>

<style >

.attachment__caption{
    display: none;
}

.news-detail {
   /* max-width: 800px;
    margin: 0 auto;*/
   /* padding: 2rem;*/
}

.container {
    position: relative;
}

.back-link {
    display: inline-block;
    margin-bottom: 2rem;
    color: #007bff;
    text-decoration: none;
}

.back-link:hover {
    text-decoration: underline;
}

.news-article {
    background: white;
    /*padding: 2rem;*/
    border-radius: 8px;

    /*box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);*/
}

.news-title {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.news-meta {
    margin-bottom: 1.5rem;
}

.news-date {
    color: #888;
    font-size: 0.9rem;
}

.news-image {
    margin-bottom: 2rem;
}

.news-image img {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

.news-content {
    line-height: 1.6;
    text-align: left;
}

.news-content >>> p {
    margin-bottom: 1rem;
}

.news-content >>> h2 {
    font-size: 1.5rem;
    margin: 2rem 0 1rem;
}

.news-content >>> h3 {
    font-size: 1.25rem;
    margin: 1.5rem 0 0.75rem;
}




/********************************************************************************************/

</style>
