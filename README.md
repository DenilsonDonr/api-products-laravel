# 📦 Inventory API

API REST de inventario construida con **Laravel 12** aplicando **Repository Pattern**, **Service Layer**, **DTOs** y **tests automatizados**.

## Stack

- PHP 8.5 + Laravel 12
- PostgreSQL 16
- Nginx
- Docker

## Patrones aplicados

| Patrón | Tipo | Descripción |
|--------|------|-------------|
| **Repository Pattern** | Design Pattern — Estructural (GoF) | Abstrae el acceso a datos detrás de interfaces; desacopla la lógica de negocio de la persistencia |
| **Service Layer** | Architectural Pattern (Fowler, PoEAA) | Centraliza y orquesta la lógica de negocio; define el límite de la aplicación entre controllers y dominio |
| **DTO** — Data Transfer Object | Design Pattern (Fowler, PoEAA) | Transporta datos entre capas sin exponer modelos ni acoplar estructuras internas |
| **Form Request** | Input Object + Validation (Laravel) | Encapsula validación y autorización por operación; el patrón general es *Input Object* con validación integrada |
| **API Resource** | Presenter / Transformer Pattern | Transforma modelos Eloquent en respuestas JSON controladas; desacopla la representación de la persistencia |

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