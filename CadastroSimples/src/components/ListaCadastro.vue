<template>
  <div class="cadastros-container">
    <h1>Lista de Cadastros</h1>
    <router-link to="/novo-cadastro">
      <button class="btn">Novo Cadastro</button>
    </router-link>

    <!-- Filtros -->
    <div class="filters">
      <input class="white-text" v-model="filtroNome" placeholder="Filtrar por nome" />
      <input
        class="white-text"
        v-model="filtroDataInicio"
        type="date"
        placeholder="Data de nascimento início"
      />
      <input
        class="white-text"
        v-model="filtroDataFim"
        type="date"
        placeholder="Data de nascimento fim"
      />
      <input class="white-text" v-model="filtroEmail" placeholder="Filtrar por email" />
      <button class="btn-small" @click="limparFiltros">Limpar</button>
    </div>

    <!-- Ordenação -->
    <div class="sort-options">
      <span>Ordenar por:</span>
      <button class="btn-small" @click="setSortField('nome')">Nome</button>
      <button class="btn-small" @click="setSortField('data_nascimento')">Data de Nascimento</button>
      <button class="btn-small" @click="setSortField('id')">Ordem de Cadastro</button>
      <button class="btn-small" @click="toggleSortOrder">
        Alternar Ordem ({{ sortOrder === 'asc' ? 'Ascendente' : 'Descendente' }})
      </button>
    </div>

    <!-- Tabela de Cadastros -->
    <table class="highlight">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Data de Nascimento</th>
          <th>Email</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="cadastro in cadastrosFiltradosOrdenados" :key="cadastro.id">
          <td>{{ cadastro.nome }}</td>
          <td>{{ cadastro.data_nascimento }}</td>
          <td>{{ cadastro.email }}</td>
          <td>
            <button class="btn-small" @click="editarCadastro(cadastro)">
              <i class="material-icons">editar</i>
            </button>
            <button class="btn-small red" @click="excluirCadastro(cadastro.id)">
              <i class="material-icons">excluir</i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const cadastros = ref([])
const filtroNome = ref('')
const filtroDataInicio = ref('')
const filtroDataFim = ref('')
const filtroEmail = ref('')
const sortField = ref('nome')
const sortOrder = ref('asc')

// Função para buscar a lista de cadastros
const buscarCadastros = async () => {
  try {
    const response = await axios.get('http://localhost:8000/pessoa')
    cadastros.value = response.data.pessoas || []
  } catch (error) {
    console.error('Erro ao buscar cadastros:', error)
  }
}

const limparFiltros = () => {
  filtroNome.value = ''
  filtroDataInicio.value = ''
  filtroDataFim.value = ''
  filtroEmail.value = ''
}

// Chama a função de busca quando o componente é montado
onMounted(() => {
  buscarCadastros()
})

const editarCadastro = (cadastro) => {
  router.push({ name: 'EditarCadastro', params: { id: cadastro.id } })
}

const excluirCadastro = async (id) => {
  try {
    await axios.delete(`http://localhost:8000/pessoa/deletar/${id}`)
    cadastros.value = cadastros.value.filter((c) => c.id !== id)
  } catch (error) {
    console.error('Erro ao excluir cadastro:', error)
  }
}

const setSortField = (field) => {
  sortField.value = field
}

const toggleSortOrder = () => {
  sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc'
}

const cadastrosFiltradosOrdenados = computed(() => {
  let result = cadastros.value

  // Filtro por nome
  if (filtroNome.value) {
    result = result.filter((cadastro) =>
      cadastro.nome.toLowerCase().includes(filtroNome.value.toLowerCase())
    )
  }

  // Filtro por data de nascimento
  if (filtroDataInicio.value || filtroDataFim.value) {
    result = result.filter((cadastro) => {
      const dataNascimento = new Date(cadastro.data_nascimento)
      const dataInicio = filtroDataInicio.value
        ? new Date(filtroDataInicio.value)
        : new Date('1900-01-01')
      const dataFim = filtroDataFim.value ? new Date(filtroDataFim.value) : new Date('2100-12-31')
      return dataNascimento >= dataInicio && dataNascimento <= dataFim
    })
  }

  // Filtro por email
  if (filtroEmail.value) {
    result = result.filter((cadastro) =>
      cadastro.email.toLowerCase().includes(filtroEmail.value.toLowerCase())
    )
  }

  // Ordenação
  result = result.sort((a, b) => {
    let modifier = 1
    if (sortOrder.value === 'desc') modifier = -1

    if (a[sortField.value] < b[sortField.value]) return -1 * modifier
    if (a[sortField.value] > b[sortField.value]) return 1 * modifier
    return 0
  })

  return result
})
</script>

<style scoped>
.cadastros-container {
  padding: 2rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  border: 1px solid #ccc;
  border-radius: 8px;
}

.filters,
.sort-options {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
}

.white-text {
  color: white;
}

table {
  margin-top: 1rem;
  width: 100%;
}

.btn {
  margin-top: 1rem;
}

input[type='date']::-webkit-calendar-picker-indicator {
  filter: invert(0.8) brightness(1000%) sepia(0%) saturate(10000%) hue-rotate(240deg);
}
</style>
