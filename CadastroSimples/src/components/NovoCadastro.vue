<template>
  <div class="novo-cadastro-container">
    <h2>Novo Cadastro</h2>
    <form @submit.prevent="salvarNovoCadastro">
      <div>
        <label for="nome">Nome:</label>
        <input id="nome" class="white-text" v-model="novoCadastro.nome" type="text" required />
      </div>
      <div>
        <label for="telefone">Telefone:</label>
        <input
          id="telefone"
          class="white-text"
          v-model="novoCadastro.telefone"
          type="text"
          required
        />
      </div>
      <div>
        <label for="dataNascimento">Data de Nascimento:</label>
        <input
          id="dataNascimento"
          v-model="novoCadastro.dataNascimento"
          class="white-text"
          type="date"
          required
          @input="atualizarIdade"
        />
      </div>
      <div>
        <label for="idade">Idade:</label>
        <input id="idade" class="white-text" v-model="novoCadastro.idade" type="text" readonly />
      </div>
      <div>
        <label for="email">Email:</label>
        <input id="email" class="white-text" v-model="novoCadastro.email" type="email" required />
      </div>
      <div>
        <label for="imagem">Imagem:</label>
        <input id="imagem" type="file" @change="mostrarMiniatura" accept="image/*" />
        <div v-if="imagemPreview" class="image-preview">
          <img :src="imagemPreview" alt="Imagem Prévia" />
        </div>
      </div>
      <div>
        <button type="submit" class="btn">Salvar</button>
        <button type="button" @click="cancelarCadastro" class="btn red">Cancelar</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const novoCadastro = ref({ nome: '', telefone: '', dataNascimento: '', idade: '', email: '' })
const imagemPreview = ref('')
const imagemFile = ref(null)

const calcularIdade = (dataNascimento) => {
  const hoje = new Date()
  const nascimento = new Date(dataNascimento)
  let idade = hoje.getFullYear() - nascimento.getFullYear()
  const m = hoje.getMonth() - nascimento.getMonth()
  if (m < 0 || (m === 0 && hoje.getDate() < nascimento.getDate())) {
    idade--
  }
  return idade
}

const atualizarIdade = () => {
  if (novoCadastro.value.dataNascimento) {
    novoCadastro.value.idade = calcularIdade(novoCadastro.value.dataNascimento)
  } else {
    novoCadastro.value.idade = ''
  }
}

const mostrarMiniatura = (event) => {
  const file = event.target.files[0]
  if (file) {
    imagemFile.value = file
    const reader = new FileReader()
    reader.onload = (e) => {
      imagemPreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  } else {
    imagemPreview.value = ''
  }
}

const salvarNovoCadastro = async () => {
  const formData = new FormData()
  formData.append('nome', novoCadastro.value.nome)
  formData.append('telefone', novoCadastro.value.telefone)
  formData.append('data_nascimento', novoCadastro.value.dataNascimento)
  formData.append('idade', novoCadastro.value.idade)
  formData.append('email', novoCadastro.value.email)

  if (imagemFile.value) {
    const reader = new FileReader()
    reader.onloadend = () => {
      const base64Image = reader.result.split(',')[1] // Remove the data URL scheme
      formData.append('imagem', base64Image)
      enviarFormulario(formData)
    }
    reader.readAsDataURL(imagemFile.value)
  } else {
    enviarFormulario(formData)
  }
}

const enviarFormulario = async (formData) => {
  try {
    const response = await axios.post('http://localhost:8000/pessoa/salvar', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    console.log(response.data)
    router.push('/lista-cadastro')
  } catch (error) {
    console.error('Erro ao salvar o cadastro:', error.response?.data || error.message)
  }
}

const cancelarCadastro = () => {
  router.push('/lista-cadastro')
}
</script>

<style scoped lang="scss">
.novo-cadastro-container {
  padding: 2rem;
  border: 1px solid #ccc;
  border-radius: 8px;
  max-width: 500px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
}

.white-text {
  color: white;
}

input[type='date']::-webkit-calendar-picker-indicator {
  filter: invert(0.8) brightness(1000%) sepia(0%) saturate(10000%) hue-rotate(240deg);
}

.novo-cadastro-container h2 {
  margin-bottom: 1rem;
}

.novo-cadastro-container div {
  margin-bottom: 1rem;
}

.novo-cadastro-container label {
  display: block;
  margin-bottom: 0.5rem;
}

.novo-cadastro-container input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.image-preview {
  margin-top: 1rem;
  text-align: center;
}

.image-preview img {
  max-width: 100%;
  max-height: 200px;
  object-fit: cover;
}
</style>
