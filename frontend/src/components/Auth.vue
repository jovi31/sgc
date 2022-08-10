<template>
  <div class="auth">
    <b-form class="d-flex flex-column auth-form">
      <b-form-group
        v-if="register"
        label="Nome:"
        label-for="iName"
      >
        <b-form-input
          id="iName"
          v-model="user.name"
          type="text"
          required
          placeholder="Digite seu nome"
        ></b-form-input>
      </b-form-group>

      <b-form-group
        label="E-mail:"
        label-for="iEmail"
      >
        <b-form-input
          id="iEmail"
          v-model="user.email"
          type="email"
          required
          placeholder="Digite seu email"
        ></b-form-input>
      </b-form-group>

      <b-form-group
        v-if="register"
        label="Confirmar e-mail:"
        label-for="iConfEmail"
      >
        <b-form-input
          id="iConfEmail"
          v-model="user.confirmEmail"
          type="email"
          required
          placeholder="Digite seu email"
        ></b-form-input>
      </b-form-group>

      <b-form-group
        label="Senha:"
        label-for="iPassword"
      >
        <b-form-input
          id="iPassword"
          v-model="user.password"
          type="password"
          required
          placeholder="Digite sua senha"
        ></b-form-input>
      </b-form-group>

      <b-form-group
        v-if="register"
        label="Confirmar senha:"
        label-for="iConfPassword"
      >
        <b-form-input
          id="iConfPassword"
          v-model="user.confirmPassword"
          type="password"
          required
          placeholder="Digite sua senha"
        ></b-form-input>
      </b-form-group>

      <b-link @click="register=!register" class="align-self-end">
        {{ register ? 'Fazer login' : 'Fazer cadastro' }}
      </b-link>
      <b-button @click="register ? onSignUp() : onSignIn()" class="mt-3" block type="button" variant="primary">
        {{ register ? 'Confirmar' : 'Entrar' }}
      </b-button>
    </b-form>
  </div>
</template>

<script>
import { showError, userKey } from '../global'
import { signIn, signUp } from '../services/auth'

export default {
  name: 'Auth',
  data () {
    return {
      register: false,
      user: {}
    }
  },
  methods: {
    onSignIn () {
      const credentials = {
        email: this.user.email,
        password: this.user.password
      }
      signIn(credentials)
        .then(res => {
          this.$store.commit('setUser', res.data)
          localStorage.setItem(userKey, JSON.stringify(res.data))
          this.$router.push({ path: '/' })
        })
        .catch(showError)
    },
    onSignUp () {
      if (this.validate()) {
        signUp(this.user)
          .then(() => {
            this.$toasted.global.defaultSuccess()
            this.user = {}
            this.register = false
          })
          .catch(showError)
      }
    },
    validate () {
      const user = this.user
      let isValid = true
      if (user.password !== user.confirmPassword) {
        showError('As senhas não são iguais.')
        isValid = false
      }
      if (user.email !== user.confirmEmail) {
        showError('Os endereços de e-mail não são iguais.')
        isValid = false
      }
      return isValid
    }
  }
}
</script>

<style>
.auth {
  height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: var(--medium-purple);
}

.auth-form {
  padding: 20px;
  border: 1px solid var(--timberwolf);
  background-color: white;
}
</style>
