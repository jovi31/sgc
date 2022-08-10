<template>
  <div class="p-5 container article-by-id">
    <div class="title">
      <h1 class="mb-4">{{ article.name }}</h1>
      <h2 class="mb-4">{{ article.description }}</h2>
    </div>
    <div class="ql-snow">
      <div class="mt-5 ql-editor article-content" v-html="article.content"></div>
    </div>
    <VueEditor style="display:none" />
  </div>
</template>

<script>
import { find } from '../../services/article'
import { showError } from '../../global'

import { VueEditor } from 'vue2-editor'

export default {
  name: 'ArticleById',
  components: { VueEditor },
  data () {
    return {
      article: {}
    }
  },
  methods: {
    loadArticle (articleId) {
      find(articleId)
        .then(res => {
          this.article = res.data
        })
        .catch(showError)
    }
  },
  mounted () {
    const id = this.$route.params.id
    this.loadArticle(id)
  }
}
</script>

<style>
.article-by-id .title h1 {
  font-size: 2.5rem;
}

.article-by-id .title h2 {
  font-size: 1.5rem;
  color: gray;
}
/*
.article-content {
}*/

.title {
  border-bottom: 1px solid;
  border-image-slice: 1;
  border-image-source: linear-gradient(to right, gray, rgba(128, 128, 128, 0.1));
}
</style>
