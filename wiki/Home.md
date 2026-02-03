# PayUs-as-a-Service Wiki

Welcome to the PayUs-as-a-Service documentation! 

> **📚 [View Main Repository](https://github.com/sticknologic/paynow-as-a-service)** | **📖 [README](https://github.com/sticknologic/paynow-as-a-service#readme)**

## What is PayUs-as-a-Service?

PayUs-as-a-Service (PUaaS) is a free, open-source API that generates randomized payment reminder messages in various tones. Perfect for developers who need to send past-due invoice reminders but want to maintain different communication styles.

## Quick Links

- 🚀 [Getting Started](Getting-Started)
- 📖 [API Reference](API-Reference)
- 🏠 [Self-Hosting Guide](Self-Hosting-Guide)
- 💡 [Examples & Integration](Examples)
- 🛠️ [Troubleshooting](Troubleshooting)
- 🤝 [Contributing](Contributing)

## Live API

**Base URL:** https://puaas.sticknologic.is-a.dev

**Interactive Docs:** https://puaas.sticknologic.is-a.dev/docs

## Features

✅ **5 Different Tones:** Professional, Friendly, Frank, Funny, Playful  
✅ **1,500+ Messages:** 300 unique messages per tone  
✅ **No Authentication Required:** Free and open for everyone  
✅ **Rate Limited:** 60 requests per minute per IP  
✅ **RESTful API:** Simple GET endpoints  
✅ **OpenAPI Spec:** Full documentation available  
✅ **Self-Hostable:** Run your own instance with Docker  

## Quick Example

```bash
# Get a random message with any tone
curl https://puaas.sticknologic.is-a.dev/payus

# Response
{
  "message": "Just a friendly reminder about your outstanding balance!",
  "tone": "Friendly"
}
```

## Support

- **Issues:** [GitHub Issues](https://github.com/sticknologic/payus-as-a-service/issues)
- **Discussions:** [GitHub Discussions](https://github.com/sticknologic/payus-as-a-service/discussions)
- **Questions:** [Q&A Section](https://github.com/sticknologic/payus-as-a-service/discussions/new?category=q-a)

## License

This project is open-sourced under the [MIT License](https://github.com/sticknologic/payus-as-a-service/blob/main/LICENSE).
