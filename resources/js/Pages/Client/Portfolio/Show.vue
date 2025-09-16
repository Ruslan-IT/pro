<style>
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
@import '/public/css/catalog.css';
@import '/public/css/style.css';
</style>

<template>
    <Head>
        <title>{{  portfolioItem.title  }} </title>

    </Head>
    <div class="wrapper">
        <Header :categories="categories" />

        <div class="row">
            <div class="container">




                <article class="portfolio-article">
                    <Link href="/portfolio" class="back-link">← Назад к портфолио</Link>

                    <h1 class="portfolio-title">{{ portfolioItem.title }}</h1>

<!--                            <div class="portfolio-meta">
                        <span class="portfolio-date">{{ formatDate(portfolioItem.created_at) }}</span>
                    </div>-->

<!--                            <div class="portfolio-image" v-if="portfolioItem.image">
                        <img :src="portfolioItem.image" :alt="portfolioItem.title">
                    </div>-->

                    <div class="portfolio-content" v-html="portfolioItem.excerpt"></div>
                    <div class="portfolio-content" v-html="portfolioItem.content"></div>

                    <!-- Галерея изображений -->
                    <div class="portfolio-gallery" v-if="portfolioItem.gallery && portfolioItem.gallery.length">
                        <h3>Галерея проекта</h3>
                        <div class="gallery-grid">
                            <div
                                v-for="(image, index) in portfolioItem.gallery"
                                :key="index"
                                class="gallery-item"
                            >
                                <img
                                    :src="image"
                                    :alt="`${portfolioItem.title} - изображение ${index + 1}`"
                                    @click="openImageInNewTab(image)"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Характеристики проекта -->
                    <div class="portfolio-features" v-if="portfolioItem.features">
                        <h3>Особенности проекта</h3>
                        <ul>
                            <li v-for="(feature, index) in portfolioItem.features" :key="index">
                                {{ feature }}
                            </li>
                        </ul>
                    </div>
                </article>


            </div>
        </div>

        <Footer/>
    </div>
</template>

<script setup>
import {Head, Link} from '@inertiajs/vue3';
import { defineProps } from 'vue';
import Header from "@/Components/Client/Header.vue";
import Footer from "@/Components/Footer.vue";

defineProps({
    portfolioItem: Object,
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

const openImageInNewTab = (imageUrl) => {
    window.open(imageUrl, '_blank');
};
</script>

<style>
.portfolio-detail {
    max-width: 900px;
    margin: 0 auto;
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

.portfolio-article {
    background: white;
    padding: 2rem;
    border-radius: 8px;
   /* box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);*/
}

.portfolio-title {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.portfolio-meta {
    margin-bottom: 1.5rem;
}

.portfolio-date {
    color: #888;
    font-size: 0.9rem;
}

.portfolio-image {
    margin-bottom: 2rem;
}

.portfolio-image img {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

.portfolio-content {
    line-height: 1.6;
    margin-bottom: 2rem;
}

.portfolio-content >>> p {
    margin-bottom: 1rem;
}

.portfolio-content >>> h2 {
    font-size: 1.5rem;
    margin: 2rem 0 1rem;
}

.portfolio-content >>> h3 {
    font-size: 1.25rem;
    margin: 1.5rem 0 0.75rem;
}

.portfolio-gallery {
    margin-bottom: 2rem;
}

.portfolio-gallery h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}

.gallery-item {
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.gallery-item:hover {
    transform: scale(1.05);
    cursor: pointer;
}

.gallery-item img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.portfolio-features {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
}

.portfolio-features h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.portfolio-features ul {
    padding-left: 1.5rem;
}

.portfolio-features li {
    margin-bottom: 0.5rem;
    line-height: 1.5;
}
figure {
    margin: 0 auto;
    width: 100%;
    display: flex;
    justify-content: center;
}
.attachment__caption{
    display: none;
}


@media (max-width: 600px) {
    .portfolio-title {
        font-size: 1.5rem;
    }
    .portfolio-article {
        padding: 0;
    }
    .portfolio-content {
        margin-bottom: 0;
    }

}

</style>
