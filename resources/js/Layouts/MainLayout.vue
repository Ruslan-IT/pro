<template>
  <section class="">
    <header>

    </header>
  </section>

  <section class="">

      <aside class="">
      <nav>

      </nav>
    </aside>

    <article class="">
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
  name: "MainLayout",
  components: {
        Link
  }

}
</script>

<style scoped>

</style>
