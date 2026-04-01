# Feature Highlights

This document provides a deep dive into the unique features of the Smart Auto Car Services platform.

## 1. Dynamic Pricing Engine
Unlike static pricing models, this platform calculates costs based on the vehicle's specific requirements.
- **Base Price**: Assigned to each service (e.g., Oil Change = $50).
- **Modifier**: Assigned to car models based on complexity/size (e.g., SUV = 1.3x).
- **Calculation**: `Total = Base * Modifier`. 
- **User Experience**: The price updates instantly on the frontend using Fetch API as the user selects different car models.

## 2. Custom Service Lifecycle
For issues not covered by standard catalog items:
1. **Request**: User submits a "Contact Request" with images and descriptions.
2. **Chat**: A private real-time chat room is opened between the User and Admin.
3. **Proposal**: The Admin generates a formal proposal within the chat, specifying a custom price and a specific worker.
4. **Checkout**: The proposal transforms into a "Pending Booking" which the user can pay for to finalize.

## 3. Worker "Sequential Job" Enforcement
To ensure quality and timely delivery, workers are managed with strict rules:
- **Single Active Task**: A worker cannot be "In Progress" on two jobs simultaneously.
- **FIFO Processing**: The system forces workers to complete or cancel earlier assigned jobs before starting newer ones based on the appointment schedule.

## 4. Intelligent Time Slot Management
- **Buffer Zone**: A 20-minute mandatory buffer is added between appointments.
- **Duration Awareness**: If a User selects multiple services (e.g., Wash + Oil Change), the system sums the durations and only shows time slots that can accommodate the "Total Duration" without overlapping other bookings.

## 5. Automated Refund Policy
- **Authorized Cancellations**: If a user cancels a "Pending" booking, the system calls the Stripe Refund API automatically.
- **Safety Lock**: Once a service is marked "In Progress" by a worker, the "Cancel" button is disabled on the User Dashboard to prevent lost revenue.
