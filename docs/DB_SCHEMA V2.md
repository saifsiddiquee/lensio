# DATABASE_SCHEMA_V2.md

## Extended Database Schema – Finance, Staff & Equipment

This document extends `DATABASE_SCHEMA.md` to support:

* Equipment inventory (owned & rented)
* Employee & contractual staff management
* Event-wise and monthly salary payments
* Additional event costs
* Accurate profit/loss reporting

All tables are **Laravel + MySQL friendly** and designed for **local PC usage**.

---

## 1. employees

Represents full-time, part-time, and contractual staff.

| Column          | Type          | Notes                             |
| --------------- | ------------- | --------------------------------- |
| id              | BIGINT PK     |                                   |
| user_id         | BIGINT FK     | users.id (nullable)               |
| name            | VARCHAR(100)  |                                   |
| role            | ENUM          | photographer, editor, support     |
| employment_type | ENUM          | full_time, part_time, contractual |
| monthly_salary  | DECIMAL(10,2) | Nullable                          |
| is_active       | BOOLEAN       | Default true                      |
| created_at      | TIMESTAMP     |                                   |
| updated_at      | TIMESTAMP     |                                   |

---

## 2. employee_event_payments

Tracks event-wise payments to staff.

| Column        | Type          | Notes                  |
| ------------- | ------------- | ---------------------- |
| id            | BIGINT PK     |                        |
| event_id      | BIGINT FK     | events.id              |
| employee_id   | BIGINT FK     | employees.id           |
| agreed_amount | DECIMAL(10,2) |                        |
| paid_amount   | DECIMAL(10,2) |                        |
| status        | ENUM          | pending, partial, paid |
| created_at    | TIMESTAMP     |                        |
| updated_at    | TIMESTAMP     |                        |

---

## 3. employee_monthly_salaries

Tracks monthly salary disbursement.

| Column         | Type          | Notes              |
| -------------- | ------------- | ------------------ |
| id             | BIGINT PK     |                    |
| employee_id    | BIGINT FK     | employees.id       |
| salary_month   | DATE          | First day of month |
| payable_amount | DECIMAL(10,2) |                    |
| paid_amount    | DECIMAL(10,2) |                    |
| status         | ENUM          | pending, paid      |
| created_at     | TIMESTAMP     |                    |

---

## 4. equipments

Equipment inventory.

| Column         | Type          | Notes                            |
| -------------- | ------------- | -------------------------------- |
| id             | BIGINT PK     |                                  |
| name           | VARCHAR(100)  |                                  |
| category       | VARCHAR(100)  | Camera, Lens, etc                |
| ownership_type | ENUM          | owned, rented                    |
| cost           | DECIMAL(10,2) | Purchase or rental cost          |
| status         | ENUM          | available, assigned, maintenance |
| created_at     | TIMESTAMP     |                                  |
| updated_at     | TIMESTAMP     |                                  |

---

## 5. event_equipments

Assigns equipment to events and staff.

| Column       | Type          | Notes         |
| ------------ | ------------- | ------------- |
| id           | BIGINT PK     |               |
| event_id     | BIGINT FK     | events.id     |
| equipment_id | BIGINT FK     | equipments.id |
| assigned_to  | BIGINT FK     | employees.id  |
| rental_cost  | DECIMAL(10,2) | Nullable      |
| created_at   | TIMESTAMP     |               |

---

## 6. event_costs

Additional costs per event.

| Column     | Type          | Notes                  |
| ---------- | ------------- | ---------------------- |
| id         | BIGINT PK     |                        |
| event_id   | BIGINT FK     | events.id              |
| cost_type  | VARCHAR(100)  | Hotel, Transport, Food |
| amount     | DECIMAL(10,2) |                        |
| notes      | TEXT          | Nullable               |
| created_at | TIMESTAMP     |                        |

---

## 7. financial_views (Logical)

Not a table – used for reporting queries.

### Event Profit Formula

```
Event Income = invoices.total_amount
Event Cost =
  SUM(employee_event_payments.paid_amount)
+ SUM(event_costs.amount)
+ SUM(event_equipments.rental_cost)

Net Profit = Income - Cost
```

---

## Migration Order (Extended)

1. employees
2. employee_event_payments
3. employee_monthly_salaries
4. equipments
5. event_equipments
6. event_costs

---

**End of DATABASE_SCHEMA_V2.md**
