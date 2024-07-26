---

# Sistema de Cadastro Simples

Este projeto é um sistema de cadastro simples desenvolvido com Vue.js 3 no frontend e CodeIgniter 3 no backend, utilizando Docker para a configuração do banco de dados MySQL.


## Tecnologias Utilizadas

- **Login:** admin
- **Password:** 1233

## Tecnologias Utilizadas

- **Frontend:** Vue.js 3 com Vite
- **Backend:** CodeIgniter 3
- **Banco de Dados:** MySQL
- **Docker:** Para a configuração do banco de dados

## Instalação e Configuração

### Pré-requisitos

Certifique-se de ter as seguintes ferramentas instaladas:

- Docker
- Node.js e npm
- PHP
- Composer

### Passos para Configuração

1. **Configuração do Banco de Dados com Docker**

   Crie um arquivo `docker-compose.yml` para definir o serviço do banco de dados MySQL:

   ```yaml
   version: '3.1'

   services:
     db:
       image: mysql:8.0.30-debian
       environment:
         MYSQL_ROOT_PASSWORD: root
         MYSQL_DATABASE: CadastroSimplesDB
       ports:
         - "3306:3306"
   ```

   Execute o Docker Compose para iniciar o serviço:

   ```bash
   docker-compose up -d
   ```

2. **Configuração do Backend (CodeIgniter 3)**

   Navegue até a pasta do backend e instale as dependências do PHP:

   ```bash
   composer install
   ```

   Configure as variáveis de ambiente e conecte o CodeIgniter ao banco de dados MySQL configurado no Docker.

   Inicie o servidor PHP embutido:

   ```bash
   php -S localhost:8000
   ```

3. **Configuração do Frontend (Vue.js 3)**

   Navegue até a pasta do frontend e instale as dependências do npm:

   ```bash
   npm install
   ```

   Inicie o servidor de desenvolvimento:

   ```bash
   npm run dev
   ```

4. **Configuração de CORS**

   Para evitar problemas de CORS, adicione as seguintes linhas no seu controlador CodeIgniter para permitir a origem do frontend:

   ```php
   header('Access-Control-Allow-Origin: http://localhost:5173'); // Permitir apenas a origem do seu frontend
   header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS"); // Métodos permitidos
   header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding"); // Cabeçalhos permitidos
   ```

## Navegação

- **Página Inicial:** `/` - Tela de login
- **Lista de Usuários:** `/lista-usuarios` - Lista todos os usuários
- **Lista de Cadastros:** `/lista-cadastro` - Lista todos os cadastros com filtros e ordenação
- **Novo Cadastro:** `/novo-cadastro` - Formulário para criar um novo cadastro
- **Editar Cadastro:** `/editar-cadastro/:id` - Formulário para editar um cadastro existente

## Problemas Conhecidos

- **Erro de CORS:** Se encontrar erros de CORS, verifique se o backend está configurado para permitir a origem do frontend conforme descrito na seção de configuração de CORS.

---

Sinta-se à vontade para ajustar qualquer detalhe conforme necessário!
