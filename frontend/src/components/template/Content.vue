<template>
  <main class="content bg-color03">
    <router-view></router-view>
  </main>
</template>

<script>
export default {
  name: 'Content'
}
</script>

<style>
.content {
  grid-area: content;
}
</style>
