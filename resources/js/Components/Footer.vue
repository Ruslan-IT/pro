<template>
    <footer class="footer">
        <div class="container relative">

            <img class="img__top" src="/img/top.png" @click="scrollToTop" alt="">


            <div class="footer__block">
                <!-- 1 колонка - Лого и копирайт -->
                <div class="col-md-4 mb-4 mb-md-0 footer__item">
                    <div class="footer-logo">
                        <img src="/img/logo_ffter.png" alt="MVGIFTS" class="img-fluid">
                    </div>
                    <div class="footer-copyright">mvgifts.ru 2018-2025</div>
                    <div class="footer-rights">Все права защищены</div>
                </div>

                <!-- 2 колонка - Ссылки -->
                <div class="col-md-4 mb-4 mb-md-0 footer__item">
                    <ul class="footer-links">
                        <li><a href="#">О КОМПАНИИ</a></li>
                        <li><a href="/news">НОВОСТИ</a></li>
                        <li><a href="/articles">СТАТЬИ</a></li>
                        <li><a href="#">ОПЛАТА</a></li>
                        <li><a href="#">КАРТА САЙТА</a></li>
                        <li><a href="/contacts">КОНТАКТЫ</a></li>
                    </ul>
                </div>

                <!-- 3 колонка - Контакты и политика -->
                <div class="col-md-4 footer__item">
                    <div class="footer-address">г. Москва, ул. Павла Корчагина, д. 14</div>
                    <div class="footer-phone">
                        <a href="tel:84993906147">8 (499) 390 61 47</a>
                    </div>
                    <div class="footer-email">info@mvgifts.ru</div>
                    <div class="footer-policy">
                        <a href="/pages/privacy-policy">
                            ПОЛИТИКА ОБРАБОТКИ ПЕРСОНАЛЬНЫХ ДАННЫХ СОГЛАСИЕ НА ОБРАБОТКУ ПЕРСОНАЛЬНЫХ ДАННЫХ
                        </a>

                    </div>


                    <div class="footer-copyright-mob">
                        mvgifts.ru 2018-2025
                    </div>
                    <div class="footer-rights-mob">Все права защищены</div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: "smooth", // плавная прокрутка
    });
}

</script>

<style scoped>

footer {
    background-color: #404042;
    color: #fff;
    padding: 60px 0;
}

.img__top {
    cursor: pointer;
    position: absolute;

    transition: transform 0.3s;
}

.img__top:hover {
    transform: translateY(-5px);
}

</style>
