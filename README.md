# Smart Auto Car Services

## Project Overview
Smart Auto Car Services is a comprehensive role-based web application that facilitates standard and custom service bookings, features dynamic pricing, manages time slots with capacity control, automates worker assignments, and implements a payment-first confirmation system.

## 📖 Documentation
For a deeper dive into the system, please refer to the following guides:
- [🚀 Setup & Installation](docs/setup_guide.md)
- [🏗️ System Architecture](docs/architecture.md)
- [📊 UML Diagrams]:
  - [🔗 Entity Relationship Diagram (ERD)](docs/erd.md)
  - [🔗 Class Diagram](docs/class_diagram.md)
  - [🔗 Sequence Diagrams](docs/sequence_diagrams.md)
  - [🔗 State Diagram](docs/state_diagram.md)
  - [🔗 Use Case Diagram](docs/use_case_diagram.md)
- [🗄️ Database Schema](docs/database_schema.md)
- [✨ Feature Highlights](docs/features.md)
- [🔗 API Reference](docs/api_reference.md)

## User Workflow

### Registration & Login
When a user visits the website, they first register by providing their details, such as name, email, and phone number. Once registered, or if they are returning, they log in using their credentials, including options like Google login.

### Service Selection
After logging in, the user lands on their dashboard, where they can browse available services. The user can choose from predefined standard services, such as oil changes, tire replacements, and car washes. 

### Custom Services
If the user’s issue is not covered by standard services, they can opt for a custom service. In the custom service process, the user fills out a form detailing the car’s issue, submits it, and the system sends a notification to the admin. Once the admin processes the request and creates the custom service card, the user can then proceed to payment.

### Booking & Payment
The system assigns a worker automatically based on availability and workload, and the user can track the service status until completion. 

### Cancellation Policy
If the user decides to cancel a booking, the system first checks the current service status. 
- **Pending (Not yet started):** The system allows cancellation, automatically cancels the booking, and initiates a refund to the user’s original payment method. The user receives a notification confirming the cancellation and refund processing.
- **In Progress or Completed:** The system does not allow cancellation or refund, and the user is notified that the service can no longer be canceled.

## Admin Workflow

### Dashboard & Management
The admin accesses the admin dashboard to oversee the platform. They can manage user accounts by approving, editing, or deactivating them. Admins also manage workers by adding new workers, verifying credentials, and assigning roles.

### Booking Supervision
When a user submits a booking, the admin can monitor and manage these requests, ensuring that services are assigned to the appropriate workers. The admin can also create and manage custom services, handle disputes, and view booking and payment histories.

### Custom Service Processing
In the custom service process, the admin communicates with the user, verifies the issue, and then generates a custom service card for the user to proceed with payment and booking.

## 🏗️ Technical Deep Dives

### 🕒 Time Slot Management
The platform uses a dynamic scheduling system to ensure that bookings never exceed worker capacity.

#### How Time Slots are Created:
1.  **Operating Hours**: The system defines a standard window (e.g., 08:00 AM to 08:00 PM).
2.  **Dynamic Duration**: The length of a slot is determined by the specific services in the user's cart. If multiple services are selected, their durations are summed.
3.  **Worker Capacity**: Availability is not just "time-based" but "capacity-based." If there are 5 workers, the system allows up to 5 concurrent bookings in any given time window.
4.  **Buffer Zone**: A mandatory 20-minute buffer is maintained for today's bookings to allow for preparation and travel.

#### How Slots are Fetched:
- When a user selects a date, an AJAX request is sent to `/api/slots`.
- The `SlotController` fetches all existing bookings for that date.
- It calculates "Busy Intervals" for each worker.
- It iterates through the day and returns only those times where at least one worker is free for the entire duration of the requested service.

---

### 🗃️ Data Management (Fetching & Storing)

#### 1. Data Fetching
- **Server-Side Rendering (Blade)**: Primary pages (Dashboard, Booking History) are rendered using Laravel Blade for SEO and initial load speed.
- **Client-Side API (JSON)**: Dynamic UI elements (Price estimation, Car model selection, Time slots) use the Fetch API to communicate with JSON endpoints. This provides a smooth, modern experience without full page reloads.
- **Eloquent ORM**: The project uses Laravel's Eloquent to interact with the database, utilizing relationships (`hasMany`, `belongsTo`) to efficiently fetch related data like a booking's assigned worker or its associated car model.

#### 2. Data Storing
- **Relational Integrity**: Data is stored in strict MySQL tables with foreign key constraints.
- **Checkout Process**: During booking, temporary data is stored in the **PHP Session** (e.g., cart items, selected car).
- **Finalization**: Data is only persisted to the `bookings` table after a successful Stripe payment confirmation.
- **Image Storage**: File uploads for custom service proof or chat attachments are stored in the `public/storage` directory, with references saved in the database.

---

## Worker Workflow

### Task Management
Workers log into their accounts and check assigned tasks. When a booking is made, the system automatically assigns the service based on workload and availability.

### Service Execution
Workers can view the service details, update the status of the job (from assigned to in progress to completed), and communicate with the user if needed.

### Completion
Once the service is completed, workers mark it as done and upload any necessary proof. They can view their earnings, manage tasks, and request support from the admin when necessary.
