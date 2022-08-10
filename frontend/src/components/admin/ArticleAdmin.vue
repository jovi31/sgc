<template>
  <div class="article-admin">
    <b-form class="mb-3" @submit.prevent="onSubmit" @reset.prevent="onReset">
      <b-form-group
        label="Título"
        label-for="iName"
      >
        <b-form-input
          id="iName"
          v-model="article.name"
          type="text"
          required
          placeholder="Insira o título"
        >
        </b-form-input>
      </b-form-group>

      <b-form-group
        label="Descrição"
        label-for="iDesc"
      >
        <b-form-input
          id="iDesc"
          v-model="article.description"
          type="text"
          required
          placeholder="Insira a descrição"
        >
        </b-form-input>
      </b-form-group>

      <b-form-group
        label="Categoria"
        label-for="iCategory"
      >
        <b-form-select
          id="iCategory"
          v-model="article.category_id"
          :options="categories"
          required
        >
        </b-form-select>
      </b-form-group>

      <VueEditor class="mb-3" v-model="article.content" />

      <b-button v-if="update" type="submit" variant="success">Alterar</b-button>
      <b-button v-else type="submit" variant="primary">Salvar</b-button>
      <b-button class="ml-2" type="reset" variant="secondary">Cancelar</b-button>
    </b-form>

    <div>
      <b-table
        striped
        hover
        primary-key="id"
        :fields="fields"
        :items="articles.data"
      >
        <template v-slot:cell(op)="data">
          <b-button @click="loadArticle(data.item)" class="shadow-none" size="sm" variant="warning">
            <b-icon icon="pencil"></b-icon>
          </b-button>
          <b-button @click="remove(data.item)" class="ml-2 shadow-none" size="sm" variant="danger">
            <b-icon icon="trash"></b-icon>
          </b-button>
        </template>
      </b-table>

      <b-pagination
        v-model="page"
        :total-rows="articles.total"
        :per-page="articles.per_page"
      ></b-pagination>
    </div>
  </div>
</template>

<script>
import service from '../../services/article'
import { findCategories } from '../../services/category'
import { showError, formatDate } from '../../global'

import { VueEditor } from 'vue2-editor'

export default {
  name: 'ArticleAdmin',
  components: { VueEditor },
  data () {
    return {
      update: false,
      article: {},
      categories: [],
      page: 1,
      articles: {},
      fields: [
        { key: 'op', label: 'Operações' },
        { key: 'id', label: 'ID' },
        { key: 'name', label: 'Título' },
        { key: 'user_id', label: 'Autor' },
        { key: 'created_at', label: 'Data' }
      ]
    }
  },
  methods: {
    onSubmit () {
      const save = this.update ? service.update : service.insert
      save(this.article)
        .then(() => {
          this.$toasted.global.defaultSuccess()
          this.onReset()
          this.loadArticles()
        })
        .catch(showError)
    },
    loadArticles () {
      service.findArticles(this.page)
        .then(res => {
          const page = res.data
          page.data = page.data.map(article => {
            article.created_at = formatDate(article.created_at)
            return article
          })
          this.articles = page
        })
        .catch(showError)
    },
    loadCategories () {
      findCategories()
        .then(res => {
          this.categories = res.data.map(category => {
            return { text: category.path, value: category.id }
          })
        })
        .catch(showError)
    },
    loadArticle (article) {
      this.update = true
      this.article = { ...article }
    },
    remove (article) {
      service.remove(article.id)
        .then(() => {
          this.$toasted.global.defaultSuccess()
          this.loadArticles()
        })
        .catch(showError)
    },
    onReset () {
      this.article = {}
      this.update = false
    }
  },
  watch: {
    page () {
      this.loadArticles()
    }
  },
  mounted () {
    this.loadArticles()
    this.loadCategories()
  }
}
</script>

<style>
</style>
