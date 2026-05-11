
## 1. Project Overview

This project is an **internal Event Photography CRM** designed for **local PC / on‑premise use** by a photography studio. The system helps manage leads, clients, events, bookings, tasks, invoices, and reports.

There is **NO client portal**, **NO file/photo storage**, and **NO online payment processing** in the initial scope.

The system must be **simple, reliable, and optimized for desktop usage**, with future cloud migration kept in mind.

---

## 2. Key Objectives

* Centralize studio operations in one system
* Track leads → bookings → events → delivery status
* Manage photographers, editors, and tasks
* Track offline payments and invoices
* Generate business reports

---

## 3. Tech Stack (Mandatory)

### Backend

* **Laravel (latest LTS)**
* PHP 8.2+

### Frontend

* **Laravel Blade** (no SPA framework)
* Bootstrap or Tailwind CSS

### Database

* **MySQL / MariaDB**

### Deployment

* Local PC / On-Premise
* Environment: Windows or macOS

---

## 4. Explicitly Out of Scope

The AI agent must NOT implement:

* Client portal
* File or photo uploads
* Image galleries or storage
* Online payment gateways
* Mobile application
* Cloud-specific infrastructure

---

## 5. User Roles

| Role         | Description                        |
| ------------ | ---------------------------------- |
| Admin        | Full access, system setup, reports |
| Sales        | Leads, bookings, invoices          |
| Photographer | Assigned events, task updates      |
| Editor       | Post-event tasks                   |

Role-based access control is required.

---

## 6. Core Modules & Requirements

### 6.1 Authentication & Authorization

* Session-based authentication
* Role-based route protection

### 6.2 Lead Management

* Create, update, delete leads
* Lead pipeline statuses
* Assign leads to staff
* Notes & follow-ups

### 6.3 Client Management

* Convert lead to client
* Client profile with history
* Multiple events per client

### 6.4 Event Management

* Create and manage events
* Event details: date, venue, type
* Assign photographers/editors
* Event status tracking

### 6.5 Packages & Pricing

* Define photography packages
* Add-ons and custom pricing

### 6.6 Quotation & Contract Tracking

* Generate quotations (offline approval)
* Convert quotation to booking
* Contract status tracking (no e-sign)

### 6.7 Task & Workflow Management

* Pre-event, event-day, post-event tasks
* Task assignment & deadlines
* Status updates

### 6.8 Invoicing & Payments (Offline Only)

* Invoice generation
* Manual payment entry
* Payment status (Unpaid / Partial / Paid)

### 6.9 Reports & Dashboards

* Revenue summary
* Pending payments
* Event completion status

---

## 7. UI / UX Guidelines

* Desktop-first design
* Clean admin dashboard
* Simple navigation (sidebar + topbar)
* Minimal animations
* Focus on speed and clarity

---

## 8. Architecture Guidelines

* Use MVC properly
* Prefer service classes for business logic
* Keep controllers thin
* Use migrations & seeders
* Avoid hard-coded paths

---

## 9. Data & Storage Rules

* Database-only persistence
* No file system dependency except logs
* Regular DB backup support

---

## 10. Code Quality Expectations

* Clean, readable Laravel code
* Meaningful naming
* Form request validation
* Reusable Blade components
* Basic audit logging

---

## 11. Development Phases

1. Auth & Roles
2. Leads & Clients
3. Events & Packages
4. Quotations & Invoices
5. Tasks & Reports

Each phase must result in a usable system.

---

## 12. Future Considerations (Do Not Implement)

* Cloud hosting
* Client portal
* Photo storage
* Online payments
* API-first refactor

Design decisions should **not block** these enhancements later.

---

## 13. Success Criteria

* Works reliably on a single local PC
* Non-technical users can operate it
* No unnecessary complexity
* Clear upgrade path to cloud

---

**End of Context Document**
