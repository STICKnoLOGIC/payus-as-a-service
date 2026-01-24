# Getting Started

This guide will help you start using PayUs-as-a-Service in under 5 minutes.

## Using the Live API

The fastest way to get started is using our hosted API at https://puaas.sticknologic.is-a.dev

### Your First Request

```bash
curl https://puaas.sticknologic.is-a.dev/payus
```

**Response:**
```json
{
  "message": "Hey! Just following up on that invoice. When can I expect payment?",
  "tone": "Friendly"
}
```

That's it! You've made your first API call.

## Understanding Tones

PayUs-as-a-Service offers 5 different communication tones:

| Tone | Description | Best For |
|------|-------------|----------|
| **Professional** | Formal, business-like language | Corporate clients, B2B invoices |
| **Friendly** | Warm and approachable | Regular customers, long-term clients |
| **Frank** | Direct and straightforward | Clear communication, no-nonsense clients |
| **Funny** | Humorous and lighthearted | Informal relationships, creative industries |
| **Playful** | Witty and engaging | Casual clients, modern businesses |

## Available Endpoints

### Get Random Message (Any Tone)

```bash
GET /payus
```

Returns a random message with a random tone.

### Get Specific Tone

```bash
GET /payus/professional
GET /payus/friendly
GET /payus/frank
GET /payus/funny
GET /payus/playful
```

Returns a random message in the specified tone.

### Get Available Tones

```bash
GET /payus/tones
```

Returns all available tones with their labels.

## Rate Limits

- **60 requests per minute** per IP address
- Exceeding the limit returns HTTP 429 (Too Many Requests)
- No authentication required
- Completely free to use

## Next Steps

- 📖 [Read the full API Reference](API-Reference)
- 💡 [See Integration Examples](Examples)
- 🏠 [Self-host your own instance](Self-Hosting-Guide)
- 📚 [Browse the Interactive Docs](https://puaas.sticknologic.is-a.dev/docs)

## Need Help?

- Check the [Troubleshooting Guide](Troubleshooting)
- Ask in [GitHub Discussions](https://github.com/sticknologic/payus-as-a-service/discussions)
- Report bugs in [GitHub Issues](https://github.com/sticknologic/payus-as-a-service/issues)
