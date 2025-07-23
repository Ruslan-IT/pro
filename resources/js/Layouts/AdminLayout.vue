<style>
@import url('http://14mvgifts.local/plugins/fontawesome-free/css/all.min.css');
</style>

<template>
  <section class="w-full p-4 border-b border-gray-100">
    <header>
      Market Admin
    </header>
  </section>
  <section class="flex">
    <aside class="w-1/4 bg-gray-900 min-h-screen">
      <nav>
          <Link :href="route('dashboard')" class="block p-4 text-gray-200 border-b border-gray-600">Дашборд</Link>

          <Link :href="route('admin.products.index')" class="block p-4 text-gray-200 border-b border-gray-600">Продукты</Link>
          <Link :href="route('admin.catalogs.index')" class="block p-4 text-gray-200 border-b border-gray-600">Категории</Link>
          <Link :href="route('admin.global_original_param_changes.index')" class="block p-4 text-gray-200 border-b border-gray-600">Характеристики</Link>
          <Link :href="route('admin.params.index')" class="block p-4 text-gray-200 border-b border-gray-600">Параметры-Хар</Link>


      </nav>
    </aside>
    <article class="w-3/4 bg-gray-50 p-4">
      <slot/>
    </article>
  </section>
  <section>
    <footer>

    </footer>
  </section>
</template>

<script>
import {Link} from "@inertiajs/vue3";



export default {
  name: "AdminLayout",
  components: {
        Link
  }

}
</script>

<style scoped>

</style>
