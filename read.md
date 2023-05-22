### Pré-requisitos

Certifique-se de ter os seguintes pré-requisitos instalados em seu sistema:

- Docker: https://www.docker.com/get-docker
- Docker Compose: https://docs.docker.com/compose/install/

### Passo 1: Clone o repositório

1. Abra o terminal ou o prompt de comando.
2. Navegue até o diretório onde deseja clonar o repositório.
3. Execute o seguinte comando para clonar o repositório:

   ```bash
   git clone https://
   ```

4. Após a conclusão, você terá uma cópia local do repositório em seu sistema.

### Passo 2: Configure as variáveis de ambiente

1. Navegue até o diretório do projeto clonado.
2. Renomeie o arquivo `.env.example` para `.env`.
3. Abra o arquivo `.env` em um editor de texto.
4. Defina os valores das variáveis de ambiente de acordo com sua configuração. Certifique-se de definir as seguintes variáveis:

    - `DB_CONNECTION`: O driver de conexão do banco de dados (por exemplo, `mysql`).
    - `DB_HOST`: O endereço do host do banco de dados (por exemplo, `db`).
    - `DB_PORT`: A porta do banco de dados (por exemplo, `3306`).
    - `DB_DATABASE`: O nome do banco de dados.
    - `DB_USERNAME`: O nome de usuário do banco de dados.
    - `DB_PASSWORD`: A senha do banco de dados.

5. Salve o arquivo.

### Passo 3: Execute o Docker Compose

1. No terminal ou prompt de comando, navegue até o diretório do projeto clonado.
2. Execute o seguinte comando para iniciar os contêineres do Docker:

   ```bash
   docker-compose up -d
   ```

3. O Docker Compose baixará e configurará todas as dependências necessárias e iniciará os contêineres.
4. Aguarde até que o processo seja concluído.

### Passo 4: Execute as migrações e as seeds

1. Após iniciar os contêineres, execute o seguinte comando para acessar o shell do contêiner da aplicação:

   ```bash
   docker-compose exec app bash
   ```

2. Dentro do shell do contêiner, execute as migrações do banco de dados usando o seguinte comando:

   ```bash
   php artisan migrate
   ```

3. Em seguida, execute as seeds para popular o banco de dados com alguns dados de exemplo:

   ```bash
   php artisan db:seed
   ```

4. Quando as migrações e as seeds forem concluídas, você terá o banco de dados configurado e preenchido.

### Passo 5: Acesse o aplicativo

1. Abra o navegador da web.
2. Acesse a seguinte URL:

   ```
   http://localhost:8000
   ```

3. Você será redirecionado para a página inicial do aplic

ativo.

### Passo 6: Explorando o CRUD

Agora que o aplicativo está instalado e em execução, você pode explorar as funcionalidades do CRUD:

- Acesse a página inicial para visualizar a lista de pedidos.
- Clique em "Criar Pedido" para adicionar um novo pedido.
- Clique em "Detalhes" para visualizar os detalhes de um pedido específico.
- Clique em "Editar" para modificar um pedido existente.
- Clique em "Excluir" para remover um pedido.
- Clique em "Importar" para importar um pedido.
- Clique em "Exportar" para exportar os pedidos via pdf.

### Exemplos de json e csv para enviar
JSON
```
   [
        {
            "delivery_date": "2023-02-20 00:00:00",
            "freight_value": 80
        }
   ]
```
CSV
```
    delivery_date,freight_value
    2023-02-20 00:00:00,50.88
    2023-02-20 00:00:00,60.2
```
### Testes
Este projeto inclui testes automatizados para garantir a qualidade e funcionamento adequado do código. Para executar os testes, siga os passos abaixo:

1. Acesse o diretório do projeto:

2. Execute o comando para executar os testes:

```
    php artisan test
```
Isso encerrará e removerá os contêineres Docker associados ao aplicativo.


Os testes serão executados e você poderá ver os resultados no terminal.

### Passo 7: Encerrando os contêineres

Quando você terminar de usar o aplicativo, você pode encerrar os contêineres do Docker:

1. No terminal ou prompt de comando, navegue até o diretório do projeto clonado.
2. Execute o seguinte comando para encerrar os contêineres:

   ```bash
   docker-compose down
   ```
## Contribuição

Contribuições são bem-vindas! Se você encontrar algum problema, tiver alguma sugestão ou quiser contribuir de alguma forma, sinta-se à vontade para abrir uma issue ou enviar um pull request.

## Licença

Este projeto está licenciado sob a licença MIT. Leia o arquivo [LICENSE](LICENSE) para mais detalhes.
