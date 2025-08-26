<template>
    <div class="product-card">
        <div class="block__img__cart">

            <Link :href="route('client.products.show', { product: product.url })">

                <img :src="currentImageUrl"
                     :width="currentProduct.width || '200px'"
                     :height="currentProduct.height || '200px'"
                     :alt="currentProduct.title"
                     class="product-main-image"
                     :key="currentImageKey">
            </Link>
        </div>

        <div class="product__cart__block">
            <div class="thumbnail-variants" v-if="hasVariants">
                <div class="thumbnails-container">
                    <img v-for="(variant, index) in uniqueColorVariants"
                         :key="`variant-${index}`"
                         :src="getVariantImage(variant)"
                         class="thumbnail-image"
                         @mouseover="setCurrentProduct(variant)"
                         @mouseout="resetToMainProduct()"
                         :alt="variant.title"
                         :class="{ 'active-thumbnail': currentProduct.id === variant.id }"
                         :title="variant.color">
                </div>
            </div>

            <div class="product-name" :title="currentProduct.title">{{ shortProductName }}</div>

            <div class="product-sku">Артикул: 0{{ currentProduct.sid }} - {{ currentArticle }}</div>
            <div class="product-stock">
                Остаток: {{ currentStock > 0 ? currentStock + ' шт.' : 'по запросу' }}
            </div>
            <div class="product-warehouse">Склад: {{ currentWarehouse }} </div>

            <div class="product-footer">
                <div class="product-price">{{ currentProduct.price }} ₽</div>
                <img src="https://cdn-icons-png.flaticon.com/512/263/263142.png"
                     alt="Корзина"
                     class="cart-icon">
            </div>
        </div>
    </div>
</template>
<script>
import { Link } from '@inertiajs/vue3';
export default {
    name: 'ProductItem',
    components: { Link },
    props: {
        product: {
            type: Object,
            required: true,
            validator: (value) => {
                return value && value.id && value.title
            }
        }
    },
    data() {
        return {
            currentImageKey: 0,
            activeVariant: null
        }
    },

    computed: {
        currentProduct() {
            return this.activeVariant || this.product
        },
        currentStock() {
            return this.currentProduct.total || 0
        },
        currentWarehouse() {
            return this.currentProduct.sklad || 'Москва'
        },
        currentArticle() {
            return this.currentProduct.article || ''
        },
        shortProductName() {
            const commaIndex = this.currentProduct.title.indexOf(',')
            return commaIndex > 0
                ? this.currentProduct.title.substring(0, commaIndex).trim()
                : this.currentProduct.title
        },
        currentImageUrl() {
            // Пытаемся получить URL из явно указанных полей
            const explicitUrl = this.currentProduct.url_img || this.currentProduct.photo;
            if (explicitUrl && explicitUrl !== '1') {
                return this.ensureImageUrl(explicitUrl);
            }

            // Формируем URL по шаблону
            const sid = this.currentProduct.sid;
            const tovarId = this.currentProduct.tovar_id || this.currentProduct.id_parent || this.currentProduct.id;

            if (sid && tovarId) {
                return `https://mvgifts.ru/img/tovars/${sid}/${tovarId}/${tovarId}.jpg`;
            }

            // Возвращаем заглушку, если не удалось сформировать URL
            return 'https://via.placeholder.com/200?text=No+Image';
        },
        hasVariants() {
            return this.product.variants && this.product.variants.length > 0
        },
        uniqueColorVariants() {
            if (!this.hasVariants) return []

            const variants = [...this.product.variants]

            if (this.product.color) {
                variants.unshift({
                    ...this.product,
                    isMain: true
                })
            }

            const colorMap = new Map()
            variants.forEach(variant => {
                if (variant.color && !colorMap.has(variant.color)) {
                    colorMap.set(variant.color, variant)
                }
            })

            return Array.from(colorMap.values())
        }
    },
    methods: {
        getVariantImage(variant) {
            // Пытаемся получить URL из явно указанных полей
            const explicitUrl = variant.photo || variant.url_img;
            if (explicitUrl && explicitUrl !== '1') {
                return this.ensureImageUrl(explicitUrl);
            }

            // Формируем URL по шаблону
            const sid = variant.sid || this.product.sid;
            const tovarId = variant.tovar_id || variant.id_parent || variant.id;

            if (sid && tovarId) {
                return `https://mvgifts.ru/img/tovars/${sid}/${tovarId}/${tovarId}.jpg`;
            }

            return 'https://via.placeholder.com/40?text=No+Img';
        },
        setCurrentProduct(variant) {
            this.activeVariant = this.prepareVariantData(variant);
            this.currentImageKey += 1;
        },
        resetToMainProduct() {
            this.activeVariant = null;
            this.currentImageKey += 1;
        },
        ensureImageUrl(url) {
            if (!url) return '';
            if (url.startsWith('http')) return url;
            return `https://mvgifts.ru${url.startsWith('/') ? '' : '/'}${url}`;
        },
        prepareVariantData(variant) {
            // Гарантируем, что у варианта есть все необходимые поля
            return {
                ...variant,
                sid: variant.sid || this.product.sid,
                tovar_id: variant.tovar_id || variant.id_parent || variant.id,
                url_img: variant.photo || variant.url_img || this.product.url_img
            };
        }
    },
    watch: {
        product: {
            handler() {
                this.activeVariant = null;
                this.currentImageKey += 1;
            },
            deep: true
        }
    }
}
</script>

