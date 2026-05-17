# Lensio — Event Photography CRM

Lensio is an internal CRM designed for photography studios to manage their end-to-end workflow—from lead acquisition to event delivery and reporting. It is optimized for local/on-premise usage with a desktop-first interface.

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Laravel Blade, Tailwind CSS (via Vite)
- **Database:** MySQL / MariaDB (Local), PostgreSQL (Docker)
- **Testing:** Pest
- **Process Management:** Concurrently (Local), Supervisord (Docker)

## Project Overview

- **Purpose:** Centralize studio operations including leads, clients, events, bookings, tasks, invoices, and employee salaries.
- **Scope:** Internal use only. No client portal, no file/photo storage, and no online payment processing.
- **Roles:** `admin`, `manager`, `sales`, `photographer`, `editor`.
- **Key Features:** Lead pipeline, client management, event assignment, package/pricing management, quotation/contract tracking, task workflow, offline invoicing/payments, employee management, equipment tracking, and financial reporting.

## Building and Running

### Local Development

- **Initial Setup:**
  ```bash
  composer run setup
  ```
  *This handles dependency installation, `.env` creation, key generation, migrations, and frontend build.*

- **Start Development Environment:**
  ```bash
  composer run dev
  ```
  *This concurrently runs the Laravel server, queue worker, log watcher (`pail`), and Vite dev server.*

- **Run Tests:**
  ```bash
  composer run test
  ```

### Docker Environment

- **Start Services:**
  ```bash
  docker compose up -d --build
  ```
- **Common Docker Commands:**
  - View logs: `docker compose logs -f app`
  - Artisan: `docker compose exec app php artisan <command>`
  - Bash shell: `docker compose exec app bash`

## Architecture & Development Conventions

- **MVC Pattern:** Adhere to clean MVC principles.
- **Thin Controllers:** Keep logic out of controllers; use them only for routing requests and returning responses.
- **Service Classes:** Encapsulate business logic in service classes (typically located in `app/Services/` - *Note: create this directory if it doesn't exist*).
- **Form Requests:** Use dedicated Form Request classes for validation (`app/Http/Requests/`).
- **Blade Components:** Prefer reusable Blade components for UI elements.
- **RBAC:** Access control is managed via `RoleMiddleware`. Roles are `admin`, `manager`, `sales`, `photographer`, `editor`.
- **Audit Logging:** The system uses an `AuditLog` model to track significant activities.
- **Desktop-First:** UI should be optimized for desktop usage as it is an internal tool.

## Directory Structure Highlights

- `app/Http/Controllers/`: Standard Laravel controllers.
- `app/Http/Requests/`: Validation logic.
- `app/Models/`: Eloquent models.
- `app/Http/Middleware/RoleMiddleware.php`: Role-based access control.
- `docs/`: Comprehensive project documentation and requirements.
- `resources/views/`: Blade templates, organized by module.
- `routes/web.php`: Primary web routes with role protections.

## Constraints

- **No File Storage:** Do not implement photo or file upload features.
- **No Online Payments:** All payments are manually tracked offline.
- **No Client Portal:** The system is strictly for internal staff.
- **Local Optimization:** Focus on speed and clarity for on-premise hardware.
