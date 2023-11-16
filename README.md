# Desafio | CodeIgniter

> ## Observações

Busquei aplicar todos os requisitos e diferenças. No entanto, os testes da aplicação não foram finalizados.
<br> Utilizei o Shield para a criação de todo o sistema de autenticação (Views e Tabelas).
<br> Para segurança, busquei utilizar tudo o que o framework oferece, validando toda a parte web com sessão e csrf e a parte de api com tokens e configurei rate limit para rotas de autenticação.

> ## Executando a Aplicação

**Env:** Renomeie o arquivo `env` localizado na pasta `src` para `.env` e configure-o ou copie e cole as informações a seguir.

Na variável hostname`{ALTERE AQUI}`, se você estiver utilizando o Docker, altere para "postgres"; caso contrário, deixe como "localhost".

```env
CI_ENVIRONMENT = development
APP_NAME = 'OM30'
app.baseURL = 'http://localhost:8080'

database.default.hostname = {ALTERE AQUI}
database.default.database = ci4
database.default.username = postgres
database.default.password = root
database.default.DBDriver = Postgre
database.default.DBPrefix =
database.default.port = 5432

database.tests.hostname = {ALTERE AQUI}
database.tests.database = ci4_test
database.tests.username = postgres
database.tests.password = root
database.tests.DBDriver = Postgre
database.tests.DBPrefix =
database.tests.port = 5432
```

### Executando com Docker

Certifique-se de ter o Docker instalado em sua máquina.

**1 - Iniciar Docker:** Acesse a pasta `src` com o comando `cd src`, e execute o comando `docker compose up`.
<br> **2 - Acessar Container:** Execute o comando `docker exec -it ci4-server //bin//sh`. Se caso não funcionar tente com `/bin/sh`.
<br> **3 - Instalação de Dependências:** Dentro do container execute o comando `composer up` para instalar todas as dependências necessárias.
<br> **4 - Rodar Migrations:** Dentro do container execute o comando `php spark migrate --all`.
<br> **5 - Rodar Seeders:** Após rodar as migrations execute o comando `php spark db:seed DatabaseSeeder`.

### Executando sem Docker

Certifique-se de ter o PostgreSQL instalado em sua máquina.

**1 - Instalação de Dependências:** Acesse a pasta `src` com `cd src`, e execute o comando `composer up` para instalar todas as dependências necessárias.
<br> **2 - Criando Banco de Dados:** Dentro da pasta `src` execute os comandos `php spark db:create ci4` e `php spark db:create ci4_test`. Se caso não funcionar crie os bancos `ci4` e `ci4_test` manualmente.
<br> **2 - Rodar Migrations:** Dentro da pasta `src` execute o comando `php spark migrate --all`.
<br> **3 - Rodar Seeders:** Após rodar as migrations, dentro da pasta `src` execute o comando `php spark db:seed DatabaseSeeder`.
<br> **4 - Iniciando o Servidor:** Execute `php spark serve` para iniciar o servidor na porta especificada no .env e todos os serviços da aplicação.

### Após inciar a aplicação se você seguiu o passo a passo poderá executar essas ações:

**Testes:** Para rodar os testes execute `composer run test`.
<br> **Web:** Acesse o sistema em `http://localhost:8080/login` e crie um cadastro.
<br> **Api:** Segue abaixo os endpoints para a utilização da API.

## Rotas

### Cadastro

Rota para se cadastrar no sistema.

-   **Método:** POST
-   **URL:** `http://localhost:8080/api/register`
-   **Headers:**
    -   `Content-Type` application/json
-   **Corpo da Requisição:**
    ```json
    {
        "username": "String (Obrigatório)",
        "email": "String (Obrigatório)",
        "password": "String (Obrigatório)",
        "password_confirm": "String (Obrigatório)"
    }
    ```

### Login

Rota para se autenticar e gerar o access token.

-   **Método:** POST
-   **URL:** `http://localhost:8080/api/login`
-   **Headers:**
    -   `Content-Type` application/json
-   **Corpo da Requisição:**
    ```json
    {
        "email": "String (Obrigatório)",
        "password": "String (Obrigatório)",
        "device_name": "String (Obrigatório)"
    }
    ```

### Listar Pacientes

Rota para listar pacientes com e sem filtro.

-   **Método:** GET
-   **URL:** `http://localhost:8080/api/patient`
-   **Headers:**
    -   `Content-Type` application/json
    -   `Authorization` Bearer Token
-   **Parâmetros de Consulta:**
    -   `search_deleted`: Boolean
    -   `search`: String
    -   `page`: Number

### Exibir informações de um paciente

Rota para exibir informações de um paciente.

-   **Método:** GET
-   **URL:** `http://localhost:8080/api/patient/{id: Number}`
-   **Headers:**
    -   `Content-Type` application/json
    -   `Authorization` Bearer Token

### Cadastrar um Paciente

Rota para Cadastrar um novo paciente.

-   **Método:** POST
-   **URL:** `http://localhost:8080/api/patient`
-   **Headers:**
    -   `Content-Type` multipart/form-data
    -   `Authorization` Bearer Token
-   **Corpo da Requisição:**

    ```json
    {
        "image": "Imagem (Opcional)",
        "name": "String (Obrigatório)",
        "mother_name": "String (Obrigatório)",
        "birth_date": "String (YYYY-mm-dd) (Obrigatório)",
        "cpf": "String (Obrigatório)",
        "cns": "String (Obrigatório)",
        "zip_code": "String (Obrigatório)",
        "street": "String (Obrigatório)",
        "number": "String (Opcional)",
        "neighborhood": "String (Obrigatório)",
        "city": "String (Obrigatório)",
        "state_id": "Boolean (Obrigatório)"
    }
    ```

### Atualizar um Paciente

Rota para atualizar um paciente.

-   **Método:** PATCH ou PUT
-   **URL:** `http://localhost:8080/api/patient/{id: Number}`
-   **Headers:**
    -   `Content-Type` multipart/form-data
    -   `Authorization` Bearer Token
-   **Corpo da Requisição:**

    ```json
    {
        "image": "Imagem (Opcional)",
        "name": "String (Opcional)",
        "mother_name": "String (Opcional)",
        "birth_date": "String (YYYY-mm-dd) (Opcional)",
        "cpf": "String (Opcional)",
        "cns": "String (Opcional)",
        "zip_code": "String (Opcional)",
        "street": "String (Opcional)",
        "number": "String (Opcional)",
        "neighborhood": "String (Opcional)",
        "city": "String (Opcional)",
        "state_id": "Boolean (Opcional)"
    }
    ```

### Deletar um Paciente

Rota para deletar um paciente.

-   **Método:** DELETE
-   **URL:** `http://localhost:8080/api/patient/{id: Number}`
-   **Headers:**
    -   `Content-Type` application/json
    -   `Authorization` Bearer Token

### Ativar um Paciente

Rota para ativar um paciente.

-   **Método:** PATCH
-   **URL:** `http://localhost:8080/api/patient/{id: Number}/active`
-   **Headers:**
    -   `Content-Type` application/json
    -   `Authorization` Bearer Token
