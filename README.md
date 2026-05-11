# Lensio — Event Photography CRM

An internal CRM for photography studios to manage leads, clients, events, bookings, tasks, invoices, and reports. Built for local/on-premise use with a clean desktop-first interface.

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Blade, Bootstrap/Tailwind CSS
- **Database:** MySQL / MariaDB
- **Testing:** Pest

## Features

- **Lead Management** — Pipeline tracking, staff assignment, follow-ups
- **Client Management** — Convert leads to clients, full event history
- **Event Management** — Event details, photographer/editor assignment, status tracking
- **Packages & Pricing** — Photography packages with add-ons and custom pricing
- **Quotations & Contracts** — Generate quotations, convert to bookings, track contract status
- **Task & Workflow** — Pre-event, event-day, and post-event task management
- **Invoicing & Payments** — Invoice generation, manual payment entry, payment status tracking
- **Employee Management** — Staff records, salary tracking, payment history
- **Equipment Tracking** — Equipment inventory and event assignment
- **Reports & Dashboard** — Revenue summary, pending payments, event completion status
- **Audit Logging** — Activity tracking across the system
- **Role-Based Access** — Admin, Sales, Photographer, Editor roles

## Getting Started

### Requirements

- PHP 8.2+
- Composer
- Node.js & npm
- MySQL / MariaDB

### Installation

```bash
git clone <repo-url>
cd lensio
composer run setup
```

The `setup` script handles dependencies, `.env` creation, key generation, migrations, and frontend build.

### Development

```bash
composer run dev
```

Starts the Laravel server, queue worker, log watcher, and Vite dev server concurrently.

### Testing

```bash
composer run test
```

### Docker

See [DOCKER.md](DOCKER.md) for Docker-based setup instructions.

## Project Scope

This system is designed for **local/on-premise use only**. The following are intentionally out of scope:

- Client portal
- File/photo uploads or image storage
- Online payment gateways
- Mobile application
- Cloud-specific infrastructure

## License

MIT
