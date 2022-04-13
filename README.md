Backend AMZ|MP
====

Checklist
----

- [ ] Autenticação
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

0. Criar um banco de dados;
0. Configurar o arquivo app/config/Database de acordo;
0. Executar o seguinte comando na pasta raíz do projeto para que as tabelas sejam criadas:
    > php spark migrate

Rotas
----
### Clientes

URL   |  Tipo | Ação
:--------- | ------:
/clientes | GET | Retornar todos os cliente
/clientes/{id} | GET | Retornar somente um cliente
/clientes | POST | Cadastrar um cliente
/clientes/{id} | PUT | Editar um cliente
/clientes/{id} | DELETE | Excluir um cliente

### Usuários

URL   |  Tipo | Ação
:--------- | ------:
/cadastro | POST | Cadastrar um usuário
/entrar | POST | Realizar o login na plataforma






