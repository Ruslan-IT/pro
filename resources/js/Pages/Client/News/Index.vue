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
                <div class="news-page">
                    <h1 class="page-title">Новости</h1>

                    <div class="news-grid">
                        <div v-for="item in news.data" :key="item.id" class="news-card">
                            <div class="news-image">
                                <img :src="item.image || `/img/news/${item.id}.jpg`" :alt="item.title">
                            </div>
                            <div class="news-content">
                                <h2 class="news-title">
                                    <Link :href="`/news/${item.slug}`">{{ item.title }}</Link>
                                </h2>
                                <p class="news-excerpt">{{ item.excerpt }}</p>
                                <div class="news-meta">
                                    <span class="news-date">{{ formatDate(item.published_at) }}</span>
                                </div>
                                <Link :href="`/news/${item.slug}`" class="read-more">Читать далее</Link>
                            </div>
                        </div>
                    </div>

                    <div class="pagination" v-if="news.links.length > 3">
                        <div v-for="link in news.links" :key="link.label">
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
        <Footer />

    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import Header from "@/Components/Client/Header.vue";
import Footer from "@/Components/Footer.vue"

defineProps({
    news: Object,
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
.news-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.page-title {
    font-size: 2.5rem;
    margin-bottom: 2rem;
    text-align: center;
}

.news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(30%, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.news-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.news-card:hover {
    transform: translateY(-5px);
}

.news-image {
    /*height: 200px;*/
    overflow: hidden;
}

.news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.news-content {
    padding: 1.5rem;
}

.news-title {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.news-title a {
    color: #333;
    text-decoration: none;
}

.news-title a:hover {
    color: #007bff;
}

.news-excerpt {
    color: #666;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.news-meta {
    margin-bottom: 1rem;
}

.news-date {
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
