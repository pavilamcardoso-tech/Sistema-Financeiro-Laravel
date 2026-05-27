# Controle Financeiro

Sistema web de controle financeiro pessoal desenvolvido com Laravel 12.

---

## Funcionalidades

- Cadastro e gerenciamento de receitas e despesas
- Categorias personalizadas por tipo (receita ou despesa)
- Dashboard com saldo total, gráfico de barras por mês e gráfico de distribuição
- Filtro de transações por mês
- Sistema de autenticação com contas separadas por usuário
- Validação de formulários com mensagens em português
- Mensagens de sucesso e erro nas ações

---

## Tecnologias

- **PHP 8.2**
- **Laravel 12**
- **SQLite**
- **Laravel Breeze** — autenticação
- **Tailwind CSS** — estilização
- **Chart.js** — gráficos
- **Bootstrap 5** — componentes

---

## Como rodar localmente

### Pré-requisitos

- PHP 8.2+
- Composer
- Node.js e npm

### Passo a passo

```bash
# Clone o repositório
git clone https://github.com/pavilamcardoso-tech/Sistema-Financeiro-Laravel.git

# Entre na pasta
cd Sistema-Financeiro-Laravel

# Instale as dependências PHP
composer install

# Instale as dependências JS
npm install

# Copie o arquivo de ambiente
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate

# Crie o banco de dados
touch database/database.sqlite

# Rode as migrations
php artisan migrate

# Compile os assets
npm run build

# Suba o servidor
php artisan serve
```

Acesse **http://localhost:8000** no navegador.

---

## Estrutura do projeto

```
app/
├── Http/Controllers/
│   ├── DashboardController.php
│   ├── CategoryController.php
│   └── TransactionController.php
├── Models/
│   ├── Category.php
│   └── Transaction.php
database/
└── migrations/
resources/
└── views/
    ├── dashboard.blade.php
    ├── layout.blade.php
    ├── categories/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    └── transactions/
        ├── index.blade.php
        ├── create.blade.php
        └── edit.blade.php
routes/
└── web.php
```

---

## Banco de dados

```
users
├── id
├── name
├── email
└── password

categories
├── id
├── user_id
├── name
└── type (income | expense)

transactions
├── id
├── user_id
├── category_id
├── description
├── amount
├── type (income | expense)
└── date
```