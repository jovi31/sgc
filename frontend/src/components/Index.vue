<template>
  <div :class="validatingToken ? 'index no-menu' : 'index'">
    <Header />
    <Menu v-if="!validatingToken" />
    <Loading v-if="validatingToken" />
    <Content v-else />
    <Footer />
  </div>
</template>

<script>
import Header from './template/Header'
import Menu from './template/Menu'
import Content from './template/Content'
import Footer from './template/Footer'
import Loading from './template/Loading'

import { userKey } from '../global'
import { validateToken } from '../services/auth'

export default {
  name: 'Index',
  components: { Header, Menu, Content, Footer, Loading },
  data () {
    return {
      validatingToken: true
    }
  },
  methods: {
    validateAuthToken () {
      const user = JSON.parse(localStorage.getItem(userKey))
      this.$store.commit('setUser', null)

      if(!user) {
        this.$router.push({ name: 'Auth' })
        return
      }

      validateToken(user.token)
        .then(() => {
          this.$store.commit('setUser', user)
          this.validatingToken = false
        })
        .catch(() => {
          localStorage.removeItem(userKey)
          this.$router.push({ name: 'Auth' })
        })
    }
  },
  mounted () {
    this.validateAuthToken()
  }
}
</script>

<style>
.index {
  display: grid;
  min-height: 100vh;
  grid-template-columns: 300px 1fr;
  grid-template-rows: min-content 1fr 30px;
  grid-template-areas:
    'header header'
    'menu content'
    'footer footer'
}
.no-menu {
  grid-template-areas:
    'header header'
    'content content'
    'footer footer'
}
</style>
