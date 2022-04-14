Backend AMZ|MP
====

Checklist
----

- [x] Autenticação
- [x] Cadastro de clientes
- [x] Listagem de clientes
- [x] Edição de clientes
- [x] Remoção de clientes

Ferramentas utilizadas
----

- Framework CodeIgniter 4;
- Postman;

Instruções
----

1. Criar um banco de dados;
2. Configurar o arquivo app/config/Database de acordo;
0. Executar o seguinte comando na pasta raíz do projeto para que as tabelas sejam criadas:
```php 
  php spark migrate
```
- Criar um arquivo .env para definir as variáveis de ambiente:
    0. Criar a variável **SECRET_KEY** e atribuir a ela uma chave(esta chave servirá para autenticação):
    ```php 
      # Exemplo
      SECRET_KEY = "sua_chave_secreta_aqui"
    ```

Rotas
----
<p>Um arquivo de coleções do postman foi enviado juntament com o projeto na raiz da aplicação</p>

### Clientes

**Atenção**
>  Todas as rotas de clientes necessitam de autenticação via Bearer Token, o Bearer Token que é gerado quando o usuário faz login no sistema

URL   |  Tipo | Ação
:--------- | ------- | ------:
/clientes | GET | Retornar todos os cliente
/clientes/{id} | GET | Retornar somente um cliente
/clientes | POST | Cadastrar um cliente
/clientes/{id} | PUT | Editar um cliente
/clientes/{id} | DELETE | Excluir um cliente

### Usuários

URL   |  Tipo | Ação
:---------| -------- | ------:
/cadastro | POST | Cadastrar um usuário
/entrar | POST | Realizar o login na plataforma






