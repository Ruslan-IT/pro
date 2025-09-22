<style  >
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
@import url('https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');


@import '/public/css/catalog.css';
@import '/public/css/style.css';

</style  >

<template>

    <Head>
        <title>Главная страница</title>

    </Head>

    <div class="wrapper">

        <Header :categories="categories" />

        <main class="main">
            <!-- Слайдер -->
            <div class="row">
                <div class="col-xl-12">

                    <div class="container">

                        <div id="mainSlider" class="carousel slide custom-slider" data-bs-ride="carousel">
                                    <!-- Слайды -->
                            <div class="carousel-inner h-100">
                                <div v-for="(slide, index) in slides"
                                     :key="slide.id"
                                     :class="['carousel-item', 'h-100', { active: index === 0 }]">
                                    <div class="d-flex justify-content-center align-items-center h-100">
                                        <img :src="`/storage/${slide.image}`" :alt="slide.title">
                                        <div class="carousel-caption" v-if="slide.title || slide.subtitle">
                                            <h3 v-if="slide.title">{{ slide.title }}</h3>
                                            <p v-if="slide.subtitle">{{ slide.subtitle }}</p>
                                            <a v-if="slide.link" :href="slide.link" class="btn btn-primary btn__red">
                                                Подробнее
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Индикаторы -->
                            <div class="carousel-indicators slider-indicators" v-if="slides.length > 1">
                                <button v-for="(slide, index) in slides"
                                        :key="slide.id"
                                        type="button"
                                        data-bs-target="#mainSlider"
                                        :data-bs-slide-to="index"
                                        :class="['slider-indicator', { active: index === 0 }]"
                                        :aria-label="`Slide ${index + 1}`">
                                </button>
                            </div>
                            <!-- Стрелки -->
                            <div class="slider-control slider-control-prev" data-bs-target="#mainSlider" data-bs-slide="prev" v-if="slides.length > 1">
                                <span class="slider-control-icon">‹</span>
                            </div>
                            <div class="slider-control slider-control-next" data-bs-target="#mainSlider" data-bs-slide="next" v-if="slides.length > 1">
                                <span class="slider-control-icon">›</span>
                            </div>

                    </div>

                </div>
            </div>
            </div>
            <!-- Промо блоки -->
            <div class="container" v-if="promoBlocks && promoBlocks.length > 0">
                <div class="row transport">
                    <div v-for="block in promoBlocks" :key="block.id" class="col-xl-4 tranImg">
                        <img :src="`/storage/${block.image}`" :alt="block.title">
                        <div class="header__top__block">
                            <a :href="block.link" class="btn btn-primary submit-btn btn__red">
                                {{ block.button_text || 'СМОТРЕТЬ' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <section>
                <h2 class="text-center mb-5">Наши работы</h2>
                <div class="container">
                    <div class="row">
                        <!-- Карточка 1 -->
                        <div class="col-lg col-md-4 col-6" v-for="(work, index) in portfolio" :key="index">
                            <div class="work-card">
                                <div class="work-date">
                                    {{ formatDate(work.published_at) }}
                                </div>
                                <div class="work-img-container">
                                    <img :src="`/storage/${work.image}` "
                                         class="work-img" :alt="work.title">
                                </div>
                                <h3 class="work-title">
                                    <Link :href="`/portfolio/${work.slug}`" class="read-more">
                                        {{ work.title }}
                                    </Link>

                                </h3>
                                <p class="work-description">
                                    {{ truncateText(work.content, 150) }}
                                </p>
                            </div>
                        </div>

                    </div>

                </div>

            </section>


            <!-- Секция "Новости" -->
            <!-- Секция "О компании" -->
            <section class="about-section" v-if="aboutBlocks && aboutBlocks.length > 0 && mainBlock.title">
                <h2 class="text-center mb-5">
                    {{ mainBlock.title }}
                </h2>

                <div class="container">
                    <!-- Описание главного блока -->
                    <div class="row" v-if="mainBlock.description">
                        <div class="col-12">
                            <p class="about-description">
                                {{ mainBlock.description }}
                            </p>
                        </div>
                    </div>

                    <!-- Остальные блоки -->
                    <div class="about__blocks row" v-if="otherBlocks.length > 0">
                        <div class="col-md-4 col-sm-6 col-12 mb-4" v-for="(block, index) in otherBlocks" :key="block.id">
                            <div class="photo-card">
                                <div class="photo-container">
                                    <img :src="`/storage/${block.image}`" :alt="block.title" class="news-img">
                                    <div class="photo-border"></div>
                                </div>
                                <h3 class="photo-title">{{ block.title }}</h3>
                                <p class="photo-description">{{ block.description }}</p>
<!--                                <a v-if="block.link" :href="block.link" class="btn btn-primary btn__red">
                                    {{ block.button_text || 'ПОДРОБНЕЕ' }}
                                </a>-->
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </main>

        <Footer />
    </div>
</template>

<script setup>
import {Head, Link} from '@inertiajs/vue3'
import { defineProps, computed, onMounted, onUnmounted } from 'vue';
import Header from '@/Components/Client/Header.vue'
import Footer from '@/Components/Footer.vue'

const props = defineProps({
    categories: Array,
    portfolio: Array,
    news: Array,
    slides: Array,
    promoBlocks: Array,
    aboutBlocks: {
        type: Array,
        default: () => [] // Добавляем значение по умолчанию
    }
})

// Вычисляемые свойства для блоков о компании
const mainBlock = computed(() => {
    return props.aboutBlocks.find(block => block.is_main) || {}
})

const otherBlocks = computed(() => {
    return props.aboutBlocks
        .filter(block => !block.is_main)
        .sort((a, b) => a.order - b.order)
})

// Функция для форматирования даты
const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('ru-RU', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

// Функция для обрезки текста с удалением HTML-тегов
const truncateText = (text, maxLength) => {
    if (!text) return '';

    // Удаляем HTML-теги
    const cleanText = text.replace(/<[^>]*>/g, '');

    if (cleanText.length <= maxLength) return cleanText;
    return cleanText.substring(0, maxLength) + '...';
}

// Функция для динамической загрузки Bootstrap JS
const loadBootstrapJS = () => {
    // Проверяем, не загружен ли уже Bootstrap
    if (typeof bootstrap !== 'undefined') return;

    return new Promise((resolve, reject) => {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js';
        script.integrity = 'sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz';
        script.crossOrigin = 'anonymous';
        script.onload = resolve;
        script.onerror = reject;
        document.head.appendChild(script);
    });
};

let carousel = null;

onMounted(async () => {
    try {
        // Загружаем Bootstrap JS
        await loadBootstrapJS();

        // Инициализация карусели после загрузки Bootstrap
        if (typeof bootstrap !== 'undefined') {
            const carouselElement = document.getElementById('mainSlider');
            if (carouselElement) {
                carousel = new bootstrap.Carousel(carouselElement, {
                    interval: 5000,
                    ride: 'carousel'
                });
            }
        }
    } catch (error) {
        console.error('Failed to load Bootstrap:', error);
    }
});

onUnmounted(() => {
    // Останавливаем карусель при размонтировании компонента
    if (carousel) {
        carousel.pause();
    }
});
</script>

<style scoped>
/* Стили для слайдера */


/* Стили для индикаторов */
.slider-indicators {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 10px;
    z-index: 10;
    margin: 0;
    padding: 0;
}

.slider-indicator {
    width: 40px;
    height: 5px;
    background-color: rgba(255, 255, 255, 0.5);
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
    text-indent: -999px;
    overflow: hidden;
}

.slider-indicator.active {
    background-color: #ee2a27; /* Красный цвет для активного индикатора */
}

.slider-indicator:hover {
    background-color: rgba(255, 255, 255, 0.8);
}

/* Стили для стрелок навигации */
.slider-control {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    background-color: rgba(0, 0, 0, 0.5);
    border: none;
    border-radius: 50%;
    color: white;
    font-size: 24px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    transition: background-color 0.3s;
}

.slider-control:hover {
    background-color: rgba(0, 0, 0, 0.7);
}

.slider-control-prev {
    left: 20px;
}

.slider-control-next {
    right: 20px;
}

.slider-control-icon {
    color: white;
    font-weight: bold;
}

.news-img-container{
    height: 150px;
}

.about__blocks {
    flex-wrap: wrap;
}
.about-description {
    margin: 0 auto 50px!important;

}

/* Адаптивность */
@media (max-width: 768px) {

}
</style>
