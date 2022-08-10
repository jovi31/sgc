<template>
  <div class="articles-by-category">
    <b-card
      class="article-item m-2"
      v-for="article in articles" :key="article.id"
      :title="article.name"
    >

      <b-card-text class="mb-5">
        {{ article.description }}
      </b-card-text>

      <b-button :to="`/articles/${article.id}`" variant="primary">Ler</b-button>
    </b-card>
  </div>
</template>

<script>
import { getArticles } from '../../services/category'
import { showError } from '../../global'
// import ArticleItem from './ArticleItem'

export default {
  name: 'ArticlesByCategory',
  // components: { ArticleItem },
  data () {
    return {
      category: {},
      articles: []
    }
  },
  methods: {
    loadArticles () {
      getArticles(this.category)
        .then(res => {
          this.articles = res.data
        })
        .catch(showError)
    }
  },
  watch: {
    $route(to) {
      this.category.id = to.params.id
      this.articles = []
      this.loadArticles()
    }
  },
  mounted () {
    this.category.id = this.$route.params.id
    this.loadArticles()
  }
}
</script>

<style>
.articles-by-category {
  display: flex;
  flex-wrap: wrap;
}
.article-item {
  width: 300px;
}
.card-title {
  height: 50px;
}
.card-text {
  height: 100px;
  overflow: hidden;
}
.card-body > .btn {
  position: absolute;
  bottom: 10px;
  left: 10px;
}
</style>
