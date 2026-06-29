# System Architecture

This project is built using a modern, scalable architecture leveraging the **Laravel** ecosystem.

## Technology Stack

- **Framework**: [Laravel 10.x](https://laravel.com/)
- **Frontend**: Blade Templating Engine with Vanilla CSS and JavaScript.
- **Database**: MySQL (Relational)
- **Payment Gateway**: Stripe (API & Webhooks)
- **Authentication**: Laravel Breeze / UI (Extended with Role Management & Google OAuth)
- **Tooling**: Vite for asset bundling.

## Core Architectural Components

### 1. Role-Based Access Control (RBAC)
The system distinguishes between three primary actors using a `role` column in the `users` table:
- **Admin**: Full system management, service creation, and worker assignment.
- **User**: Standard customers who book and track services.
- **Worker**: Technicians who execute assigned tasks and update statuses.

### 2. Service Logic
- **Standard Services**: Predefined by Admin, available to all users.
- **Custom Services**: Initiated via a contact request. A "Service" record is created dynamically for the specific user once the Admin generates a proposal.

### 3. Dynamic Pricing Engine
The price calculation is handled on the server side to prevent tampering.
- `Final Price = Service Base Price * Car Model Price Modifier`
- Modifiers allow for higher pricing on luxury or heavy-duty vehicles automatically.

### 4. Scheduling & Capacity
- Services have a `duration_minutes` attribute.
- Booking slots are calculated dynamically based on worker availability and the duration of the selected services.
- Sequential job enforcement: Workers can only start one job at a time and must follow a FIFO (First-In-First-Out) order based on appointment times.

## Design Patterns

- **MVC (Model-View-Controller)**: Strict separation of data, logic, and presentation.
- **Repository-like Controller logic**: Complex queries are handled within the Eloquent models or specific controller actions.
- **Service Layer (Conceptual)**: Heavy logic (like Stripe integration and Refund processing) is isolated in controllers or specific helper classes.

## External Integrations

- **Stripe**: Handles secure credit card processing and automated refund initiation upon authorized cancellation.
- **Google OAuth**: Provides a seamless "One-Tap" login experience for users.
