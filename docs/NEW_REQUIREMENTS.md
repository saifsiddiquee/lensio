# ADDITIONAL_REQUIREMENTS.md

## Extended Requirements – Equipment, Costs & Financials

This document defines **new functional requirements** to be added to the existing **Lensio CRM**.

These requirements extend **operations, costing, and profitability tracking** while still respecting the original constraints:

* Local PC / On-Premise
* Laravel + Blade + MySQL
* No client portal
* No file/photo storage
* No online payments

---

## 1. Equipment Inventory Management

### 1.1 Purpose

Track all photography equipment (owned or rented) and assign them to events to understand availability and cost impact.

### 1.2 Equipment Types

* **Owned Equipment** – Studio-owned assets
* **Rented Equipment** – Temporarily rented per event

### 1.3 Core Requirements

* Equipment CRUD
* Equipment categories (Camera, Lens, Lighting, Drone, etc.)
* Ownership type:

  * Owned
  * Rented
* Equipment status:

  * Available
  * Assigned
  * Maintenance
* Purchase or rental cost reference

### 1.4 Event Assignment

* Assign one or more equipment items to an event
* Track assignment date range
* Prevent double-booking of same equipment for overlapping events

### 1.5 Scope Rules

* No depreciation calculation (future enhancement)
* No barcode or QR scanning

---

## 2. Event-wise Employee Payment Management

### 2.1 Purpose

Track payments made to photographers, editors, and staff **per event**.

### 2.2 Payment Model

* Payment is recorded **manually** (offline)
* Linked to:

  * Event
  * Employee (User)

### 2.3 Core Requirements

* Define payment type:

  * Fixed per event
  * Per day
  * Per task (optional)
* Record:

  * Agreed amount
  * Paid amount
  * Payment status (Pending / Partial / Paid)

### 2.4 Rules

* Employee payments are treated as **event costs**
* No payroll automation
* No salary calculation outside events

---

## 3. Additional Event Costs

### 3.1 Purpose

Track non-employee operational costs per event.

### 3.2 Cost Types (Configurable)

* Hotel / Accommodation
* Transportation
* Food / Allowance
* Equipment rental
* Venue-related expenses
* Miscellaneous

### 3.3 Core Requirements

* Add multiple cost entries per event
* Each cost entry must have:

  * Cost type
  * Amount
  * Notes

### 3.4 Rules

* Costs are **event-specific**
* Costs contribute to total event expense

---

## 4. Event Profit & Income Calculation

### 4.1 Purpose

Show true profitability per event.

### 4.2 Income Calculation

```
Event Income = Total Invoice Amount
```

### 4.3 Cost Calculation

```
Total Event Cost =
  Employee Payments
+ Equipment Rental Costs
+ Additional Event Costs
```

### 4.4 Profit / Loss

```
Net Profit = Event Income - Total Event Cost
```

### 4.5 Display Requirements

* Event detail page must show:

  * Total income
  * Total cost
  * Net profit or loss

---

## 5. Financial Reports (Revenue & Loss)

### 5.1 Monthly Report

* Total income
* Total costs
* Net profit
* Number of events

### 5.2 Yearly Report

* Year-wise income vs cost
* Profit or loss summary

### 5.3 Filtering

* Date range
* Event type
* Client (optional)

### 5.4 Output Format

* Table-based reports
* Export to Excel / PDF

---

## 6. UI / UX Considerations

* Cost and profit visibility only for Admin role
* Clear separation between:

  * Revenue
  * Costs
  * Profit
* Simple tab-based layout in event detail page

---

## 7. Non-Functional Constraints

* Calculations must be query-based (no background jobs)
* All monetary values stored as DECIMAL
* Reports must work efficiently on local PC

---

## 8. Future Enhancements (Not in Scope)

* Equipment depreciation
* Salary-based payroll
* Automated profit forecasting
* Cloud accounting integration

---

## 9. Success Criteria

* Admin can clearly see event-wise profit or loss
* Equipment usage is traceable per event
* Monthly and yearly financial reports are accurate
* No additional system complexity added

---

**End of ADDITIONAL_REQUIREMENTS.md**
