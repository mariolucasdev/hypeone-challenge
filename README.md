# Hypeone Desafio Técnico

O objetivo deste desafio é a criação de uma API de atendimento simples
com a possibilidade de troca de mensagens entre dois usuários em
modelo de conversa, que deve conter backend utilizando PHP (com ou
sem framework, nos usamos Laravel). Esta API deve ser capaz de iniciar
e encerrar sessões de chat, registrar e ler as mensagens.

# Roadmap

-   Login/Cadastro
-   Cadastrar ou entrar em chat.
-   Troca de mensagens entre usuários.
-   Persistência de chats e mensagens no banco de dados.
-   Finalizar Chat;

# Instalação

### Renomeie o arquivo .env.example para .env

### Instale as dependências do back-end

```php
composer install
```

### Instale as dependências do Front-end

```js
npm install
```

### Execute as migrations

```
php artisan migrate
```

### Execute os seeders

```
php artisan db:seed
```

### Migrations e seeders de uma só vez

```
php artisan migrate --seed
```

# Inicie os Serviços

Serviço de filas:

```
php artisan queue:listen
```

Serviço de websocket:

```
php artisan websocket:serve
```

Front-end

```
npm run dev
```

Back-end

```
php artisan serve
```

# Usando

-   Abra o navegar em http://127.0.0.1:8000
-   No momento da seeders foram cadastrados 02 usuários que poderão ser usados para logar.
    ```
    Mário Lucas
    usuário: mario@hypeone.com.br
    senha: password
    ```
    ```
    Michele
    usuário: michele@hypeone.com.br
    senha: password
    ```
-   Para o segundo usuário é recomendado que o login seja feito através de outro navegador ou mesmo de uma guia anônima.
-   É possível entrar em um chat existente ou cadastrar um novo chat com título.
-   Depois é só interagir até um dos 02 encerrar o chat.

# Documentação da API

## Chats

| Método | Endpoint               | Parâmetros                    | Descrição                                | Retorno                |
| ------ | ---------------------- | ----------------------------- | ---------------------------------------- | ---------------------- |
| `GET`  | api/chats              | ---                           | Busca lista de chats ativos.             | 200                    |
| `GET`  | chat/:chatId/details   | ---                           | Retorna informações de detalhes do chat. | sucesso: 200 erro: 404 |
| `POST` | api/chat               | string username, string title | Inicia um novo chat.                     | sucesso: 201 erro: 422 |
| `PUT`  | api/chat/:chatId/close | string username               | Finaliza um chat, retornas seus dados.   | sucesso: 200 erro: 404 |

## Mensagens

| Método | Endpoint            | Parâmetros                                   | Descrição                             | Retorno                |
| ------ | ------------------- | -------------------------------------------- | ------------------------------------- | ---------------------- |
| `GET`  | api/message/:chatId | ---                                          | Retorna lista de mensages de um chat. | 200                    |
| `POST` | api/message/store   | int chat_id, string content, string username | Cadastra uma mensagem.                | sucesso: 201 erro: 422 |

# Testes

Para execução dos testes use o comando:

```
php artisan test
```

## Tests Chat

![#c5f015] PASS Tests\Feature\ChatTest
**✓** *shold create a new chat expect code 201 0.89s*
**✓** *shold receive error 302 becouse missed param 0.06s*
**✓** *close chat expected code 200 0.09s*
**✓** *shold receive error 404 becouse chat not exists 0.08s*
**✓** *shold get chat details expect code 200 0.06s*
**✓** *shold get chat details expect code correctly json structure 0.07s*
**✓** *shold fail becouse chat not exists expect 404 code*

## Tests Message

![#c5f015] PASS Tests\Feature\MessageTest

-   **✓** shold get chat messages expect code 200 0.11s
-   **✓** shold create a new message

Tests: 9 passed (21 assertions)
Duration: 2.06s

## Extras
Para simulção de requisições basta importar o arquivos **insomnia-requests.json**

1. Abra o Insomnia REST Client.
2. Clique em **New Document**, selecione Importar / Exportar.
3. Na aba Dados , selecione Importar Dados > Do Arquivo.
4. Clique em Importar.

## Considerações
Agradeço desde já a oportunidade da empresa Hypeone de participar desses desafio.

Depois dessa documentação, caso ainda fiquem dúvidas, estou à inteira disposição.

## Desenvolvido por Mário Lucas
mariolucasdev@gmail.com
