import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from 'axios'

export const useCartStore = defineStore('cart', () => {
    const items = ref([])
    const isOpen = ref(false)
    const printingCost = 100; // стоимость нанесения в рублях

    // Загрузка корзины из localStorage при инициализации
    if (localStorage.getItem('cart')) {
        items.value = JSON.parse(localStorage.getItem('cart'))
    }

    const totalItems = computed(() => {
        return items.value.reduce((total, item) => total + item.quantity, 0)
    })

    const totalPrice = computed(() => {
        return items.value.reduce((total, item) => {
            const itemPrice = item.price + (item.withPrinting ? printingCost : 0);
            return total + (itemPrice * item.quantity);
        }, 0);
    })

    function addItem(product, color, size, quantity, image, withPrinting = false) {
        const existingItemIndex = items.value.findIndex(item =>
            item.id === product.id &&
            item.color === color &&
            item.size === size &&
            item.withPrinting === withPrinting
        )

        if (existingItemIndex !== -1) {
            items.value[existingItemIndex].quantity += quantity
        } else {
            items.value.push({
                id: `${product.id}_${color}_${size}_${withPrinting ? 'with_printing' : 'without_printing'}`,
                product_id: product.id,
                title: product.title,
                price: product.price,
                image: image,
                color: color,
                size: size,
                quantity: quantity,
                article: product.article,
                withPrinting: withPrinting
            })
        }

        // Сохраняем в localStorage
        localStorage.setItem('cart', JSON.stringify(items.value))
    }

    function removeItem(index) {
        items.value.splice(index, 1)
        localStorage.setItem('cart', JSON.stringify(items.value))
    }

    function updateQuantity(index, quantity) {
        if (quantity <= 0) {
            removeItem(index)
            return
        }
        items.value[index].quantity = quantity
        localStorage.setItem('cart', JSON.stringify(items.value))
    }

    function clearCart() {
        items.value = []
        localStorage.removeItem('cart')
    }

    function openCart() {
        isOpen.value = true
    }

    function closeCart() {
        isOpen.value = false
    }

    function toggleCart() {
        isOpen.value = !isOpen.value
    }

    function togglePrinting(index) {
        if (items.value[index]) {
            items.value[index].withPrinting = !items.value[index].withPrinting;
            localStorage.setItem('cart', JSON.stringify(items.value));
        }
    }

    // метод для отправки заказа
    async function submitOrder(orderData) {
        try {
            const response = await axios.post(route('client.cart.store'), orderData)

            if (response.data.success) {
                // Очищаем корзину после успешной отправки
                clearCart()
                return {success: true, message: response.data.message}
            }
        } catch (error) {
            console.error('Ошибка при отправке заказа:', error)
            return {
                success: false,
                message: error.response?.data?.message || 'Произошла ошибка при отправке заказа'
            }
        }
    }

    return {
        items,
        isOpen,
        totalItems,
        totalPrice,
        addItem,
        removeItem,
        updateQuantity,
        clearCart,
        openCart,
        closeCart,
        toggleCart,
        submitOrder,
        togglePrinting,
        printingCost
    }
})
