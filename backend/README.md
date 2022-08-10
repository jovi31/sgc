# SGC (Backend)

Sistema de gerenciamento de conteúdo

## Configuração

- Crie um arquivo .env com base no .env.example
- Preencha os dados do banco no arquivo .env
- Defina um novo valor para o item JWT_KEY ou deixe como está

## Instalação
```bash
composer install
php artisan migrate
php artisan db:seed
```

## Rodar em modo de desenvolvimento
```bash
php artisan serve
```

Conta de teste:
- username: admin@mail.com
- password: 123456