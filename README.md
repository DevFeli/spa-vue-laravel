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
docker exec -it nome_do_container_php bash

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
docker exec -it nome_do_container_php bash

# Instale as dependências
npm install
