# 📦 Inventory API

REST API built with **Laravel 12** applying **Repository Pattern**, **Service Layer**, **DTOs**, and **automated tests**.

## Stack

- PHP 8.5 + Laravel 12
- PostgreSQL 16
- Nginx
- Docker

## Patterns Applied

| Pattern | Type | Description |
|---------|------|-------------|
| **Repository Pattern** | Design Pattern — Structural (GoF) | Abstracts data access behind interfaces; decouples business logic from persistence |
| **Service Layer** | Architectural Pattern (Fowler, PoEAA) | Centralizes and orchestrates business logic; defines the application boundary between controllers and domain |
| **DTO** — Data Transfer Object | Design Pattern (Fowler, PoEAA) | Transfers data between layers without exposing models or coupling internal structures |
| **Form Request** | Input Object + Validation (Laravel) | Encapsulates validation and authorization per operation; the general pattern is an *Input Object* with integrated validation |
| **API Resource** | Presenter / Transformer Pattern | Transforms Eloquent models into controlled JSON responses; decouples representation from persistence |

## Setup

```bash
# Clone the repo
git clone <repo-url> inventory-api
cd inventory-api

# Full setup
docker compose build
docker compose up -d
docker compose exec app composer install
docker compose exec app cp .env.example .env
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

API will be available at `http://localhost:8000`

## Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/v1/products` | List products |
| POST | `/api/v1/products` | Create product |
| GET | `/api/v1/products/{id}` | Get product |
| PUT | `/api/v1/products/{id}` | Update product |
| DELETE | `/api/v1/products/{id}` | Delete product |
| GET | `/api/v1/categories` | List categories |
| POST | `/api/v1/categories` | Create category |

## Architecture

```
app/
├─ Repositories/
│   ├─ Contracts/           ← Interfaces (contracts)
│   └─ Eloquent/            ← Eloquent implementations
├─ Services/                ← Business logic
├─ DTOs/                    ← Data Transfer Objects
├─ Http/
│   ├─ Controllers/Api/     ← Thin controllers
│   ├─ Requests/            ← Validation
│   └─ Resources/           ← JSON transformation
tests/
├─ Unit/                    ← Service Layer tests
└─ Feature/                 ← Full API tests
```
