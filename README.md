<p align="center">
  <img src="https://cdn.sticknologic.is-a.dev/payus-aas/banner.png" width="800" alt="Banner" width="70%"/>
</p>

# 💸 PayUs-as-a-Service
[![Node.js](https://img.shields.io/badge/Node.js-6DA55F?logo=node.js&logoColor=white)](#)
[![Express.js](https://img.shields.io/badge/Express.js-%23404d59.svg?logo=express&logoColor=%2361DAFB)](#)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

> **📖 [Full Documentation](../../wiki)** | **🚀 [Getting Started](../../wiki/Getting-Started)** | **📚 [API Reference](../../wiki/API-Reference)**

Does it ever happen in your career or personal life that you need to collect money someone owes you? Are you shy, out of words, or don't know how to ask or what tone to use?

Should it be Professional, Friendly, Frank, Funny, or Playful?

This project will perfectly solve (I hope) the questions above.

## About

PayUs-as-a-Service (PUaaS) is an API that returns randomized messages for past-due invoices — perfectly suited for any scenario: personal, professional, dev life, or just your everyday life.

Built for thick-faced, ghost, and shameless clients.

<!-- sponsor here -->
<!-- GitAds-Verify: AKZ9GHHCV9DNI2JZ17D3P7598WKKVQAL -->
## GitAds Sponsored
[![Sponsored by GitAds](https://gitads.dev/v1/ad-serve?source=sticknologic/payus-as-a-service@github)](https://gitads.dev/v1/ad-track?source=sticknologic/payus-as-a-service@github)


## API Usage

**Live API:** https://puaas.sticknologic.is-a.dev

**Interactive Documentation:** https://puaas.sticknologic.is-a.dev/docs

**Method:** `GET`

**Rate Limit:** `60 requests per minute per IP`

### API Endpoints
| Method | Endpoint            | Auth | Description                             | Rate Limit |
|--------|---------------------|------|-----------------------------------------|------------|
| GET    | /payus              | No   | Get a randomized message in random tone | 60/min     |
| GET    | /payus/professional | No   | Get random professional message         | 60/min     |
| GET    | /payus/frank        | No   | Get random frank message                | 60/min     |
| GET    | /payus/friendly     | No   | Get random friendly message             | 60/min     |
| GET    | /payus/playful      | No   | Get random playful message              | 60/min     |
| GET    | /payus/funny        | No   | Get random funny message                | 60/min     |
| GET    | /payus/tones        | No   | Get available tones                     | 60/min     |

## Setup

Requirements:

- Node.js 22+

Install and run:

```bash
npm install
npm start
```

Run tests:

```bash
npm test
```

The server listens on `http://localhost:3000` by default.

## Environment

- `PORT` changes the listen port.
- `RATE_LIMIT_PER_MINUTE` changes the in-memory request limit per IP.

## Response Shapes

Random message response:

```json
{
  "message": "string",
  "tone": "Professional"
}
```

Tone list response:

```json
{
  "success": true,
  "message": "Success",
  "data": {
    "tones": {
      "professional": "Professional",
      "playful": "Playful",
      "friendly": "Friendly",
      "frank": "Frank",
      "funny": "Funny"
    }
  }
}
```

Error response:

```json
{
  "success": false,
  "message": "No messages found for the specified criteria."
}
```

## Projects Using PayUs-as-a-Service

Here are some projects made by our **BRAVE** developers that integrate PayUs-as-a-Service to deliver their dismay, despair, and disappointment via past-due invoice messages:

- **Your Project Here?** If you're using PayUs-as-a-Service in your project, [open a pull request](https://github.com/sticknologic/payus-as-a-service/pulls) to be featured here!

## Contributing

We welcome contributions! Here's how you can help:

**Step 1:** Fork the repository

**Step 2:** Create your feature branch
```bash
git checkout -b feature/amazing-feature
```

**Step 3:** Make your changes and test them
```bash
npm test
```

**Step 4:** Commit your changes
```bash
git commit -m 'Add amazing feature'
```

**Step 5:** Push to the branch
```bash
git push origin feature/amazing-feature
```

**Step 6:** Open a Pull Request

### Ideas for Contributions
- Add more message variations to `messages.json`
- Improve documentation
- Add new language translations
- Fix bugs or improve performance
- Add new API features or tone categories

## Author

Created with a broken heart and torn wallet by [STICKnoLOGIC](https://sticknologic.is-a.dev)

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).