<template>
  <div class="editar-cadastro-container">
    <h2>Editar Cadastro</h2>
    <form @submit.prevent="atualizarCadastro">
      <div>
        <label for="nome">Nome:</label>
        <input id="nome" class="white-text" v-model="cadastro.nome" type="text" required />
      </div>
      <div>
        <label for="telefone">Telefone:</label>
        <input id="telefone" class="white-text" v-model="cadastro.telefone" type="text" required />
      </div>
      <div>
        <label for="dataNascimento">Data de Nascimento:</label>
        <input
          id="dataNascimento"
          v-model="cadastro.dataNascimento"
          class="white-text"
          type="date"
          required
          @input="atualizarIdade"
        />
      </div>
      <div>
        <label for="idade">Idade:</label>
        <input id="idade" class="white-text" v-model="cadastro.idade" type="text" readonly />
      </div>
      <div>
        <label for="email">Email:</label>
        <input id="email" class="white-text" v-model="cadastro.email" type="email" required />
      </div>
      <div>
        <label for="imagem">Imagem:</label>
        <input
          id="imagem"
          class="white-text"
          type="file"
          @change="mostrarMiniatura"
          accept="image/*"
        />
        <div v-if="imagemPreview" class="image-preview">
          <img :src="imagemPreview" alt="Imagem Prévia" />
        </div>
      </div>
      <div>
        <button type="submit" class="btn">Salvar</button>
        <button type="button" @click="cancelarEdicao" class="btn red">Cancelar</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()

const cadastro = ref({
  id: '',
  nome: '',
  telefone: '',
  dataNascimento: '',
  idade: '',
  email: ''
})
const imagemPreview = ref('')
const imagemFile = ref(null)

// Função para calcular idade
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
  if (cadastro.value.dataNascimento) {
    cadastro.value.idade = calcularIdade(cadastro.value.dataNascimento)
  } else {
    cadastro.value.idade = ''
  }
}

// Função para mostrar a miniatura da imagem
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

// Função para carregar os dados existentes do cadastro
const carregarCadastro = async () => {
  const id = route.params.id
  try {
    const response = await axios.get(`http://localhost:8000/pessoa/${id}`)
    cadastro.value = response.data.pessoa
    if (response.data.imagem) {
      imagemPreview.value = `data:image/jpeg;base64,${response.data.imagem.imagem_base64}`
    }
  } catch (error) {
    console.error('Erro ao carregar dados do cadastro:', error)
  }
}

// Função para atualizar o cadastro
const atualizarCadastro = async () => {
  const formData = new FormData()
  formData.append('nome', cadastro.value.nome)
  formData.append('telefone', cadastro.value.telefone)
  formData.append('data_nascimento', cadastro.value.dataNascimento)
  formData.append('idade', cadastro.value.idade)
  formData.append('email', cadastro.value.email)

  if (imagemFile.value) {
    const reader = new FileReader()
    reader.onloadend = () => {
      const base64Image = reader.result.split(',')[1]
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
    const id = route.params.id
    const response = await axios.post(`http://localhost:8000/pessoa/atualizar/${id}`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    console.log(response.data)
    router.push('/lista-cadastro')
  } catch (error) {
    console.error('Erro ao atualizar o cadastro:', error.response?.data || error.message)
  }
}

const cancelarEdicao = () => {
  router.push('/lista-cadastro')
}

// Carrega os dados do cadastro quando o componente é montado
onMounted(() => {
  carregarCadastro()
})
</script>

<style scoped lang="scss">
.editar-cadastro-container {
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

.editar-cadastro-container h2 {
  margin-bottom: 1rem;
}

.editar-cadastro-container div {
  margin-bottom: 1rem;
}

.editar-cadastro-container label {
  display: block;
  margin-bottom: 0.5rem;
}

.editar-cadastro-container input {
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
