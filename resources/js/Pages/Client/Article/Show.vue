<style>
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
@import '/public/css/catalog.css';
@import '/public/css/style.css';
</style>

<template>
    <Head>
        <title>{{ article.meta_title || article.title }}</title>
        <meta name="description" :content="article.meta_description || article.excerpt">
        <meta name="keywords" :content="article.meta_keywords">
        <link rel="canonical" :href="`/articles/${article.slug}`">
    </Head>

    <div class="wrapper">
        <Header :categories="categories" />
        <div class="row">
            <div class="container">
                <div class="article-detail">
                    <div class="container">
                        <Link href="/articles" class="back-link">← Назад к списку статей</Link>

                        <article class="article-content">
                            <h1 class="article-title">{{ article.title }}</h1>

                            <div class="article-meta">
                                <span class="article-date">{{ formatDate(article.published_at) }}</span>
                                <span v-if="article.author" class="article-author">Автор: {{ article.author }}</span>
                                <span class="article-views">Просмотров: {{ article.views }}</span>
                            </div>

<!--                            <div class="article-image" v-if="article.image_url">
                                <img :src="article.image_url" :alt="article.title">
                            </div>-->

                            <div class="article-body" v-html="article.content"></div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import Header from "@/Components/Client/Header.vue";

defineProps({
    article: Object,
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

<style>

.attachment__caption{
    display: none;
}

.article-detail {
   /* max-width: 900px;
    margin: 0 auto;*/
    padding: 2rem;
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

.article-content {
    background: white;
    padding: 2rem;
    border-radius: 8px;
}

.article-title {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.article-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.article-date,
.article-author,
.article-views {
    color: #888;
    font-size: 0.9rem;
}

.article-image {
    margin-bottom: 2rem;
}

.article-image img {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

.article-body {
    line-height: 1.6;
    text-align: left;
}

.article-body >>> p {
    margin-bottom: 1rem;
}

.article-body >>> h2 {
    font-size: 1.5rem;
    margin: 2rem 0 1rem;
}

.article-body >>> h3 {
    font-size: 1.25rem;
    margin: 1.5rem 0 0.75rem;
}

.article-body >>> img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}

.article-body >>> blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #666;
}

.article-body >>> ul,
.article-body >>> ol {
    margin: 1rem 0;
    padding-left: 2rem;
}

.article-body >>> li {
    margin-bottom: 0.5rem;
}
</style>
