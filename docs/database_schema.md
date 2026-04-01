# Database Schema

This document details the database structure for the Smart Auto Car Services platform.

## Tables Overview

The system consists of the following primary tables:

1.  `users`: Core authentication and role-based data.
2.  `services`: Definitions of available maintenance tasks.
3.  `car_types`: Categories of vehicles (e.g., Sedan, SUV).
4.  `car_models`: Specific car models with price modifiers.
5.  `bookings`: Transactional records of service appointments.
6.  `contact_requests`: Entries for custom service inquiries.
7.  `chat_messages`: Communication log for custom services.

---

## Detailed Table Structures

### `users`
| Column | Type | Nullable | Description |
| :--- | :--- | :--- | :--- |
| `id` | BigInt (PK) | No | Primary Identifier |
| `name` | String | No | Full Name |
| `email` | String | No | Unique Login Email |
| `role` | Enum | No | `admin`, `user`, `worker` |
| `phone_number`| String | Yes | Contact info |
| `cnic` | String | Yes | ID Verification (for workers) |
| `experience_years` | Integer | Yes | Worker experience |
| `google_id` | String | Yes | Social Login ID |

### `services`
| Column | Type | Nullable | Description |
| :--- | :--- | :--- | :--- |
| `id` | BigInt (PK) | No | |
| `name` | String | No | Service Name (e.g., Oil Change) |
| `type` | String | No | `standard` or `custom` |
| `base_price` | Decimal | No | Minimum cost for the service |
| `duration_minutes`| Integer | No | Estimated time required |
| `user_id` | BigInt (FK) | Yes | Owner of custom service |

### `car_models`
| Column | Type | Nullable | Description |
| :--- | :--- | :--- | :--- |
| `id` | BigInt (PK) | No | |
| `car_type_id` | BigInt (FK) | No | Belongs to `car_types` |
| `name` | String | No | Model name (e.g., Civic, Corolla) |
| `price_modifier`| Decimal | No | Multiplier (e.g., 1.2 for luxury) |

### `bookings`
| Column | Type | Nullable | Description |
| :--- | :--- | :--- | :--- |
| `id` | BigInt (PK) | No | |
| `user_id` | BigInt (FK) | No | The customer |
| `service_id` | BigInt (FK) | No | The booked service |
| `worker_id` | BigInt (FK) | Yes | Assigned technician |
| `appointment_time`| DateTime | No | Scheduled slot |
| `status` | String | No | `pending`, `in_progress`, `completed`, `cancelled` |
| `payment_status`| String | No | `pending`, `paid`, `refunded` |
| `final_price` | Decimal | No | Calculated `base_price * modifier` |
| `stripe_payment_id`| String | Yes | External payment reference |

---

## Relationships

- **User -> Bookings**: One-to-Many (`user_id`).
- **Worker (User) -> Bookings**: One-to-Many (`worker_id`).
- **CarType -> CarModels**: One-to-Many.
- **Service -> Bookings**: One-to-Many.
- **ContactRequest -> ChatMessages**: One-to-Many.
