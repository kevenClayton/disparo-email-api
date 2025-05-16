# Disparo e-mail Backend

API RESTful construída com Laravel para disparo de e-mail com fila usando RabbitMQ. Suporta cadastro, disparo e exportação para Excel.

## 🚀 Requisitos

- PHP 8.1+
- Composer
- Docker + Laravel Sail (ou MySQL local)
- Mailpit (para testes de e-mail)

## ⚙️ Instalação


### Clonar o projeto
```bash
git clone https://github.com/kevenclayton/disparo-email-api.git
cd disparo-email-api
```

### Instalar dependências
```bash
composer install
```

### Copiar e configurar o .env

```bash
cp .env.example .env
php artisan key:generate
```

### Comando para criar álias ao comando sail
```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```

### Subir containers
```bash
sail up -d
```

### Rodar migrations
```
sail artisan migrate
```

## 📨 E-mails em fila
Ao cadastrar um disparo, um e-mail é enfileirado na fila emails para o endereço definido no **.env** em:

## Rodar projeto
### Rodar o Work
```bash
sail artisan queue:work --queue=emails
```

## ✅ Testes
```bash
sail artisan test
```

**Testes incluídos em:**

- Listagem
- Cadastro
- Exportação
- E-mail em fila
