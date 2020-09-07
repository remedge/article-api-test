# 🚀 ArticleAPI test project

REST API for managing articles (CRUD).

## 🧱 Project structure

The architecture follow Domain-Driven Design, the structure includes 4 parts:
- Domain Layer
- Application Layer
- Framework Layer (Infrastructure)
- Context (HTTP-entrypoint)

There is a separate Command for each data-modifiying scenario. Command is handled with particular Handler through Command Bus. *league/tactician* Command Bus implementation is used.

Article Entity:
- id
- title
- body
- created timestamp
- updated timestamp
  
Creating/updating/deleting methods require secret token, passed as header "Authorization": "Bearer token".

List-endpoint allow following parameters:
- page (1, 2, etc.)
- sortByField ('id', 'title', 'body', 'createdAt', 'updatedAt')
- sortOrder ('asc', 'desc') 

All methods require header "Accept": "application/json". 

Creating/updating/deleting methods require header "Content-type": "application/json".

App architecture ready to expanding to communicate through XML format.

## 🏗️ Setup

1. `composer install`
2. `bin/console doctrine:schema:update --force`
3. `bin/console doctrine:fixtures:load -n`
4. `symfony server:start`
5. open http://127.0.0.1:8000/api/doc

(if you have not installed symfony installer, follow https://symfony.com/download )

## 📝 API-documentation

API-routes description implemented with NelmioApiDoc bundle. Documentation route http://127.0.0.1:8000/api/doc

## 🧪 Tests

Functional tests implemented with Behat/Mink. To run tests, execute command:

`./vendor/bin/behat`

## ✨ Code-style

To check code-style, execute command:

`./vendor/bin/php-cs-fixer fix src`
