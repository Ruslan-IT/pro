<style>
@import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
@import url('https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');
@import '/public/css/catalog.css';
@import '/public/css/style.css';
</style>

<template>


        <div class="wrapper">

            <Header :categories="$page.props.categories" />


            <main class="main">
                <div class="row">
                    <div class="col-xl-12">

                        <div class="container">

                            <!--                <h1>{{ page.title }}</h1>-->

                            <div v-html="page.content">

                            </div>

                        </div>


                    </div>

                </div>

            </main>

        </div>







</template>

<script>
import Header from '@/Components/Client/Header.vue'

export default {
    components: {
        Header
    },
    props: {
        page: Object
    }
}
</script>

<style scoped>
.page-content {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.page-content >>> h1 {
    color: #333;
    margin-bottom: 20px;
}

.page-content >>> p {
    line-height: 1.6;
    margin-bottom: 15px;
}
</style>
