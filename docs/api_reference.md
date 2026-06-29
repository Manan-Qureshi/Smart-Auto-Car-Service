# API Reference

These internal JSON endpoints are used by the frontend to provide a dynamic, single-page-like experience.

## 1. Car Models
Fetch models based on selected car type.
- **Endpoint**: `GET /api/car-models`
- **Params**: `type_id`
- **Returns**: JSON list of models with their price modifiers.

## 2. Price Calculation
Retrieve the final calculated price for a combination of services and a vehicle.
- **Endpoint**: `POST /api/calculate-price`
- **Payload**:
  ```json
  {
    "service_ids": [1, 2],
    "car_model_id": 5
  }
  ```
- **Returns**: `{"total": 125.50}`

## 3. Available Slots
Calculate available appointment windows for a given date and service duration.
- **Endpoint**: `GET /api/slots`
- **Params**: `date`, `duration`
- **Logic**: Filters out times that overlap with existing bookings or fall outside operational hours.

## 4. Chat Messages
Fetch messages for a specific custom service request.
- **Endpoint**: `GET /api/chat/{id}/messages`
- **Returns**: JSON array of message objects (User, Message, Timestamp, Image).

## 5. Send Message
- **Endpoint**: `POST /api/chat/{id}/messages`
- **Payload**: `{"message": "Hello"}`

## 6. Create Proposal (Admin)
- **Endpoint**: `POST /api/chat/{id}/proposal`
- **Payload**:
  ```json
  {
    "title": "Brake Repair",
    "price": 200,
    "date": "2024-05-10",
    "time": "14:00",
    "worker_id": 3
  }
  ```
