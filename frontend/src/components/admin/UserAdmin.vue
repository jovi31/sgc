<template>
  <div class="user-admin">
    <b-form class="mb-3" @submit.prevent="onSubmit" @reset.prevent="onReset">
      <b-form-group
        label="Nome"
        label-for="iName"
      >
        <b-form-input
          id="iName"
          v-model="user.name"
          type="text"
          required
          placeholder="Insira o nome"
        >
        </b-form-input>
      </b-form-group>

      <b-form-group
        label="E-mail"
        label-for="iEmail"
      >
        <b-form-input
          id="iEmail"
          v-model="user.email"
          type="email"
          required
          placeholder="Insira o email"
        >
        </b-form-input>
      </b-form-group>

      <b-form-group
        label="Senha"
        label-for="iPassword"
      >
        <b-form-input
          id="iPassword"
          v-model="user.password"
          type="password"
          required
          placeholder="Insira a senha"
        >
        </b-form-input>
      </b-form-group>

      <b-form-checkbox
        class="mb-3"
        id="iAdmin"
        v-model="user.admin"
      >
        Administrador
      </b-form-checkbox>

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
        :items="users.data"
      >
        <template v-slot:cell(op)="data">
          <b-button @click="loadUser(data.item)" class="shadow-none" size="sm" variant="warning">
            <b-icon icon="pencil"></b-icon>
          </b-button>
          <b-button @click="remove(data.item)" class="ml-2 shadow-none" size="sm" variant="danger">
            <b-icon icon="trash"></b-icon>
          </b-button>
        </template>
      </b-table>

      <b-pagination
        v-model="page"
        :total-rows="users.total"
        :per-page="users.per_page"
      ></b-pagination>
    </div>
  </div>
</template>

<script>
import service from '../../services/user'
import { showError } from '../../global'

export default {
  name: 'UserAdmin',
  data () {
    return {
      update: false,
      user: { admin: false },
      users: {},
      page: 1,
      fields: [
        { key: 'op', label: 'Operações' },
        { key: 'id', label: 'ID' },
        { key: 'name', label: 'Nome' },
        { key: 'email', label: 'E-mail' },
        { key: 'admin', label: 'Admin' }
      ]
    }
  },
  methods: {
    onSubmit () {
      const save = this.update ? service.update : service.insert
      save(this.user)
        .then(() => {
          this.$toasted.global.defaultSuccess()
          this.onReset()
          this.loadUsers()
        })
        .catch(showError)
    },
    loadUsers () {
      service.findUsers(this.page)
        .then(res => {
          this.users = res.data
        })
        .catch(showError)
    },
    loadUser (user) {
      this.user = { ...user }
      this.user.admin = Boolean(user.admin)
      this.update = true
    },
    remove (user) {
      const id = user.id
      service.remove(id)
        .then(() => {
          this.$toasted.global.defaultSuccess()
          this.loadUsers()
        })
        .catch(showError)
    },
    onReset () {
      this.user = { admin: false }
      this.update = false
    }
  },
  watch: {
    page () {
      this.loadUsers()
    }
  },
  mounted () {
    this.loadUsers()
  }
}
</script>

<style>

</style>
