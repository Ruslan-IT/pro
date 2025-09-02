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
                <div class="article-page">
                    <h1 class="page-title">Статьи</h1>

                    <div class="article-grid">
                        <div v-for="item in articles.data" :key="item.id" class="article-card">
                            <div class="article-image">
                                <img :src="item.image_url || `/img/articles/${item.id}.jpg`" :alt="item.title">
                            </div>
                            <div class="article-content">
                                <h2 class="article-title">
                                    <Link :href="`/articles/${item.slug}`">{{ item.title }}</Link>
                                </h2>
                                <p class="article-excerpt">{{ item.excerpt }}</p>
                                <div class="article-meta">
                                    <span class="article-date">{{ formatDate(item.published_at) }}</span>
                                    <span v-if="item.author" class="article-author">Автор: {{ item.author }}</span>
                                    <span class="article-views">Просмотров: {{ item.views }}</span>
                                </div>
                                <Link :href="`/articles/${item.slug}`" class="read-more">Читать далее</Link>
                            </div>
                        </div>
                    </div>

                    <div class="pagination" v-if="articles.links.length > 3">
                        <div v-for="link in articles.links" :key="link.label">
                            <Link
                                :href="link.url || '#'"
                                :class="['pagination-link', { active: link.active, disabled: !link.url }]"
                                v-html="link.label"
                            />
                        </div>
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
    articles: Object,
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
.article-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.page-title {
    font-size: 2.5rem;
    margin-bottom: 2rem;
    text-align: center;
}

.article-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.article-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.article-card:hover {
    transform: translateY(-5px);
}

.article-image {
    height: 200px;
    overflow: hidden;
}

.article-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.article-content {
    padding: 1.5rem;
}

.article-title {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.article-title a {
    color: #333;
    text-decoration: none;
}

.article-title a:hover {
    color: #007bff;
}

.article-excerpt {
    color: #666;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.article-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.article-date,
.article-author,
.article-views {
    color: #888;
    font-size: 0.9rem;
}

.read-more {
    color: #007bff;
    text-decoration: none;
    font-weight: 500;
}

.read-more:hover {
    text-decoration: underline;
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 2rem;
}

.pagination-link {
    padding: 0.5rem 1rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-decoration: none;
    color: #333;
}

.pagination-link.active {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.pagination-link.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
