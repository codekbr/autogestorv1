# Nome do Projeto

Auto Gestor - Permissões de Usuário

## Índice

- [Visão Geral](#visão-geral)
- [Requisitos de Sistema](#requisitos-de-sistema)
- [Instalação](#instalação)
- [Uso](#uso)
- [Recursos](#recursos)
- [Testes](#testes)
- [Contato](#contato)

## Visão Geral

O projeto AutoGestor foi criado como parte de um processo seletivo na Autogestor.<br />
Trata-se de uma aplicação de administração que permite atribuir permissões a usuários para a execução de ações específicas.
<br />
Este projeto inclui recursos como  <br />
    Administrador pode: <br />
        &nbsp;&nbsp;&nbsp;      - Adicionar ou remover permissões de um usuário específico. <br />
            &nbsp;&nbsp;&nbsp;  - Administrador não precisa ter permissões. <br />
             &nbsp;&nbsp;&nbsp; - Administrador pode cadastrar se elas já não estiverem sido cadastradas na tabela de permissões. (aba-produto, aba-marcas, aba-categorias), podendo rodar também o comando no terminal  -  php artisan db:seed --class=PermissionsPadrao
   <br />
    Usuário pode: <br />
             &nbsp;&nbsp;&nbsp; - Vizualizar o Dashboard por padrão. <br />
              &nbsp;&nbsp;&nbsp;- Vizualizar as abas que o adminstrador lhe atribuiu; <br />

## Requisitos de Sistema

Para rodar o Projeto, é necessário atender aos seguintes requisitos de sistema:

    - PHP ^8.1 
    - Banco de dados MySQL
    - Composer 
    - Node (npm)
    
Certifique-se de que seu ambiente de desenvolvimento atenda a esses requisitos antes de prosseguir com a instalação.

## Instalação

    Para instalar e configurar o Projeto, siga estas etapas simples:

    1º Clone o repositório: Use o Git para clonar o repositório em seu ambiente de desenvolvimento local.
        - git clone https://github.com/codekbr/autogestorv1.git

    2º Acesse o diretório: Navegue até o diretório do projeto recém-clonado.
        - cd nome-do-projeto

    3º Instale as dependências: Use o Composer para instalar as dependências do projeto.
        - composer install

    4º Configure o arquivo .env: Faça uma cópia do arquivo .env.example e renomeie-o para .env. Em seguida, configure as informações do banco de dados e outras variáveis de ambiente conforme necessário.

    5º Gere a chave de aplicativo: Execute o seguinte comando para gerar uma chave de aplicativo única.
       - php artisan key:generate

    6º Execute as migrações: Crie as tabelas do banco de dados executando as migrações.
       - php artisan migrate

    7º Execute o Seeder para criar registros na tabela de Permissões ( serão permissões padrão que foi configurada no back-end ).
       - php artisan db:seed --class=PermissionsPadraoSeeder

    8º Inicie o servidor de desenvolvimento: Você pode iniciar um servidor de desenvolvimento local com o seguinte comando:
       - php artisan serve

    9º  Inicie o vite para compilar os arquivos do front-end:
       - npm run dev

    A aplicação agora deve estar em execução em http://localhost:8000. Você pode acessá-la em seu navegador.

## Uso
    Acessar a rota http://localhost:8000 você cairá na página de login onde existe um botão para você se registrar.

    Obs: foi configurado internamente no back-end um observador que lhe dará permissão de administrador ao fazer o cadastro, porém o usuário para administrador
    previamente configurado precisa ter o seguinte 
   
        Registre - se para administrador  com o email 
        email: admin@autogestor.com.br


    Após realizar o cadastro como Administrador você verá um botão com para gerenciar as permissões no canto superior direto de nome "Admin Área".
    Ao clicar cairá em uma tela para ver os usuários do sistema, nessa tabela você terá um botão para atribuir permissões para o usuário, mas antes disso,
    se você não executou o comando,  php artisan db:seed --class=PermissionsPadraoSeeder, você pode cadastrar as 3 opções de (marcas, produtos e categorias),
    clicando no botão verde ( Permissões ), lá você terá uma lista de todas as permissões que estão cadastradas internamente, se ainda não houver nenhuma, você
    verá um select para informar qual deseja incluir para poder vincular ao usuário.


## Recursos

    - Adicionar Permissões ao Usuário.
    - Cadastrar Permissões que está internamente em um Array fixo no back - end.
    - Remover uma Permissão

## Testes

    Você pode criar um usuário comum que será diferente o email para administrador ( admin@autogestor.com.br ) exemplo: ( comum@autogestor.com.br ).

    Você pode incluir uma permissão com a conta de administrador para um usuário comum, e testar as abas que eles possuí acesso, se for permitido, o usuário comum
    conseguirá vizualizar a aba e acessa-la, caso contrário não.

    Você pode remover a permissão do usuário clicando no botão input radio, revogando a permissão a determinada ação, e verificar com o usuário comum se ele não consegue vizualizar a aba que você removeu das permissões.
## Contato

Email: verycode@verycode.com.br
Email secundário: marcosit.developer@gmal.com



