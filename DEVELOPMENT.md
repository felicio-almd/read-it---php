# Annotations

Inicialmente comecei fazendo a modelagem dos dados com ajuda do Claude
para confirmar se não estava esquecendo de algum requisito. Preparei um
documento de ata de requisitos para o projeto, esclareci a visão geral,
os requisitos funcionais e não funcionais. A partir disso
preparei a modelagem de dados e o diagrama de tabelas que utilizaria
para ter todos os dados, esclarecendo as relações entre tabelas.

### Stack: PHP 8.3+, Laravel 12, FilamentPHP 4, Blade + Tailwind v4

## 1. Visão Geral do Projeto

    O projeto consiste em desenvolver um clone simplificado do Reddit com
    foco em funcionalidades essenciais de comunidades (subreddits), postagens, comentários e sistema de
    votação.

### 1.1 Objetivos Principais

Replicar estrutura básica de um fórum de discussão Permitir exploração
de subreddits (comunidades temáticas) Suportar publicação de conteúdo em
Markdown Implementar sistema de comentários hierárquicos Criar sistema
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
2. 4.1.2 Subreddits (Comunidades)
3. 4.1.3 Posts
4. 4.1.4 Comments (Comentários)
5. 4.1.5 Votes (Sistema de Votação)
6. 4.1.6 Memberships (Membros do Subreddit)

### Relacionamentos

Para o banco de dados e a modelagem usei o dbdiagram para saber das
tabelas https://dbdiagram.io/d/read-it-68d6a5b3d2b621e42215d6d2

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

## Funcionalidades Avançadas

1.  Sistema de Karma
2.  Moderação
3.  Notificações

## Performance

1. Otimização de Query

## Testes

## CI/CD
