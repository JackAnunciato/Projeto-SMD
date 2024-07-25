import { createRouter, createWebHistory } from 'vue-router'
import Login from './components/Login.vue'
import ListaUsuarios from './components/ListaUsuarios.vue'
import ListaCadastro from './components/ListaCadastro.vue'
import NovoCadastro from './components/NovoCadastro.vue'
import EditarCadastro from './components/EditarCadastro.vue'

const routes = [
  {
    path: '/',
    name: 'Login',
    component: Login
  },
  {
    path: '/lista-usuarios',
    name: 'ListaUsuarios',
    component: ListaUsuarios
  },
  {
    path: '/lista-cadastro',
    name: 'ListaCadastro',
    component: ListaCadastro
  },
  {
    path: '/novo-cadastro',
    name: 'NovoCadastro',
    component: NovoCadastro
  },
  {
    path: '/editar-cadastro/:id',
    name: 'EditarCadastro',
    component: EditarCadastro
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
