<template>
  <b-card
    class="article-item m-2"
    :title="article.name"
  >
    <b-card-text>
      {{ article.description }}
    </b-card-text>

    <b-button :to="`/articles/${article.id}`" variant="primary">Ler</b-button>
  </b-card>
</template>

<script>
export default {
  name: 'ArticleItem',
  props: [ 'article' ]
}
</script>

<style>
.article-item {
  width: 300px;
}
</style>
