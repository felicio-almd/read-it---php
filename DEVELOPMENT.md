# Annotations

Inicialmente comecei fazendo a modelagem dos dados e a leitura do projeto em geral para fazer um mapeamento de requisitos.
Após isso, com ajuda do claude confirmei se não estava esquecendo de algum requisito nas partes de features que não conhecia(como o sistema de hierarquia, como eu poderia fazer). Preparei um documento de ata de requisitos para o projeto que facilita o meu passo a passo no desenvolvimento e posso fazer checklists das coisas que preciso implementar e até coisas que posso deixar em segundo plano para serem desenvolvidas depois do principal de verdade estar pronto, esclareci a visão geral, os requisitos funcionais e não funcionais e a arquitetura do projeto. A partir disso preparei a modelagem de dados e o diagrama de tabelas que utilizaria para ter todos os dados, esclarecendo as relações entre tabelas.

### Stack: PHP 8.3+, Laravel 12, FilamentPHP 4, Blade + Tailwind v4

## 1. Visão Geral do Projeto

    O projeto consiste em desenvolver um clone simplificado do Reddit com
    foco em funcionalidades essenciais de comunidades (subreddits), postagens, comentários e sistema de
    votação.

### 1.1 Objetivos Principais

Replicar estrutura básica de um fórum de discussão Permitir exploração
de subreddits (comunidades temáticas) Suportar publicação de conteúdo em
Markdown Implementar sistema de comentários hierárquicos. Criar sistema
de votação (upvote/downvote) Fornecer painel administrativo completo

## 2. Requisitos Funcionais

1. Gestão de Usuários
2. Subreddits (Comunidades)
3. Posts
4. Sistema de Votação
5. Comentários
6. Painel Administrativo (filament)

## 3. Modelagem de Dados

### Entidades Principais

1. Users (Usuários)
2. Subreddits (Comunidades)
3. Posts
4. Comments (Comentários)
5. Votes (Sistema de Votação)
6. Memberships (Membros do Subreddit)

### Relacionamentos

Para o banco de dados e a modelagem usei o dbdiagram para saber das tabelas

https://dbdiagram.io/d/read-it-68d6a5b3d2b621e42215d6d2

Para implementar os comentários hierárquicos no meu app (da tabela de comments), optei pela estratégia de Materialized Path.
Nela, cada comentário guarda o caminho completo até ele (por exemplo: 1/5/9), o que me permite recuperar facilmente toda a árvore de respostas de um comentário usando consultas simples, como LIKE '1/5/%', então posso retornar na ordem que preciso para minha view dos posts. Essa abordagem eu nunca havia colocado em prática mas conhecia, com ajuda de vídeos e IA consegui implementar.

Escolhi essa abordagem porque ela é simples de implementar, deixa as consultas rápidas e facilita a exibição das threads. A principal desvantagem é que mover um comentário para outro lugar exige atualizar seus descendentes, mas no meu caso isso não é um problema, já que os comentários não mudam de posição depois de criados.

- User Relationships
  User → Posts: 1:N (Um usuário pode ter muitos posts)

User → Comments: 1:N (Um usuário pode ter muitos comentários)

User → Votes: 1:N (Um usuário pode ter muitos votos)

User → Subreddits: 1:N (Um usuário pode criar muitos subreddits)

User → Memberships: 1:N (Um usuário pode sermembro de muitos subreddits)

- Subreddit Relationships

Subreddit → Posts: 1:N (Um subreddit pode ter muitos posts)

Subreddit → Memberships: 1:N (Um subreddit pode ter muitos membros)

Subreddit → User (creator): N:1 (Muitos subreddits pertencem a um criador)

- Post Relationships

Post → Comments: 1:N (Um post pode ter muitos comentários)

Post → Votes: 1:N (Polimórfico - um post pode ter muitos votos)

Post → User: N:1 (Muitos posts pertencem a um usuário)

Post → Subreddit: N:1 (Muitos posts pertencem a um subreddit)

- Comment Relationships

Comment → Comment (parent): N:1 (Muitos comentários podem ter um pai)

Comment → Votes: 1:N (Polimórfico - um comentário pode ter muitos votos)

Comment → User: N:1 (Muitos comentários pertencem a um usuário)

Comment → Post: N:1 (Muitos comentários pertencem a um post)

Optei pela tabela membership como pivo para ter acesso fácil aos membros e os subreddits que eles estão inclusos e defini a relação nos models

## Arquitetura em Camadas

5.1 Estrutura de Camadas

```ini
┌─────────────────┐
│ Frontend        │ ← Blade Templates + Tailwind CSS
├─────────────────┤
│ Controllers     │ ← Laravel Controllers
├─────────────────┤
│ Services        │ ← Business Logic Layer
├─────────────────┤
│ Repositories    │ ← Data Access Layer
├─────────────────┤
│ Models          │ ← Eloquent ORM Models
├─────────────────┤
│ Database        │ ← SQLite/PostgreSQL
└─────────────────┘
```

## Segunda Fase - Desenvolvimento

### Aqui digo as decisões tomadas em fase de desenvolvimento

Para configurar o ambiente, na .env faça a troca do SQLITE para postgres
Configuração do ambiente

```ini
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nome_do_projeto_db
DB_USERNAME=meu_usuario
DB_PASSWORD=
```

Mesmo localmente escolhi trabalhar com o postgres para garantir que
estaria trabalhando com a mesma database que iria para o container

## Para começar o projeto

### Localmente

Se baseando que o usuário tenha node, php e composer instalados em sua máquina. Além disso deve ter todas extensões para usar php com filament e postgresql.
entre elas: php8.3-xml php8.3-intl php8.3-mbstring php8.3-curl php8.3-bcmath php8.3-gd php8.3-pgsql php8.3-zip php8.3-cli php8.3-common php8.3-intl php8.3-bcmath php8.3-ctype php8.3-fileinfo php8.3-tokenizer php8.3-json php8.3-exif

Comece usando o `composer install` para instalar as dependencias do PHP e `npm install` para instalar as dependencias do front

Para rodar o projeto, use o comando `composer run dev`

### Docker

### Em Segundo plano

Fiz a geração do resource do filament padrão para economizar tempo na parte do admin, defini relações básicas e consertei alguns input que não vinham com espaços corretos. Nessa parte usei IA pontualmente só para confirmar o que podia ser o erro que tive de não aparecer na sidebar os recursos, mas descobri a solução a partir do discord do 3 pontos usando `composer du`.

Biblioteca de Mídia: Para lidar com uploads de imagens (avatares de usuário, imagens de posts), com ajuda do Gemini optei por usar o pacote spatie/laravel-medialibrary. Ele oferece uma solução que podia usar coleções e conversões de imagem, e se integra bem com o Filament.

Criei niveis de acesso para usuários fazerem login na plataforma e no admin so poder acessador quem tiver permissão avançada, pra isso mudei um pouco a lógica no model de User mas basicamente retringi o acesso ao painel e criei novos campos no painel admin. Utilizei o breeze para login dos usuários no site em si, sem ter acesso ao painel.

Factories e Seeders:
Desenvolvi factories para os models User, Subreddit e Post para permitir a semear o banco de dados com dados de teste.

### Funcionalidade: a Lógica de Threading

A "mágica" do depth e path (que foi a abordagem que usei) acontece automaticamente quando um comentário for criado. A lógica foi usada diretamente no model

## Funcionalidades Avançadas

1.  Sistema de Karma
2.  Moderação
3.  Notificações

## Performance

1. Otimização de Query

## Testes

## CI/CD