<style scoped>
.product-card {
    position: relative;
    border: 1px solid #eee;
    padding: 15px;
    border-radius: 8px;
    transition: all 0.3s ease;
    width: calc(25% - 20px);
    margin: 10px;
    box-sizing: border-box;
    flex-shrink: 0;
    min-height: 450px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.block__img__cart {
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
}

.product-main-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: opacity 0.3s ease;
    border: 1px solid #f0f0f0;
}

.product__cart__block {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 0px;
}

.product-name {
    font-weight: bold;
    margin-bottom: 5px;
    font-size: 1.1em;
    height: 3em;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.thumbnail-variants {
    margin: 10px 0;
    min-height: 60px;
}

.thumbnails-container {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 5px;
}

.thumbnail-image {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.thumbnail-image:hover {
    transform: scale(1.05);
    border-color: #999;
}

.active-thumbnail {
    border: 2px solid #3498db;
}

.product-sku, .product-stock, .product-warehouse {
    color: #666;
    font-size: 0.9em;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.product-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 10px;
    border-top: 1px solid #eee;
}

.product-price {
    font-weight: bold;
    font-size: 1.2em;
    color: #e53935;
    white-space: nowrap;
}

.cart-icon {
    width: 24px;
    height: 24px;
    cursor: pointer;
    transition: transform 0.2s;
}

.cart-icon:hover {
    transform: scale(1.1);
}

/* Мобильная версия */
@media (max-width: 1024px) {
    .product-card {
        width: calc(33.333% - 20px);
        min-height: 400px;
    }
}

@media (max-width: 768px) {
    .product-card {
        width: calc(50% - 20px);
        min-height: 380px;
        padding: 12px;
    }

    .block__img__cart {
        height: 160px;
        margin-bottom: 12px;
    }

    .product-name {
        font-size: 1em;
        height: 2.8em;
    }

    .thumbnail-image {
        width: 35px;
        height: 35px;
    }

    .product-price {
        font-size: 1.1em;
    }
}

@media (max-width: 480px) {
    .product-card {
        width: calc(50% - 10px);
        margin: 5px;
        min-height: 350px;
        padding: 10px;
    }

    .block__img__cart {
        height: 140px;
    }

    .product-name {
        font-size: 0.95em;
    }

    .thumbnail-variants {
        min-height: 50px;
    }

    .thumbnail-image {
        width: 30px;
        height: 30px;
    }
}
</style>
