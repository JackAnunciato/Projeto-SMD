<template>
  <div class="container">
    <h2>Login e Cadastro Simples</h2>

    <select>
      <option value="1">1</option>
      <option value="1">1</option>
      <option value="1">1</option>
    </select>

    <form @submit.prevent="login">
      <div class="input-field">
        <input v-model="username" type="text" id="username" placeholder="Nome de Usuário" />
      </div>
      <div class="input-field">
        <input v-model="password" type="password" id="password" placeholder="Senha" />
      </div>
      <button class="btn waves-effect waves-light" type="submit">Entrar</button>
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
</style>

<script setup>
import { ref } from 'vue' // Importe o ref para criar variáveis reativas
import { useRouter } from 'vue-router' // Importe o useRouter

const username = ref('') // Variável reativa para o nome de usuário
const password = ref('') // Variável reativa para a senha
const router = useRouter() // Inicialize o router

const login = async () => {
  try {
    // Aqui você fará a requisição POST para o backend
    const response = await fetch('http://localhost:8000/login', {
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
      // Sucesso! Você pode redirecionar o usuário para outra página ou fazer algo aqui
      console.log('Login bem-sucedido!')
      router.push('/lista-cadastro') // Corrigi o nome da rota
    } else {
      // Tratamento de erro (por exemplo, exibir uma mensagem de erro)
      console.error('Erro ao fazer login')
    }
  } catch (error) {
    console.error('Erro na requisição:', error)
  }
}
</script>
