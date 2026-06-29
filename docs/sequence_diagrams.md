# Sequence Diagrams

These diagrams illustrate the chronological flow of interactions between users, the system controllers, and external APIs (like Stripe).

## 1. Standard Booking & Payment Flow

```mermaid
sequenceDiagram
    autonumber
    participant U as User
    participant S as ServiceController
    participant B as BookingController
    participant P as PaymentController
    participant St as Stripe API

    U->>S: Browse Services
    U->>S: Add to Cart & Select Car
    U->>B: Proceed to Checkout (Final Price Calculation)
    B->>P: Init Stripe Checkout
    P->>St: Create Checkout Session
    St-->>P: Session ID & URL
    P-->>U: Redirect to Hosted Payment Page
    U->>St: Provide Payment Details
    St-->>P: Success Webhook / Redirect
    P->>B: Confirm Order & Create Booking Record
    B-->>U: Show Confirmation & E-ticket
```

## 2. Custom Service Request & Proposal Flow

```mermaid
sequenceDiagram
    autonumber
    participant U as User
    participant A as Admin
    participant C as ChatController
    participant B as BookingController

    U->>C: Submit Custom Request (Issue details/images)
    C->>A: Notification of New Inqury
    A->>C: Open Chat Room
    A->>C: Discuss issue with User
    U->>C: Provide clarification
    A->>C: Create Formal Proposal (Price, Date, Technician)
    C->>B: Generate Private Service & Pending Booking
    C-->>U: Display Proposal Card in Chat
    U->>B: Accept Proposal & Proceed to Payment
    B-->>U: Booking Confirmed & Worker Assigned
```
