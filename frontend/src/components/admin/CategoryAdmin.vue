<template>
  <div class="category-admin">
    <b-form class="mb-3" @submit.prevent="onSubmit" @reset.prevent="onReset">
      <b-form-group
        label="Nome"
        label-for="iName"
      >
        <b-form-input
          id="iName"
          v-model="category.name"
          type="text"
          required
          placeholder="Insira o nome da categoria"
        >
        </b-form-input>
      </b-form-group>

      <b-form-group
        label="Categoria Pai"
        label-for="iCategory"
      >
        <b-form-select
          id="iCategory"
          v-model="category.parent_id"
          :options="categories"
          text-field="path"
          value-field="id"
        >
          <b-select-option :value="null" label="/" />
        </b-form-select>
      </b-form-group>

      <b-button v-if="update" type="submit" variant="success">Alterar</b-button>
      <b-button v-else type="submit" variant="primary">Salvar</b-button>
      <b-button class="ml-2" type="reset" variant="secondary">Cancelar</b-button>
    </b-form>

    <b-table
      striped
      hover
      primary-key="id"
      :fields="fields"
      :items="categories"
    >
      <template v-slot:cell(op)="data">
        <b-button @click="loadCategory(data.item)" class="shadow-none" size="sm" variant="warning">
          <b-icon icon="pencil"></b-icon>
        </b-button>
        <b-button @click="remove(data.item)" class="ml-2 shadow-none" size="sm" variant="danger">
          <b-icon icon="trash"></b-icon>
        </b-button>
      </template>
    </b-table>
  </div>
</template>

<script>
import service from '../../services/category'
import { showError } from '../../global'

export default {
  name: 'CategoryAdmin',
  data () {
    return {
      update: false,
      category: {},
      categories: [],
      fields: [
        { key: 'op', label: 'Operações' },
        { key: 'id', label: 'ID' },
        { key: 'name', label: 'Nome' },
        { key: 'parent_id', label: 'Categoria pai' },
        { key: 'path', label: 'Caminho' }
      ]
    }
  },
  methods: {
    onSubmit () {
      const save = this.update ? service.update : service.insert
      save(this.category)
        .then(() => {
          this.$toasted.global.defaultSuccess()
          this.onReset()
          this.loadCategories()
        })
        .catch(showError)
    },
    loadCategories () {
      service.findCategories()
        .then(res => {
          this.categories = res.data
        })
        .catch(showError)
    },
    loadCategory (category) {
      this.update = true
      this.category = { ...category }
    },
    remove (category) {
      service.remove(category.id)
        .then(() => {
          this.$toasted.global.defaultSuccess()
          this.loadCategories()
        })
        .catch(showError)
    },
    onReset () {
      this.category = {}
      this.update = false
    }
  },
  mounted () {
    this.loadCategories()
  }
}
</script>

<style>

</style>
