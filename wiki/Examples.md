# Examples & Integration

Real-world examples of integrating PayUs-as-a-Service into your applications.

---

## Table of Contents

- [cURL Examples](#curl-examples)
- [JavaScript/Node.js](#javascriptnodejs)
- [Python](#python)
- [PHP](#php)
- [Ruby](#ruby)
- [Go](#go)
- [Integration Patterns](#integration-patterns)

---

## cURL Examples

### Get Random Message

```bash
curl https://puaas.sticknologic.is-a.dev/payus
```

### Get Professional Message

```bash
curl https://puaas.sticknologic.is-a.dev/payus/professional
```

### Get All Tones

```bash
curl https://puaas.sticknologic.is-a.dev/payus/tones
```

### With Headers

```bash
curl -H "Accept: application/json" \
     -H "User-Agent: MyApp/1.0" \
     https://puaas.sticknologic.is-a.dev/payus
```

---

## JavaScript/Node.js

### Using Fetch API (Browser/Node 18+)

```javascript
async function getPaymentReminder(tone = null) {
  const url = tone 
    ? `https://puaas.sticknologic.is-a.dev/payus/${tone}`
    : 'https://puaas.sticknologic.is-a.dev/payus';
  
  try {
    const response = await fetch(url);
    const data = await response.json();
    
    if (response.ok) {
      console.log(`Message: ${data.message}`);
      console.log(`Tone: ${data.tone}`);
      return data;
    } else {
      console.error('Error:', data.message);
    }
  } catch (error) {
    console.error('Request failed:', error);
  }
}

// Usage
getPaymentReminder(); // Random tone
getPaymentReminder('professional'); // Specific tone
```

### Using Axios

```javascript
const axios = require('axios');

const getPaymentReminder = async (tone = null) => {
  const url = tone 
    ? `https://puaas.sticknologic.is-a.dev/payus/${tone}`
    : 'https://puaas.sticknologic.is-a.dev/payus';
  
  try {
    const { data } = await axios.get(url);
    console.log(`Message: ${data.message}`);
    console.log(`Tone: ${data.tone}`);
    return data;
  } catch (error) {
    console.error('Error:', error.response?.data || error.message);
  }
};

// Usage
getPaymentReminder('funny');
```

### React Component

```jsx
import { useState, useEffect } from 'react';

function PaymentReminder({ tone = 'professional' }) {
  const [message, setMessage] = useState('');
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch(`https://puaas.sticknologic.is-a.dev/payus/${tone}`)
      .then(res => res.json())
      .then(data => {
        setMessage(data.message);
        setLoading(false);
      })
      .catch(err => {
        console.error(err);
        setLoading(false);
      });
  }, [tone]);

  if (loading) return <div>Loading...</div>;

  return (
    <div className="payment-reminder">
      <p>{message}</p>
      <small>Tone: {tone}</small>
    </div>
  );
}

export default PaymentReminder;
```

---

## Python

### Using Requests Library

```python
import requests

def get_payment_reminder(tone=None):
    base_url = "https://puaas.sticknologic.is-a.dev/payus"
    url = f"{base_url}/{tone}" if tone else base_url
    
    try:
        response = requests.get(url)
        response.raise_for_status()
        data = response.json()
        
        print(f"Message: {data['message']}")
        print(f"Tone: {data['tone']}")
        return data
    except requests.exceptions.RequestException as e:
        print(f"Error: {e}")
        return None

# Usage
get_payment_reminder()  # Random tone
get_payment_reminder('friendly')  # Specific tone
```

### Using httpx (Async)

```python
import httpx
import asyncio

async def get_payment_reminder(tone=None):
    base_url = "https://puaas.sticknologic.is-a.dev/payus"
    url = f"{base_url}/{tone}" if tone else base_url
    
    async with httpx.AsyncClient() as client:
        try:
            response = await client.get(url)
            response.raise_for_status()
            data = response.json()
            
            print(f"Message: {data['message']}")
            print(f"Tone: {data['tone']}")
            return data
        except httpx.HTTPError as e:
            print(f"Error: {e}")
            return None

# Usage
asyncio.run(get_payment_reminder('frank'))
```

### Flask Integration

```python
from flask import Flask, jsonify
import requests

app = Flask(__name__)

@app.route('/reminder/<tone>')
def get_reminder(tone):
    url = f"https://puaas.sticknologic.is-a.dev/payus/{tone}"
    response = requests.get(url)
    
    if response.status_code == 200:
        return jsonify(response.json())
    else:
        return jsonify({"error": "Failed to fetch reminder"}), 500

if __name__ == '__main__':
    app.run(debug=True)
```

---

## PHP

### Using cURL

```php
<?php

function getPaymentReminder($tone = null) {
    $baseUrl = 'https://puaas.sticknologic.is-a.dev/payus';
    $url = $tone ? "$baseUrl/$tone" : $baseUrl;
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        echo "Message: {$data['message']}\n";
        echo "Tone: {$data['tone']}\n";
        return $data;
    }
    
    return null;
}

// Usage
getPaymentReminder(); // Random
getPaymentReminder('professional'); // Specific
```

### Using Guzzle

```php
<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client(['base_uri' => 'https://puaas.sticknologic.is-a.dev']);

try {
    $response = $client->get('/payus/funny');
    $data = json_decode($response->getBody(), true);
    
    echo "Message: {$data['message']}\n";
    echo "Tone: {$data['tone']}\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

### Laravel Integration

```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymentReminderService
{
    protected $baseUrl = 'https://puaas.sticknologic.is-a.dev/payus';

    public function getReminderMessage($tone = null)
    {
        $url = $tone ? "$this->baseUrl/$tone" : $this->baseUrl;
        
        $response = Http::get($url);
        
        if ($response->successful()) {
            return $response->json();
        }
        
        return null;
    }
}

// Usage in Controller
public function sendReminder($invoiceId)
{
    $service = new PaymentReminderService();
    $reminder = $service->getReminderMessage('professional');
    
    // Send email with $reminder['message']
}
```

---

## Ruby

### Using Net::HTTP

```ruby
require 'net/http'
require 'json'

def get_payment_reminder(tone = nil)
  base_url = 'https://puaas.sticknologic.is-a.dev/payus'
  url = tone ? "#{base_url}/#{tone}" : base_url
  
  uri = URI(url)
  response = Net::HTTP.get_response(uri)
  
  if response.is_a?(Net::HTTPSuccess)
    data = JSON.parse(response.body)
    puts "Message: #{data['message']}"
    puts "Tone: #{data['tone']}"
    data
  else
    puts "Error: #{response.code}"
    nil
  end
end

# Usage
get_payment_reminder
get_payment_reminder('playful')
```

### Using HTTParty

```ruby
require 'httparty'

class PaymentReminderService
  include HTTParty
  base_uri 'https://puaas.sticknologic.is-a.dev'

  def self.get_reminder(tone = nil)
    endpoint = tone ? "/payus/#{tone}" : '/payus'
    response = get(endpoint)
    
    if response.success?
      puts "Message: #{response['message']}"
      puts "Tone: #{response['tone']}"
      response
    else
      puts "Error: #{response.code}"
      nil
    end
  end
end

# Usage
PaymentReminderService.get_reminder('frank')
```

---

## Go

```go
package main

import (
    "encoding/json"
    "fmt"
    "io"
    "net/http"
)

type ReminderResponse struct {
    Message string `json:"message"`
    Tone    string `json:"tone"`
}

func getPaymentReminder(tone string) (*ReminderResponse, error) {
    url := "https://puaas.sticknologic.is-a.dev/payus"
    if tone != "" {
        url = fmt.Sprintf("%s/%s", url, tone)
    }

    resp, err := http.Get(url)
    if err != nil {
        return nil, err
    }
    defer resp.Body.Close()

    body, err := io.ReadAll(resp.Body)
    if err != nil {
        return nil, err
    }

    var reminder ReminderResponse
    err = json.Unmarshal(body, &reminder)
    if err != nil {
        return nil, err
    }

    return &reminder, nil
}

func main() {
    reminder, err := getPaymentReminder("professional")
    if err != nil {
        fmt.Println("Error:", err)
        return
    }

    fmt.Printf("Message: %s\n", reminder.Message)
    fmt.Printf("Tone: %s\n", reminder.Tone)
}
```

---

## Integration Patterns

### Email Automation

```javascript
const nodemailer = require('nodemailer');

async function sendPaymentReminder(clientEmail, tone = 'professional') {
  // Get reminder message
  const response = await fetch(`https://puaas.sticknologic.is-a.dev/payus/${tone}`);
  const { message } = await response.json();
  
  // Send email
  const transporter = nodemailer.createTransport({...});
  
  await transporter.sendMail({
    from: 'billing@yourcompany.com',
    to: clientEmail,
    subject: 'Payment Reminder',
    text: message
  });
}
```

### Slack Bot Integration

```javascript
const { WebClient } = require('@slack/web-api');

async function postReminderToSlack(channel, tone = 'funny') {
  const response = await fetch(`https://puaas.sticknologic.is-a.dev/payus/${tone}`);
  const { message } = await response.json();
  
  const slack = new WebClient(process.env.SLACK_TOKEN);
  
  await slack.chat.postMessage({
    channel: channel,
    text: `💰 Payment Reminder: ${message}`
  });
}
```

### Scheduled Tasks (Cron)

```python
# daily_reminders.py
import requests
import smtplib
from datetime import datetime

def send_daily_reminders():
    # Get a friendly reminder
    response = requests.get('https://puaas.sticknologic.is-a.dev/payus/friendly')
    data = response.json()
    
    # Send to overdue clients
    # ... your email logic here
    
    print(f"[{datetime.now()}] Sent reminders: {data['message']}")

if __name__ == '__main__':
    send_daily_reminders()
```

Crontab entry:
```bash
0 9 * * * /usr/bin/python3 /path/to/daily_reminders.py
```

---

## Error Handling

### Handling Rate Limits

```javascript
async function getPaymentReminderWithRetry(tone, maxRetries = 3) {
  for (let i = 0; i < maxRetries; i++) {
    try {
      const response = await fetch(`https://puaas.sticknologic.is-a.dev/payus/${tone}`);
      
      if (response.status === 429) {
        // Rate limited - wait and retry
        const retryAfter = response.headers.get('Retry-After') || 60;
        console.log(`Rate limited. Retrying after ${retryAfter}s...`);
        await new Promise(resolve => setTimeout(resolve, retryAfter * 1000));
        continue;
      }
      
      if (response.ok) {
        return await response.json();
      }
      
      throw new Error(`HTTP ${response.status}: ${response.statusText}`);
    } catch (error) {
      if (i === maxRetries - 1) throw error;
      console.log(`Retry ${i + 1}/${maxRetries}...`);
    }
  }
}
```

---

## Need More Examples?

- Ask in [GitHub Discussions](https://github.com/sticknologic/payus-as-a-service/discussions)
- Check [Interactive Docs](https://puaas.sticknologic.is-a.dev/docs) for API testing
- See the [API Reference](API-Reference) for detailed endpoint info
