<template>
  <div class="admin-pages">
    <b-tabs content-class="m-3">
      <b-tab title="Usuário">
        <UserAdmin />
      </b-tab>
      <b-tab title="Categoria">
        <CategoryAdmin />
      </b-tab>
      <b-tab title="Artigo">
        <ArticleAdmin />
      </b-tab>
    </b-tabs>
  </div>
</template>

<script>
import UserAdmin from './UserAdmin'
import CategoryAdmin from './CategoryAdmin'
import ArticleAdmin from './ArticleAdmin'

export default {
  name: 'AdminPages',
  components: { UserAdmin, CategoryAdmin, ArticleAdmin }
}
</script>

<style>

</style>
