<template>
  <LiquorTree :data="treeData" :options="options">
    <div slot-scope="{ node }">
      <b-link
        :to="`/categories/${node.id}/articles`"
        class="custom-link text-dark"
      >
        {{ node.text }}
      </b-link>
    </div>
  </LiquorTree>
</template>

<script>
import { tree } from '../../services/category'
import { showError } from '../../global'
import LiquorTree from 'liquor-tree'

export default {
  name: 'Tree',
  components: { LiquorTree },
  data () {
    return {
      treeData: this.loadCategoryTree(),
      options: {
        propertyNames: {
          'text': 'name'
        }
      }
    }
  },
  methods: {
    loadCategoryTree () {
      return tree()
        .then(res => res.data)
        .catch(showError)
    }
  }
}
</script>

<style>
</style>
