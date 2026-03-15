# 📦 Inventory API

API REST de inventario construida con **Laravel 12** aplicando **Repository Pattern**, **Service Layer**, **DTOs** y **tests automatizados**.

## Stack

- PHP 8.5 + Laravel 12
- PostgreSQL 16
- Redis 7
- Nginx
- Docker

## Patrones aplicados

- **Repository Pattern** — Abstracción del acceso a datos mediante interfaces
- **Service Layer** — Lógica de negocio desacoplada de los controllers
- **DTOs** — Transferencia de datos sin acoplar capas
- **Form Requests** — Validación desacoplada del controller
- **API Resources** — Transformación controlada de respuestas JSON

## Setup

```bash
# Clonar el repo
git clone <repo-url> inventory-api
cd inventory-api

# Setup completo
docker compose build
docker compose up -d
docker compose exec app composer install
docker compose exec app cp .env.example .env
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

La API estará disponible en `http://localhost:8000`

## Endpoints

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/v1/products` | Listar productos |
| POST | `/api/v1/products` | Crear producto |
| GET | `/api/v1/products/{id}` | Ver producto |
| PUT | `/api/v1/products/{id}` | Actualizar producto |
| DELETE | `/api/v1/products/{id}` | Eliminar producto |
| GET | `/api/v1/categories` | Listar categorías |
| POST | `/api/v1/categories` | Crear categoría |

## Arquitectura

```
app/
├─ Repositories/
│   ├─ Contracts/           ← Interfaces (contratos)
│   └─ Eloquent/            ← Implementaciones con Eloquent
├─ Services/                ← Lógica de negocio
├─ DTOs/                    ← Data Transfer Objects
├─ Http/
│   ├─ Controllers/Api/     ← Controllers delgados
│   ├─ Requests/            ← Validación
│   └─ Resources/           ← Transformación JSON
tests/
├─ Unit/                    ← Tests del Service Layer
└─ Feature/                 ← Tests de la API completa
```