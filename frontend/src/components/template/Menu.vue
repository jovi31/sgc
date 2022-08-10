<template>
  <nav class="menu bg-color02">
    <div class="menu-categories">
      <h1 class="h5 pl-3 pt-3">Categorias</h1>
      <Tree />
    </div>
  </nav>
</template>

<script>
import Tree from './Tree'

export default {
  name: 'Menu',
  components: { Tree }
}
</script>

<style>
.menu {
  grid-area: menu;
}
.menu-categories {
  position: sticky;
  top: 56px;
  z-index: 2;
}
</style>
