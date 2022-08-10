<template>
  <div class="error-404">
    <h1 class="display-1">404</h1>
    <h2 class="text-muted">Página não encontrada</h2>
  </div>
</template>

<script>
export default {
  name: 'Page404'
}
</script>

<style>
.error-404 {
  height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: var(--timberwolf);
}
</style>
