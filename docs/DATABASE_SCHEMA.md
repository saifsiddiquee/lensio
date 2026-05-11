# DATABASE_SCHEMA.md

## Lensio– Database Schema

This document defines the **authoritative database structure** for the Event Photography CRM.

Target:

* **MySQL / MariaDB**
* **Local PC / On-Premise**
* **Laravel Eloquent–friendly**

This schema is intentionally **simple, normalized, and AI-safe**.

---

## Design Principles

* One responsibility per table
* Use foreign keys where practical
* Avoid polymorphic complexity
* Soft deletes where business data matters
* Audit via timestamps and optional logs

---

## 1. users

Stores internal system users.

| Column     | Type         | Notes                              |
| ---------- | ------------ | ---------------------------------- |
| id         | BIGINT PK    | Auto increment                     |
| name       | VARCHAR(100) |                                    |
| email      | VARCHAR(150) | Unique                             |
| password   | VARCHAR(255) | Hashed                             |
| role       | ENUM         | admin, sales, photographer, editor |
| is_active  | BOOLEAN      | Default true                       |
| created_at | TIMESTAMP    |                                    |
| updated_at | TIMESTAMP    |                                    |

---

## 2. leads

Tracks incoming leads before booking.

| Column      | Type         | Notes                                |
| ----------- | ------------ | ------------------------------------ |
| id          | BIGINT PK    |                                      |
| name        | VARCHAR(100) |                                      |
| phone       | VARCHAR(50)  |                                      |
| email       | VARCHAR(150) | Nullable                             |
| event_type  | VARCHAR(100) | Wedding, Corporate, etc              |
| event_date  | DATE         | Nullable                             |
| source      | VARCHAR(100) | Facebook, Referral, etc              |
| status      | ENUM         | new, contacted, quoted, booked, lost |
| assigned_to | BIGINT FK    | users.id                             |
| notes       | TEXT         | Nullable                             |
| created_at  | TIMESTAMP    |                                      |
| updated_at  | TIMESTAMP    |                                      |

---

## 3. clients

Created after a lead is converted.

| Column     | Type         | Notes    |
| ---------- | ------------ | -------- |
| id         | BIGINT PK    |          |
| lead_id    | BIGINT FK    | leads.id |
| name       | VARCHAR(100) |          |
| phone      | VARCHAR(50)  |          |
| email      | VARCHAR(150) | Nullable |
| address    | TEXT         | Nullable |
| created_at | TIMESTAMP    |          |
| updated_at | TIMESTAMP    |          |

---

## 4. events

Represents photography events.

| Column     | Type         | Notes                         |
| ---------- | ------------ | ----------------------------- |
| id         | BIGINT PK    |                               |
| client_id  | BIGINT FK    | clients.id                    |
| event_type | VARCHAR(100) |                               |
| event_date | DATE         |                               |
| venue      | VARCHAR(255) |                               |
| status     | ENUM         | planned, completed, cancelled |
| created_at | TIMESTAMP    |                               |
| updated_at | TIMESTAMP    |                               |

---

## 5. event_user (pivot)

Assigns photographers/editors to events.

| Column   | Type      | Notes                |
| -------- | --------- | -------------------- |
| id       | BIGINT PK |                      |
| event_id | BIGINT FK | events.id            |
| user_id  | BIGINT FK | users.id             |
| role     | ENUM      | photographer, editor |

---

## 6. packages

Photography packages.

| Column         | Type          | Notes             |
| -------------- | ------------- | ----------------- |
| id             | BIGINT PK     |                   |
| name           | VARCHAR(100)  |                   |
| price          | DECIMAL(10,2) | Offline reference |
| duration_hours | INT           |                   |
| description    | TEXT          | Nullable          |
| created_at     | TIMESTAMP     |                   |
| updated_at     | TIMESTAMP     |                   |

---

## 7. quotations

Price offers sent to clients.

| Column       | Type          | Notes                           |
| ------------ | ------------- | ------------------------------- |
| id           | BIGINT PK     |                                 |
| client_id    | BIGINT FK     | clients.id                      |
| package_id   | BIGINT FK     | packages.id                     |
| total_amount | DECIMAL(10,2) |                                 |
| status       | ENUM          | draft, sent, approved, rejected |
| valid_until  | DATE          | Nullable                        |
| created_at   | TIMESTAMP     |                                 |
| updated_at   | TIMESTAMP     |                                 |

---

## 8. contracts

Tracks contract status only.

| Column       | Type         | Notes                    |
| ------------ | ------------ | ------------------------ |
| id           | BIGINT PK    |                          |
| event_id     | BIGINT FK    | events.id                |
| reference_no | VARCHAR(100) | Manual ref               |
| status       | ENUM         | draft, signed, completed |
| created_at   | TIMESTAMP    |                          |
| updated_at   | TIMESTAMP    |                          |

---

## 9. tasks

Operational tasks per event.

| Column      | Type         | Notes                            |
| ----------- | ------------ | -------------------------------- |
| id          | BIGINT PK    |                                  |
| event_id    | BIGINT FK    | events.id                        |
| title       | VARCHAR(150) |                                  |
| task_type   | ENUM         | pre_event, event_day, post_event |
| assigned_to | BIGINT FK    | users.id                         |
| due_date    | DATE         | Nullable                         |
| status      | ENUM         | pending, in_progress, done       |
| created_at  | TIMESTAMP    |                                  |
| updated_at  | TIMESTAMP    |                                  |

---

## 10. invoices

Offline invoice tracking.

| Column       | Type          | Notes                 |
| ------------ | ------------- | --------------------- |
| id           | BIGINT PK     |                       |
| event_id     | BIGINT FK     | events.id             |
| invoice_no   | VARCHAR(100)  | Unique                |
| total_amount | DECIMAL(10,2) |                       |
| status       | ENUM          | unpaid, partial, paid |
| created_at   | TIMESTAMP     |                       |
| updated_at   | TIMESTAMP     |                       |

---

## 11. payments

Manual payment entries.

| Column       | Type          | Notes       |
| ------------ | ------------- | ----------- |
| id           | BIGINT PK     |             |
| invoice_id   | BIGINT FK     | invoices.id |
| amount       | DECIMAL(10,2) |             |
| payment_date | DATE          |             |
| method       | VARCHAR(50)   | Cash, Bank  |
| notes        | TEXT          | Nullable    |
| created_at   | TIMESTAMP     |             |

---

## 12. audit_logs (Optional but Recommended)

Basic activity logging.

| Column     | Type         | Notes      |
| ---------- | ------------ | ---------- |
| id         | BIGINT PK    |            |
| user_id    | BIGINT FK    | users.id   |
| action     | VARCHAR(255) |            |
| entity     | VARCHAR(100) | Table name |
| entity_id  | BIGINT       |            |
| created_at | TIMESTAMP    |            |

---

## Relationships Summary

* User → Leads (assigned)
* Lead → Client (one-time conversion)
* Client → Events (one-to-many)
* Event → Users (many-to-many)
* Event → Tasks (one-to-many)
* Event → Invoice (one-to-one)
* Invoice → Payments (one-to-many)

---

## Migration Order (Recommended)

1. users
2. leads
3. clients
4. events
5. event_user
6. packages
7. quotations
8. contracts
9. tasks
10. invoices
11. payments
12. audit_logs

---

**End of DATABASE_SCHEMA.md**
