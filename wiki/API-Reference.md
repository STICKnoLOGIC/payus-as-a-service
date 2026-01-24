# API Reference

Complete reference for all PayUs-as-a-Service API endpoints.

## Base URL

```
https://puaas.sticknologic.is-a.dev
```

## Authentication

No authentication required. All endpoints are publicly accessible.

## Rate Limiting

- **Limit:** 60 requests per minute per IP
- **Response Header:** `X-RateLimit-Limit`, `X-RateLimit-Remaining`
- **Error Code:** 429 Too Many Requests

---

## Endpoints

### 1. Get Random Message

Get a random payment reminder message with a random tone.

**Endpoint:**
```
GET /payus
```

**Response:**
```json
{
  "message": "Time to settle up! Your payment is overdue.",
  "tone": "Frank"
}
```

**Status Codes:**
- `200` - Success
- `404` - No messages found
- `429` - Rate limit exceeded
- `500` - Server error

---

### 2. Get Professional Message

Get a random message with a professional tone.

**Endpoint:**
```
GET /payus/professional
```

**Example Request:**
```bash
curl https://puaas.sticknologic.is-a.dev/payus/professional
```

**Example Response:**
```json
{
  "message": "This is a formal reminder regarding your outstanding balance. Please arrange payment at your earliest convenience.",
  "tone": "Professional"
}
```

---

### 3. Get Friendly Message

Get a random message with a friendly tone.

**Endpoint:**
```
GET /payus/friendly
```

**Example Request:**
```bash
curl https://puaas.sticknologic.is-a.dev/payus/friendly
```

**Example Response:**
```json
{
  "message": "Hey there! Just a gentle reminder about your payment. No rush, but would love to get this sorted soon!",
  "tone": "Friendly"
}
```

---

### 4. Get Frank Message

Get a random message with a frank (direct) tone.

**Endpoint:**
```
GET /payus/frank
```

**Example Request:**
```bash
curl https://puaas.sticknologic.is-a.dev/payus/frank
```

**Example Response:**
```json
{
  "message": "Your invoice is past due. Please make payment immediately.",
  "tone": "Frank"
}
```

---

### 5. Get Funny Message

Get a random message with a humorous tone.

**Endpoint:**
```
GET /payus/funny
```

**Example Request:**
```bash
curl https://puaas.sticknologic.is-a.dev/payus/funny
```

**Example Response:**
```json
{
  "message": "My accountant is giving me the stink eye about your unpaid invoice. Help me avoid her wrath?",
  "tone": "Funny"
}
```

---

### 6. Get Playful Message

Get a random message with a playful tone.

**Endpoint:**
```
GET /payus/playful
```

**Example Request:**
```bash
curl https://puaas.sticknologic.is-a.dev/payus/playful
```

**Example Response:**
```json
{
  "message": "Knock knock! Who's there? Your payment reminder 😊",
  "tone": "Playful"
}
```

---

### 7. Get Available Tones

Get a list of all available tones.

**Endpoint:**
```
GET /payus/tones
```

**Example Request:**
```bash
curl https://puaas.sticknologic.is-a.dev/payus/tones
```

**Example Response:**
```json
{
  "success": true,
  "message": "Success",
  "data": {
    "tones": {
      "professional": "Professional",
      "friendly": "Friendly",
      "frank": "Frank",
      "funny": "Funny",
      "playful": "Playful"
    }
  }
}
```

---

## Error Responses

### 404 Not Found

Returned when no messages are found for the criteria.

```json
{
  "success": false,
  "message": "No messages found for the specified criteria.",
  "errors": "Resource not found"
}
```

### 429 Too Many Requests

Returned when rate limit is exceeded.

```json
{
  "message": "Too many requests"
}
```

### 500 Server Error

Returned when an internal server error occurs.

```json
{
  "success": false,
  "message": "An error occurred processing your request",
  "errors": "Internal server error"
}
```

---

## HTTP Status Codes

| Code | Description |
|------|-------------|
| 200 | Success |
| 404 | Not found |
| 422 | Validation error |
| 429 | Too many requests |
| 500 | Server error |

---

## Interactive Documentation

For a more interactive experience with the ability to test endpoints directly in your browser, visit:

**https://puaas.sticknologic.is-a.dev/docs**

---

## OpenAPI Specification

Download the full OpenAPI (Swagger) specification:

**https://puaas.sticknologic.is-a.dev/api.json**

This can be imported into tools like:
- Postman
- Insomnia
- Swagger UI
- Redoc
