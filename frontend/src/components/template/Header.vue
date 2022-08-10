<template>
  <header class="header">
    <b-navbar class="bg-color01" toggleable="lg" type="dark">
      <b-navbar-brand href="#">
        <b-link
          class="custom-link"
          to="/"
        >
          SGC
        </b-link>
      </b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>

        <b-navbar-nav v-if="user" class="ml-auto">
          <b-nav-item-dropdown :text="firstName(user.name)" right>
            <b-dropdown-item to="/admin" v-if="user.admin">Administração</b-dropdown-item>
            <b-dropdown-item @click.prevent="logout">Sair</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </header>
</template>

<script>
import { userKey } from '../../global'
import { mapState } from 'vuex'

export default {
  name: 'Header',
  computed: mapState(['user']),
  methods: {
    logout () {
      localStorage.removeItem(userKey)
      this.$store.commit('setUser', null)
      this.$router.push({ name: 'Auth' })
    },
    firstName(name) {
      if (typeof name === 'string') {
        const nameArray = name.split(' ')
        return nameArray[0]
      }
      return null
    }
  }
}
</script>

<style>
.header {
  position: sticky;
  top: 0px;
  z-index: 2;
  grid-area: header;
}
</style>
