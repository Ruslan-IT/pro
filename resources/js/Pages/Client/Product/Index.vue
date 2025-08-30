<style>
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
@import url('https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');
/*@import url('http://83.222.25.123/css/catalog.css');
@import url('http://83.222.25.123/css/style.css');*/
</style>

<template>
    <div class="wrapper">

        <header class="header">

            <div class="row header__top__block__main">
                <div class="container__header">
                    <div class="container__header__flex">
                        <div class="">
                            <div class="header__top d-flex ">
                                <!-- Мобильный телефон (видно только на мобильных) -->
                                <div class="d-block d-md-none">
                                    <a href="tel:+74993943841" class="header__phone">8 (499) 394-38-41</a>
                                </div>

                                <span class="company">|</span>
                                <div class="header__top__block company">
                                    <a href="">О компании </a>
                                </div>
                                <span>|</span>
                                <div class="header__top__block">
                                    <button type="submit" class="btn btn-primary submit-btn btn__red ">ЗАКАЗАТЬ ЗВОНОК</button>
                                </div>
                                <span>|</span>
                                <div class="header__top__block">

                                    <div class="header__top__cart">
                                        <div class="header__top__img">
                                            <img src="img/cart.png" alt="">
                                        </div>
                                        <div class="header__top__info">
                                            <p class="min__order">  Минимальный заказ</p>
                                            <p class="rub">15 000 Р </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <div class="container">

                <div class="row header__search">

                    <div class="col-xl-2">
                        <img src="img/logo.png" alt="logo">
                    </div>
                    <div class="col-xl-8 ">

                        <button class="navbar-toggler ds-mob" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Поиск товаров по названию или артикулу">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button">
                                    <img src="img/ser.png" alt="search">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 phone__mob__none">
            <span>
                <a href=""> 8 (499) 394 38 41</a>

            </span>
                    </div>
                    <div class="catalogmobile__my">
                        <div class="nav-item catalog ">
                            <a class="nav-link" href="#">КАТАЛОГ</a>
                            <span></span>
                        </div>
                    </div>

                </div>

                <div class="row header__menu ">
                    <div class="col-xl-2"></div>

                    <div class="col-xl-8">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <div class="container-fluid header__menu">

                                <div class="collapse navbar-collapse" id="navbarNav">
                                    <ul class="navbar-nav">
                                        <li
                                            key="catalog-btn"
                                            class="nav-item catal catalog__desc"
                                            @click="toggleCatalogDrop">
                                            <a class="nav-link catalog__mar" href="#">КАТАЛОГ</a>
                                            <span></span>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">ПОРТФОЛИО</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">НАНЕСЕНИЕ</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">КОНТАКТЫ</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">НОВОСТИ</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">ОПЛАТА И ДОСТАВКА</a>
                                        </li>


                                        <li class="nav-item  nav__block__none">
                                            <a class=" more_menu nav-link" href="#">Преимущества</a>
                                        </li>
                                        <li class="nav-item nav__block__none">
                                            <a class="  more_menu nav-link" href="#">Награды</a>
                                        </li>
                                        <li class="nav-item nav__block__none">
                                            <a class=" more_menu nav-link" href="#">Благодарности</a>
                                        </li>
                                        <li class="nav-item nav__block__none">
                                            <a class=" more_menu nav-link" href="#">Новости</a>
                                        </li>
                                        <li class="nav-item nav__block__none">
                                            <a class=" more_menu nav-link" href="#">Статьи</a>
                                        </li>
                                        <li class="nav-item nav__block__none ">
                                            <a class=" more_menu nav-link" href="#">Вопросы и ответы</a>
                                        </li>

                                        <li class="nav-item nav__block__none menu__phone">
                                            <a class="nav-link" href="#">8 (499) 394 38 41</a>
                                        </li>
                                        <li class="nav-item nav__block__none ">
                                            <a class="nav-link menu__email" href="#">info@mvgifts.ru</a>
                                        </li>


                                    </ul>
                                    <!-- Кнопка закрытия (крестик) - видна только в мобильном меню -->
                                    <button class="btn-close d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Close"></button>
                                </div>
                            </div>
                        </nav>
                    </div>

                    <div class="col-xl-2"></div>
                </div>

            </div>

            <section
                v-if="mounted && showCatalogDrop"
                key="catalog-drop"
                class="catalog_drop"
                v-show="showCatalogDrop">

                <div class="wrap_c">
                    <div class="list">

                        <div class="item">
                            <div class="items">

                                <a href="/catalog/ruchki/">
                                    <div class="table">
                                        <img src="/catalogs_ico/28.png" width="30" alt="Пишущие принадлежности">
                                        <img src="/catalogs_ico/28_hover.png" width="30">
                                        <div class="margin">
                                            <p style="text-transform: uppercase;">Пишущие принадлежности</p>
                                        </div>
                                    </div>
                                </a>

                            </div>
                        </div>

                    </div>
                </div>
            </section>

        </header>

        <main class="main">
            <section class="breadcrumbs__block">
                <div class="container">
                    <div class="breadcrumbs-container">
                        <div class="row">

                            <div class="col-xl-2"></div>

                            <div class="col-xl-8 crumbs">
                                <div class="breadcrumbs-content">
                                    <h1>Bluetooth колонка с сенсорным управлением</h1>
                                    <div class="breadcrumbs">
                                        <a href="#">Главная</a>
                                        <span class="separator">/</span>
                                        <a href="#">Электроника</a>
                                        <span class="separator">/</span>
                                        <a href="#">Колонки</a>
                                        <span class="separator">/</span>
                                        <span>Bluetooth колонка с сенсорным управлением</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-2"></div>
                        </div>
                    </div>
                </div>

            </section>

            <section>
                <div class="row">

                    <div class="container">
                        <div class="catalogs d__none">
                            <aside class="filter" style="position: relative;">

                                <form action="/catalog/futbolki/" method="GET" id="filtr_form">
                                    <div class="result_with_filtr" style="position: relative; display: inline-block;">
                                        <button type="button">Найдено
                                            <span style="font-weight: bold">
		2365	</span><div>Показать товар?</div></button>
                                    </div>



                                    <div class="h3">Все разделы</div>
                                    <div class="">
                                        <ul id="catalog">
                                            <li><a href="/catalog/futbolki/futbolki-s-logotipom/">Футболки <span>(1481)</span></a></li><li>
                                            <a href="/catalog/futbolki/futbolki-polo-s-logotipom/">Футболки поло <span>(883)</span></a></li><li>
                                            <a href="/catalog/futbolki/mayki-s-logotipom/">Майки <span>(1)</span></a></li></ul>


                                        <div class="h3">Цена, <i class="fa fa-rub "></i></div>
                                        <div class="price ">
                                            <div class="row row__block">
                                                <label for="amount_from">от</label>
                                                <input type="text" name="price_from" id="amount_from">
                                                <label for="amount_to">до</label>
                                                <input type="text" name="price_to" id="amount_to">
                                            </div>
                                            <div class="row mgt10">
                                                <div id="amount_range" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"><div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;"></span></div>
                                            </div>
                                        </div>

                                        <div class="h3">Остаток</div>
                                        <div class="residue ">
                                            <div class="row__block">
                                                <label for="residue_from">от</label>
                                                <input type="text" name="count_from" id="residue_from">
                                                <label for="residue_to">до</label>
                                                <input type="text" name="count_to" id="residue_to">
                                            </div>
                                            <div class="row mgt10">
                                                <div id="residue_range" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"><div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;"></span></div>
                                            </div>
                                        </div>

                                        <div class="h3">Склад</div><div class="row"><ul id="warehouse"><li>
                                        <input id="sklad_1" type="checkbox" name="sklad[]" value="Москва">
                                        <label for="sklad_1">Москва</label>
                                    </li></ul>

                                        <div class="h3">Цвет</div>
                                        <div class="rows__color">
                                            <input type="hidden" name="color" value="">
                                            <div id="colors" class="">
                                                <a class="" href="#" alt="бежевый" style="background: #f5f5dc"></a>
                                                <a class="" href="#" alt="белый" style="background: #ffffff"></a>
                                                <a class="" href="#" alt="бирюзовый" style="background: #30d5c8"></a>
                                                <a class="" href="#" alt="бордовый" style="background: #9b2d30"></a>
                                                <a class="" href="#" alt="голубой" style="background: #42aaff"></a>
                                                <a class="" href="#" alt="желтый" style="background: #ffff00"></a>
                                                <a class="" href="#" alt="зеленый" style="background: #008000"></a>
                                                <a class="" href="#" alt="коричневый" style="background: #964b00"></a>
                                                <a class="hidden" href="#" alt="красный" style="background: #ff0000"></a>
                                                <a class="hidden" href="#" alt="оранжевый" style="background: #ffa500"></a>
                                                <a class="hidden" href="#" alt="разные цвета" style="background: url(&quot;/img/color_default.png&quot;)"></a>
                                                <a class="hidden" href="#" alt="розовый" style="background: #ffc0cb"></a>

                                                <a class="hidden" href="#" alt="светло-зеленый" style="background: #90ee90"> </a>
                                                <a class="hidden" href="#" alt="серебряный" style="background: #c0c0c0"> </a>
                                                <a class="hidden" href="#" alt="серый" style="background: #bbbbbb"></a>
                                                <a class="hidden" href="#" alt="синий" style="background: #184a6d"> </a>
                                                <a class="hidden" href="#" alt="темно-зеленый" style="background: #013220"></a>
                                                <a class="hidden" href="#" alt="темно-коричневый" style="background: #654321"></a>


                                                <a class="hidden" href="#" alt="темно-серый" style="background: #808080"></a>
                                                <a class="hidden" href="#" alt="темно-синий" style="background: #002137"></a>
                                                <a class="hidden" href="#" alt="фиолетовый" style="background: #8b00ff"></a>
                                                <a class="hidden" href="#" alt="черный" style="background: #000000"></a>
                                            </div>

                                        </div>
                                        <a href="#colors" class="more">
                                            <span>Еще</span></a>

                                        <div class="h3">Материал</div><div class="row"><ul id="material"><li>
                                            <input id="material_1" type="checkbox" name="materials[]" value="No name">
                                            <label for="material_1">No name</label>
                                        </li><li>
                                            <input id="material_2" type="checkbox" name="materials[]" value="акрил">
                                            <label for="material_2">акрил</label>
                                        </li><li>
                                            <input id="material_3" type="checkbox" name="materials[]" value="вискоза">
                                            <label for="material_3">вискоза</label>
                                        </li><li>
                                            <input id="material_4" type="checkbox" name="materials[]" value="кристаллы SWAROVSKI">
                                            <label for="material_4">кристаллы SWAROVSKI</label>
                                        </li><li>
                                            <input id="material_5" type="checkbox" name="materials[]" value="лайкра">
                                            <label for="material_5">лайкра</label>
                                        </li><li>
                                            <input id="material_6" type="checkbox" name="materials[]" value="полиамид">
                                            <label for="material_6">полиамид</label>
                                        </li><li>
                                            <input id="material_7" type="checkbox" name="materials[]" value="полиэстер">
                                            <label for="material_7">полиэстер</label>
                                        </li><li>
                                            <input id="material_8" type="checkbox" name="materials[]" value="хлопок">
                                            <label for="material_8">хлопок</label>
                                        </li><li class="hidden">
                                            <input id="material_9" type="checkbox" name="materials[]" value="цинковый сплав">
                                            <label for="material_9">цинковый сплав</label>
                                        </li><li class="hidden">
                                            <input id="material_10" type="checkbox" name="materials[]" value="эластан">
                                            <label for="material_10">эластан</label>
                                        </li></ul><a href="#material" class="more"><span>Еще</span></a></div><div class="h3">Бренд</div><div class="row"><ul id="brand"><li>
                                            <input id="brand_1" type="checkbox" name="brand[]" value="Eat &amp; Bite">
                                            <label for="brand_1">Eat &amp; Bite</label>
                                        </li><li>
                                            <input id="brand_2" type="checkbox" name="brand[]" value="Elevate">
                                            <label for="brand_2">Elevate</label>
                                        </li><li>
                                            <input id="brand_3" type="checkbox" name="brand[]" value="Lettertone">
                                            <label for="brand_3">Lettertone</label>
                                        </li><li>
                                            <input id="brand_4" type="checkbox" name="brand[]" value="Paradox">
                                            <label for="brand_4">Paradox</label>
                                        </li><li>
                                            <input id="brand_5" type="checkbox" name="brand[]" value="Slazenger">
                                            <label for="brand_5">Slazenger</label>
                                        </li><li>
                                            <input id="brand_6" type="checkbox" name="brand[]" value="Swarovski">
                                            <label for="brand_6">Swarovski</label>
                                        </li><li>
                                            <input id="brand_7" type="checkbox" name="brand[]" value="Textile">
                                            <label for="brand_7">Textile</label>
                                        </li><li>
                                            <input id="brand_8" type="checkbox" name="brand[]" value="US Basic">
                                            <label for="brand_8">US Basic</label>
                                        </li></ul>







                                        </div>
                                    </div>
                                    </div>
                                </form>
                            </aside>
                        </div>
                        <div class="product__card__block__main product__color">

                            <ProductItem v-for="product in products" :product="product"></ProductItem>

                        </div>
                    </div>
                </div>
            </section>

        </main>

    </div>
</template>


<script >


import MainLayout from '@/Layouts/MainLayout.vue';
import ProductItem from "@/Components/Client/Product/Productitem.vue";
export default {

    name: 'Index',
    layout: MainLayout,

    components: {
        ProductItem
    },

    props: {
        products: Array
    }
}


</script>


<script setup>
import { ref, onMounted } from 'vue'


const showCatalogDrop = ref(false)
const mounted = ref(false) // Флаг монтирования

onMounted(() => {
    mounted.value = true // Компонент смонтирован
})

const toggleCatalogDrop = () => {
    showCatalogDrop.value = !showCatalogDrop.value
}
</script>

