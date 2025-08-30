<style>
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
@import url('https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');
@import '/public/css/catalog.css';
@import '/public/css/style.css';
</style>

<template>
    <div class="wrapper">
        <Header :categories="categories" />
        <div class="row">
            <div class="container">
                <div class="portfolio-page">
                    <h1 class="page-title">Наше портфолио</h1>

                    <div class="portfolio-grid">
                        <div v-for="item in portfolio.data" :key="item.id" class="portfolio-item">
                            <div class="portfolio-image">
                                <img :src="`/storage/${item.image}` || `/storage/img/portfolio/${item.id}.jpg`" :alt="item.title">
                                <div class="portfolio-overlay">
                                    <Link :href="`/portfolio/${item.slug}`" class="view-project">Смотреть проект</Link>
                                </div>
                            </div>
                            <div class="portfolio-content">
                                <h2 class="portfolio-title">
                                    <Link :href="`/portfolio/${item.slug}`">{{ item.title }}</Link>
                                </h2>
                                <p class="portfolio-excerpt">{{ item.excerpt }}</p>
                                <div class="portfolio-meta">
                                    <span class="portfolio-date">{{ formatDate(item.created_at) }} </span>
                                </div>
                                <Link :href="`/portfolio/${item.slug}`" class="read-more">Подробнее</Link>
                            </div>
                        </div>
                    </div>

                    <div class="pagination" v-if="portfolio.links.length > 3">
                        <div v-for="link in portfolio.links" :key="link.label">
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
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import Header from "@/Components/Client/Header.vue";

defineProps({
    portfolio: Object,
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
.portfolio-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.page-title {
    font-size: 2.5rem;
    margin-bottom: 2rem;
    text-align: center;
}

.portfolio-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.portfolio-item {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.portfolio-item:hover {
    transform: translateY(-5px);
}

.portfolio-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.portfolio-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.portfolio-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.portfolio-item:hover .portfolio-overlay {
    opacity: 1;
}

.view-project {
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    background: #007bff;
    border-radius: 4px;
    font-weight: 500;
}

.portfolio-content {
    padding: 1.5rem;
}

.portfolio-title {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.portfolio-title a {
    color: #333;
    text-decoration: none;
}

.portfolio-title a:hover {
    color: #007bff;
}

.portfolio-excerpt {
    color: #666;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.portfolio-meta {
    margin-bottom: 1rem;
}

.portfolio-date {
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
