# Syscompp

## Inicialização do projeto

**Obs**: tenha o PHP 8.1 ou mais recente instalado.

### Dependências

Ao clonar o projeto, instale as dependências via o comando ```composer install```, caso não o tenha instalado, siga o guia de instalação https://getcomposer.org/download/

### Variáveis de ambiente

As credenciais do banco de dados, são informações sensíveis, então não devem ser armazenadas diretamente no repositório, por isso:
- crie na raiz do projeto um arquivo chamado ```.env```;
- siga o modelo do arquivo ```.env.example``` que contém o nome das variáveis que seu ```.env``` deve ter;
- coloque as credenciais de seu banco local, e seu ambiente de desenvolvimento estará pronto.
- As credenciais do banco do servidor estão salvas no drive compartilhado.

## Rodando o projeto no ambiente de desenvolvimento

Para executar o projeto, rode o comando ```php -S localhost:<port>``` no terminal de comandos, na raiz do projeto. Notando que ```<port>``` pode ser qualquer porta de escolha (normalmente sendo a 8000).
