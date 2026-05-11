# REFACTORED_FEATURES.md

## Refactored Feature Set – Event Photography CRM

This document consolidates and **refactors the feature set** into clear, implementable modules for a **local-first Event Photography CRM** built with **Laravel + Blade + MySQL**.

The goal is to simplify workflows, improve operational visibility, and ensure accurate financial tracking without adding unnecessary complexity.

---

## 1. Dashboard – Operations Overview

### Purpose

Provide a **quick, at-a-glance view** of studio operations for Admin and Sales users.

### Features

* Today’s / upcoming events
* Pending leads & bookings
* Pending client payments
* Pending employee payments
* Monthly income vs expense summary

### UI Notes

* Card-based layout
* Table summaries (no heavy charts required)
* Role-based visibility (Admin sees financials)

---

## 2. Direct Customer Onboarding

### Purpose

Allow quick onboarding of customers **without lead conversion steps** when required.

### Features

* Simple customer input form
* Required fields:

  * Name
  * Phone
  * Email (optional)
  * Address (optional)
* Immediate client creation

### Rules

* Bypasses lead pipeline
* Still links to events normally

---

## 3. Event Schedule Management

### Purpose

Visual management of event schedules.

### Features

* Calendar view (monthly)
* Scheduled event dates highlighted
* Side panel showing:

  * Event name
  * Client
  * Venue
  * Assigned staff

### Rules

* Read-only calendar interaction (edit via event form)
* No external calendar sync

---

## 4. Package Management

### Purpose

Standardize pricing and offerings.

### Features

* Package CRUD
* Fields:

  * Name
  * Base price
  * Duration
  * Description
* Assign package to event

### Rules

* Price used as reference for invoice

---

## 5. Employee & Contractual Staff Management

### Purpose

Manage full-time, part-time, and contractual staff.

### Employee Types

* Full-time employee
* Part-time employee
* Contractual staff

### Features

* Employee CRUD
* Role designation (Photographer, Editor, Support)
* Employment type
* Active / inactive status

---

## 6. Salary & Event-wise Payment Tracking

### Purpose

Track payments made to staff.

### Payment Models

* Event-wise payment
* Monthly salary payment

### Features

* Manual payment entry
* Track:

  * Payable amount
  * Paid amount
  * Payment status
* Link payments to:

  * Event (if event-based)
  * Month (if salary-based)

### Rules

* No payroll automation
* Treated as expense

---

## 7. Simple Payment System (Clients & Employees)

### Purpose

Track all money movement manually.

### Client Payments

* Manual payment entry
* Invoice auto-generation
* PDF invoice download after save
* Track pending client dues

### Employee Payments

* Manual payment entry
* Track pending payouts

### Rules

* No online payment gateway
* PDF generation only

---

## 8. Employee Salary & Event Cost Tracking

### Purpose

Maintain accurate income vs expense tracking.

### Event Costs

* Add per-event cost entries:

  * Hotel
  * Transport
  * Food
  * Miscellaneous

### Salary Tracking

* Monthly salary disbursement
* Event-based staff cost mapping

### Output

* Monthly income vs expense
* Profit or loss calculation

---

## 9. Equipment Management

### Purpose

Track studio assets and rentals.

### Equipment Types

* Owned equipment
* Rented equipment

### Features

* Equipment CRUD
* Category & status
* Assign equipment to events
* Assign equipment to staff

### Cost Rules

* Rental equipment cost can be added to event expense
* Owned equipment has no automatic depreciation

---

## 10. Financial Reporting

### Reports

* Event-wise profit/loss
* Monthly income vs expense
* Yearly revenue summary
* Pending receivables & payables

### Output

* Table-based reports
* PDF / Excel export

---

## 11. Access Control Rules

* Admin: Full access
* Sales: Clients, events, invoices
* Photographer/Editor: Assigned events only
* Financial data: Admin-only

---

## 12. Non-Goals (Explicitly Excluded)

* Client portal
* Online payments
* Photo/file storage
* Cloud-only features
* Automated payroll

---

## 13. Success Criteria

* Admin can see operational health in under 30 seconds
* Accurate profit/loss visibility
* Simple workflows for non-technical users
* Works reliably on a single local PC

---

**End of REFACTORED_FEATURES.md**
