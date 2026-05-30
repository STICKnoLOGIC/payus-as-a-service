const assert = require('node:assert/strict');
const test = require('node:test');

const { createServer, toneLabels } = require('../index');

async function withServer(callback) {
  const server = createServer();

  await new Promise((resolve) => {
    server.listen(0, resolve);
  });

  const { port } = server.address();

  try {
    await callback(`http://127.0.0.1:${port}`);
  } finally {
    await new Promise((resolve) => {
      server.close(resolve);
    });
  }
}

test('GET /payus returns a message and tone', async () => {
  await withServer(async (baseUrl) => {
    const response = await fetch(`${baseUrl}/payus`);
    const body = await response.json();

    assert.equal(response.status, 200);
    assert.equal(typeof body.message, 'string');
    assert.equal(typeof body.tone, 'string');
    assert.ok(Object.values(toneLabels).includes(body.tone));
  });
});

for (const [toneKey, toneLabel] of Object.entries(toneLabels)) {
  test(`GET /payus/${toneKey} returns ${toneLabel}`, async () => {
    await withServer(async (baseUrl) => {
      const response = await fetch(`${baseUrl}/payus/${toneKey}`);
      const body = await response.json();

      assert.equal(response.status, 200);
      assert.equal(body.tone, toneLabel);
      assert.equal(typeof body.message, 'string');
    });
  });
}

test('GET /payus/tones returns the available tones', async () => {
  await withServer(async (baseUrl) => {
    const response = await fetch(`${baseUrl}/payus/tones`);
    const body = await response.json();

    assert.equal(response.status, 200);
    assert.equal(body.success, true);
    assert.equal(body.message, 'Success');
    assert.deepEqual(body.data.tones, toneLabels);
  });
})

test('rate limit blocks requests after 60 per minute', async () => {
  await withServer(async (baseUrl) => {
    let lastResponse;

    for (let attempt = 0; attempt < 61; attempt += 1) {
      lastResponse = await fetch(`${baseUrl}/payus`);
    }

    assert.equal(lastResponse.status, 429);
  });
});