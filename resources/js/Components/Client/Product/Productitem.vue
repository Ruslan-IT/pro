

<style scoped>

</style>

<template>
    <div class="product-card">
        <div class="block__img__cart">
            <a href="">
                <img :src=product.url_img
                     :width=product.width
                     :height=product.height
                     alt="Фото товара"
                     class="">
            </a>
        </div>

        <div class="product__cart__block">

            <div class="product-name">{{ product.title }}</div>
            <div class="product-sku">Артикул: {{ product.article }}</div>
            <div class="product-stock">Остаток: 15 шт.</div>
            <div class="product-warehouse">Склад: Основной</div>
            <div class="product-footer">
                <div class="product-price">{{ product.price }} ₽</div>
                <img src="https://cdn-icons-png.flaticon.com/512/263/263142.png" alt="Корзина" class="cart-icon">
            </div>
        </div>
    </div>

</template>

<script >

export default {
    name: 'ProductItem',

    props: {
        product: Object
    },
    created() {
        //console.log('Product data2:', this.product);
    }

}

</script>
