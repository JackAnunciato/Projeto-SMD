<template>
  <div class="container">
    <h2>Login e Cadastro Simples</h2>
    <form @submit.prevent="login">
      <div class="input-field">
        <input
          v-model="username"
          type="text"
          class="white-text"
          id="username"
          placeholder="Nome de Usuário"
        />
      </div>
      <div class="input-field">
        <input
          v-model="password"
          class="white-text"
          type="password"
          id="password"
          placeholder="Senha"
        />
      </div>
      <button class="btn waves-effect waves-light" type="submit">Entrar</button>
      <p v-if="message" :class="messageClass">{{ message }}</p>
    </form>
  </div>
</template>

<style scoped>
.container {
  background-color: #181818;
  padding: 20px;
}
.white-text {
  color: white;
}
.error {
  color: red;
}
.success {
  color: green;
}
</style>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const username = ref('')
const password = ref('')
const router = useRouter()
const message = ref('')
const messageClass = ref('')

const login = async () => {
  try {
    const response = await fetch('http://localhost:8000/login/autenticar', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        username: username.value,
        password: password.value
      })
    })

    if (response.ok) {
      const data = await response.json()
      if (data.success) {
        message.value = 'Login bem-sucedido!'
        messageClass.value = 'success'
        router.push('/lista-cadastro')
      } else {
        message.value = data.message
        messageClass.value = 'error'
      }
    } else {
      message.value = 'Erro ao fazer login'
      messageClass.value = 'error'
    }
  } catch (error) {
    console.error('Erro na requisição:', error)
    message.value = 'Erro na requisição'
    messageClass.value = 'error'
  }
}
</script>
