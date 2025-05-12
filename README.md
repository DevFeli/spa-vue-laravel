# 🛒 Sistema de Cadastro de Produtos

Este projeto é uma aplicação fullstack desenvolvida para um teste técnico. Ele permite o cadastro, edição, visualização e inativação de produtos, com autenticação de usuário e validações específicas.

---

## 📌 Requisitos Técnicos

- **PHP**: 8
- **Laravel**: 9
- **MySQL**: 8
- **Vue**: 3
- **Ambiente**: Docker (sem Laravel Sail)

---

## ⚙️ Instalação

### Pré-requisitos

- Docker
- Docker Compose
- Git

### Passos

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/nome-do-repositorio.git
cd nome-do-repositorio

# Copie o .env de exemplo
cp .env.example .env

# Altere as credenciais de acesso ao banco de dados caso necessario:
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=application
DB_USERNAME=user
DB_PASSWORD=root

# Suba os containers
docker-compose up -d

# Acesse o container do PHP
docker exec -it laravel_app bash

# Instale as dependências
composer install

# Gere a chave da aplicação
php artisan key:generate

# Gere o link simbólico
php artisan storage:link

# Execute as migrations
php artisan migrate

# Rode os seeders para criar o usuário padrão
php artisan db:seed
# Credenciais padrão
email admin@admin
pas 123

# Acesse o container do VUEJS
docker exec -it vue_frontend bash

# Instale as dependências
npm install

```

🧾 Funcionalidades

Listagem de produtos

Cadastro de produtos

Edição de produtos

Inativação de produtos

# Validações
Preço de venda ≥ custo + 10%

Apenas imagens .jpg e .png são permitidas

O campo de descrição aceita apenas tags HTML: <p>, <br>, <b>, <strong>

# Usuários
Login com autenticação (JWT)

CRUD de usuários (diferencial implementado)

# Logs
Registro de criação e modificação de produtos

👤 Manual do Usuário

(Se recarregada a página deverá ser feito o login novamente)

1. Login
Acesse a tela inicial (Login).

Informe os dados do usuário padrão (cadastrado via seeder).

2. Dashboard de Produtos
Após o login, será exibida uma lista de produtos com opções:

Cadastrar Produto

Editar Produto

Inativar Produto

3. Cadastro / Edição de Produto
Campos obrigatórios:

Título

Imagens (somente .jpg ou .png) - (Inseir novas ou excluir existente)

Preço de venda

Custo

Descrição (HTML limitado a <p>, <br>, <b>, <strong>)

Validações:

Preço de venda ≥ custo + 10%

HTML limitado nas descrições e sanitizado no front e no back

Além de outras validações simples de input

4. Inativar Produto
Produtos podem ser inativados ao invés de deletados.

Inativos aparecem ao final da listagem (TODO implementar filtros 'ativos/inativos').

🧱 Arquitetura do Sistema
Backend:

Linguagem: PHP 8

Framework: Laravel 9

Banco de Dados: MySQL 8

Ambiente: Docker (sem Laravel Sail)

Autenticação: Login com usuário padrão(JWT e Middlewares de autenticação e proteção nas rotas) 

Validações: Implementadas no backend

Servidor:

Nginx para servir a aplicação na porta 80 (TODO implementar certificado SSL para previnir ataque Man in the middle)

Frontend:

Framework: Vue 3

Integração com API: Axios

Estilos Tailwindcss

Recursos Extras Implementados (Diferenciais):

Log de criação e edição de produtos(automático qualquer tipo de transação no banco de dados como cadastrar um produto oou atualizar automaticamente é gerado um log)

CRUD de usuários

Aplicação de boas práticas de segurança(Autenticação e autorização com token JWT)

Testes unitários

Documentação completa

🔒 Segurança

Upload restrito a imagens válidas

Validação de HTML no backend e no frontend

Middleware de autenticação protegendo rotas privadas

Senhas com hash seguro (bcrypt)

🧪 Testes
Testes unitários com PHPUnit

Validação de regras de negócio

Para rodar:
docker exec -it laravel_app bash
php artisan test