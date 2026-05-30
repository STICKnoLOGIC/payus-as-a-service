const express = require('express');
const rateLimit = require('express-rate-limit');
const fs = require('node:fs');
const path = require('node:path');
const http = require('node:http');

const PORT = Number(process.env.PORT || 3000);

const toneLabels = {
  professional: 'Professional',
  playful: 'Playful',
  friendly: 'Friendly',
  frank: 'Frank',
  funny: 'Funny',
};

const toneIds = {
  professional: 0,
  playful: 1,
  friendly: 2,
  frank: 3,
  funny: 4,
};

const rootDir = __dirname;
const messagesPath = path.join(rootDir, 'messages.json');
const docsPath = path.join(rootDir, 'public', 'docs.html');
const faviconPath = path.join(rootDir, 'public', 'favicon.ico');
const ogImagePath = path.join(rootDir, 'public', 'og-image.png');

const messages = JSON.parse(fs.readFileSync(messagesPath, 'utf8'));
const messagesByTone = {
  professional: [],
  playful: [],
  friendly: [],
  frank: [],
  funny: [],
};

for (const message of messages) {
  const toneKey = Object.keys(toneIds).find((key) => toneIds[key] === message.tone);
  if (toneKey) {
    messagesByTone[toneKey].push(message);
  }
}

const cachedDocsHtml = fs.existsSync(docsPath) ? fs.readFileSync(docsPath, 'utf8') : null;
const cachedFavicon = fs.existsSync(faviconPath) ? fs.readFileSync(faviconPath) : null;
const cachedOgImage = fs.existsSync(ogImagePath) ? fs.readFileSync(ogImagePath) : null;


function getRandomMessage(toneKey = null) {
  const items = toneKey === null ? messages : messagesByTone[toneKey] || [];

  if (items.length === 0) {
    return null;
  }

  const message = items[Math.floor(Math.random() * items.length)];
  const resolvedToneKey = toneKey || Object.keys(toneIds).find((key) => toneIds[key] === message.tone);

  if (!resolvedToneKey) {
    return null;
  }

  return {
    message: message.message,
    tone: toneLabels[resolvedToneKey],
  };
}

function createApp() {
  const app = express();

  app.disable('x-powered-by');

  app.use(
    rateLimit({
      windowMs: 60_000,
      max: 60,
      standardHeaders: false,
      legacyHeaders: false,
      message: { message: 'Too Many Requests' },
    }),
  );

  app.get(['/', '/docs'], (req, res) => {
    if (typeof cachedDocsHtml !== 'string') {
      res.status(500).json({ success: false, message: 'Documentation unavailable' });
      return;
    }

    res.type('html').send(cachedDocsHtml);
  });

  app.get('/og-image.png', (req, res) => {
    if (!cachedOgImage) {
      res.status(404).json({ success: false, message: 'Page Not Found' });
      return;
    }
  
    res.type('png').send(cachedOgImage);
  });

  app.get('/robots.txt', (req, res) => {
    res.type('text/plain').send('User-agent: *\nDisallow: /');
  });
  
  app.get('/favicon.ico', (req, res) => {
    if (!cachedFavicon) {
      res.status(404).json({ success: false, message: 'Page Not Found' });
      return;
    }

    res.type('image/x-icon').send(cachedFavicon);
  });

  app.get('/payus', (req, res) => {
    const body = getRandomMessage();

    if (!body) {
      res.status(404).json({ success: false, message: 'No messages found for the specified criteria.' });
      return;
    }

    res.json(body);
  });

  app.get('/payus/tones', (req, res) => {
    res.json({
      success: true,
      message: 'Success',
      data: { tones: toneLabels },
    });
  });

  app.get('/payus/:tone', (req, res) => {
    const toneKey = req.params.tone;

    if (!toneLabels[toneKey]) {
      res.status(404).json({ success: false, message: 'Page Not Found' });
      return;
    }

    const body = getRandomMessage(toneKey);

    if (!body) {
      res.status(404).json({ success: false, message: 'No messages found for the specified criteria.' });
      return;
    }

    res.json(body);
  });

  app.use((req, res) => {
    res.status(404).json({ success: false, message: 'Page Not Found' });
  });

  return app;
}

function createServer() {
  const app = createApp();
  return http.createServer(app);
}

if (require.main === module) {
  createApp().listen(PORT, '0.0.0.0', () => {
    console.log(`PayUs-as-a-Service is running on http://0.0.0.0:${PORT}`);
  });
}

module.exports = { createServer, toneLabels };