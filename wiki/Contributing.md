# Contributing to PayUs-as-a-Service

Thank you for considering contributing to PayUs-as-a-Service! We welcome contributions from everyone.

> **📖 Resources:** [Main Repository](https://github.com/sticknologic/paynow-as-a-service) | [Self-Hosting Guide](Self-Hosting-Guide) | [API Reference](API-Reference)

---

## Ways to Contribute

### 1. Add More Messages

The easiest way to contribute! We're always looking for more creative payment reminder messages.

**Steps:**
1. Fork the repository
2. Edit `messages.json` in the root directory
3. Add your messages to the appropriate tone category (see tone values below)
4. Test your changes locally
5. Submit a pull request

**Message Structure:**

The `messages.json` file contains an array of message objects with two fields:
```json
{
  "message": "Your payment reminder text here",
  "tone": 0
}
```

**Tone Values:**
- `0` = Professional (formal, business-like)
- `1` = Playful (witty, engaging)
- `2` = Friendly (warm, approachable)
- `3` = Frank (direct, straightforward)
- `4` = Funny (humorous, lighthearted)

**Example Addition:**
```json
[
  {
    "message": "We kindly request immediate payment for the outstanding invoice.",
    "tone": 0
  },
  {
    "message": "Your invoice is doing the cha-cha slide... slide to the payment button!",
    "tone": 4
  }
]
```

**Message Guidelines:**
- Keep messages professional and appropriate
- Maintain the tone's character consistently
- Keep messages under 200 characters when possible
- Ensure proper grammar and spelling
- Avoid offensive, discriminatory, or inappropriate content
- Make sure the tone value matches the message style
- Test that your JSON is valid (use a JSON validator)
- **IMPORTANT:** Group messages by tone - keep all messages of the same tone together

**Message Organization:**

✅ **Correct - Messages grouped by tone:**
```json
[
  {"message": "Professional message 1", "tone": 0},
  {"message": "Professional message 2", "tone": 0},
  {"message": "Professional message 3", "tone": 0},
  {"message": "Playful message 1", "tone": 1},
  {"message": "Playful message 2", "tone": 1},
  {"message": "Friendly message 1", "tone": 2}
]
```

❌ **Incorrect - Messages mixed randomly:**
```json
[
  {"message": "Professional message", "tone": 0},
  {"message": "Friendly message", "tone": 2},
  {"message": "Playful message", "tone": 1},
  {"message": "Professional message", "tone": 0},
  {"message": "Funny message", "tone": 4}
]
```

**When adding new messages:**
1. Find the section in `messages.json` with your desired tone
2. Add your new messages at the end of that tone's group
3. Keep all messages with the same tone value together

**Testing Your Messages:**

After adding messages, test locally:
```bash
# Seed the database with your new messages
docker compose exec app php artisan migrate:fresh --seed

# Test the API
curl http://localhost/payus
```

---

### 2. Report Bugs

Found a bug? Help us fix it!

**Before Reporting:**
- Check if the issue already exists in [GitHub Issues](https://github.com/sticknologic/payus-as-a-service/issues)
- Try to reproduce the issue
- Gather relevant information (error messages, logs, steps to reproduce)

**Creating a Bug Report:**
1. Go to [Issues](https://github.com/sticknologic/payus-as-a-service/issues/new)
2. Choose "Bug Report" template
3. Fill in all required information
4. Add labels (bug, documentation, etc.)

**Include:**
- Clear description of the problem
- Steps to reproduce
- Expected behavior
- Actual behavior
- Environment details (OS, PHP version, Docker version)
- Error messages/logs
- Screenshots if applicable

---

### 3. Suggest Features

Have an idea for improvement?

**Before Suggesting:**
- Check [existing discussions](https://github.com/sticknologic/payus-as-a-service/discussions)
- Think about how it benefits users
- Consider if it fits the project's scope

**Creating a Feature Request:**
1. Open a [Discussion](https://github.com/sticknologic/payus-as-a-service/discussions/new?category=ideas)
2. Describe your idea clearly
3. Explain the use case
4. Discuss implementation if you have thoughts

---

### 4. Improve Documentation

Documentation improvements are always welcome!

**Areas to Improve:**
- Fix typos or unclear explanations
- Add missing information
- Create tutorials or guides
- Improve code examples
- Update outdated information

**Wiki Contributions:**
- Edit markdown files in the `/wiki` directory
- Follow [Wiki Guidelines](WIKI-GUIDELINES) for formatting conventions
- Use proper internal links: `[Page Name](Page-Name)` (no `.md` extension)
- Test links work correctly
- Submit pull request - changes will auto-sync to GitHub Wiki on merge
- See [GitHub Actions](.github/workflows/wiki-sync.yml) for automation details

---

### 5. Submit Code Contributions

Ready to contribute code? Awesome!

---

## Development Setup

### Prerequisites

- Git
- Docker & Docker Compose (or PHP 8.3+, Composer)
- Text editor/IDE
- Basic knowledge of Laravel

### Setup Steps

**1. Fork the repository**

Click "Fork" on GitHub to create your copy.

**2. Clone your fork**

```bash
git clone https://github.com/YOUR_USERNAME/payus-as-a-service.git
cd payus-as-a-service
```

**3. Set up environment**

```bash
cp .env.example .env
cp sample.env.db .env.db
```

Edit `.env.db` for MySQL configuration:
```env
MYSQL_ROOT_PASSWORD=your_root_password
MYSQL_DATABASE=puaas_db
MYSQL_USER=puaas_user
MYSQL_PASSWORD=your_password
```

Edit `.env` and configure your database connection:
```env
DB_CONNECTION=mysql
DB_HOST=mysql_puaas
DB_PORT=3306
DB_DATABASE=puaas_db
DB_USERNAME=puaas_user
DB_PASSWORD=your_password
```

**Alternative: Using SQLite (No MySQL container needed)**
```env
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/database/database.sqlite
```

**4. Start Docker containers**

```bash
docker compose build
docker compose up -d
```

**5. Install dependencies**

```bash
docker compose exec app composer install
```

**6. Generate app key**

```bash
docker compose exec app php artisan key:generate
```

**7. Run migrations and seed data**

```bash
# Wait for MySQL to be ready (if using MySQL)
sleep 10

# Run migrations and seed data
docker compose exec app php artisan migrate:fresh --seed
```

**Note:** If using SQLite instead, create the database first:
```bash
docker compose exec app touch database/database.sqlite
docker compose exec app php artisan migrate:fresh --seed
```

**8. Verify installation**

```bash
# Access the API
curl http://localhost/payus

# Run tests
docker compose exec app composer test
```

---

## Making Changes

### Branch Naming

Create a descriptive branch for your changes:

```bash
git checkout -b feature/add-aggressive-tone
git checkout -b fix/docs-404-error
git checkout -b docs/improve-installation-guide
```

**Patterns:**
- `feature/` - New features
- `fix/` - Bug fixes
- `docs/` - Documentation changes
- `refactor/` - Code refactoring
- `test/` - Test additions/changes

### Coding Standards

We use Laravel's coding standards:

**1. Run Pint (code formatter)**

```bash
docker compose exec app ./vendor/bin/pint
```

**2. Run Rector (code modernization)**

```bash
docker compose exec app ./vendor/bin/rector
```

**3. Run PHPStan (static analysis)**

```bash
docker compose exec app composer phpstan
```

**4. Run all checks**

```bash
# Runs lint, static analysis, and tests
docker compose exec app composer test
```

**Individual test commands:**
```bash
# Lint only (Pint + Rector)
docker compose exec app composer lint

# Type checking only
docker compose exec app composer test:types

# Unit tests only
docker compose exec app composer test:unit
```

**Key Points:**
- Follow PSR-12 coding standard
- Use type hints
- Add PHPDoc blocks
- Keep methods small and focused
- Write descriptive variable names
- Add comments for complex logic

### Writing Tests

All new features should include tests.

**Create a test:**

```bash
docker compose exec app php artisan make:test YourFeatureTest
```

**Run tests:**

```bash
# All tests with all checks (lint + types + tests)
docker compose exec app composer test

# Unit tests only
docker compose exec app composer test:unit

# Specific test file
docker compose exec app php artisan test --filter PayUsTest

# Using Pest directly
docker compose exec app ./vendor/bin/pest
docker compose exec app ./vendor/bin/pest --filter=PayUsTest
```

**Example Test:**

```php
it('returns a professional message', function () {
    $response = $this->get('/payus/professional');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'tone'
        ])
        ->assertJson([
            'tone' => 'Professional'
        ]);
});
```

---

## Commit Guidelines

### Commit Messages

Write clear, descriptive commit messages:

```bash
# Good ✅
git commit -m "Add 50 new funny tone messages"
git commit -m "Fix 404 error on docs page in production"
git commit -m "Update installation guide with troubleshooting steps"

# Bad ❌
git commit -m "updates"
git commit -m "fix bug"
git commit -m "changes"
```

**Format:**
```
<type>: <subject>

<body (optional)>

<footer (optional)>
```

**Types:**
- `feat:` New feature
- `fix:` Bug fix
- `docs:` Documentation changes
- `style:` Code style changes (formatting)
- `refactor:` Code refactoring
- `test:` Adding or updating tests
- `chore:` Maintenance tasks

**Example:**
```
feat: Add support for sarcastic tone

- Add new MessageTone enum value
- Add 300 sarcastic messages to messages.json
- Update API documentation
- Add tests for sarcastic tone endpoint

Closes #42
```

---

## Submitting a Pull Request

### Before Submitting

**Checklist:**
- [ ] Code follows project standards
- [ ] All tests pass (`composer test`)
- [ ] New features have tests
- [ ] Documentation is updated
- [ ] Commit messages are clear
- [ ] Branch is up to date with `main`

### Update Your Branch

```bash
# Add upstream remote (one time)
git remote add upstream https://github.com/sticknologic/payus-as-a-service.git

# Fetch latest changes
git fetch upstream

# Rebase your branch
git rebase upstream/main

# Resolve conflicts if any
# Then push
git push origin your-branch-name --force-with-lease
```

### Create Pull Request

1. Go to your fork on GitHub
2. Click "New Pull Request"
3. Select your branch
4. Fill in the PR template:
   - Clear title
   - Description of changes
   - Related issues
   - Screenshots (if UI changes)
   - Checklist items

**PR Title Examples:**
- `Add 100 new playful tone messages`
- `Fix docs not showing in production environment`
- `Update README with deployment guide`

### After Submitting

- Respond to feedback promptly
- Make requested changes
- Keep the discussion focused and professional
- Be patient - reviews may take time

---

## Code Review Process

### What We Look For

1. **Functionality** - Does it work as intended?
2. **Code Quality** - Is it clean and maintainable?
3. **Tests** - Are there adequate tests?
4. **Documentation** - Is it documented?
5. **Standards** - Does it follow our guidelines?

### Getting Your PR Merged

- All tests must pass
- At least one approving review
- No unresolved conversations
- Branch must be up to date with main

---

## Development Tips

### Running Specific Commands

```bash
# PHP Artisan commands
docker compose exec app php artisan route:list
docker compose exec app php artisan tinker
docker compose exec app php artisan migrate:status

# Composer
docker compose exec app composer require package-name
docker compose exec app composer dump-autoload

# Database (if using MySQL)
docker compose exec mysql_puaas mysql -u root -p

# SQLite database access
docker compose exec app php artisan db

# View logs
docker compose logs -f app
docker compose logs -f nginx
```

### Hot Reload (Development)

```bash
# Watch for file changes and auto-reload
docker compose up
```

### Debugging

```env
# Enable debug mode in .env
APP_DEBUG=true
LOG_LEVEL=debug
```

---

## Community Guidelines

### Be Respectful

- Be kind and courteous
- Respect different viewpoints
- Provide constructive feedback
- Assume good intentions

### Communication

- Keep discussions on-topic
- Use clear, concise language
- Be patient with newcomers
- Ask questions when unsure

### Code of Conduct

This project follows the [Contributor Covenant Code of Conduct](https://www.contributor-covenant.org/version/2/1/code_of_conduct/).

---

## Need Help?

### Getting Started

- Read the [README](https://github.com/sticknologic/payus-as-a-service#readme)
- Check the [Wiki](https://github.com/sticknologic/payus-as-a-service/wiki)
- Look at [existing PRs](https://github.com/sticknologic/payus-as-a-service/pulls)

### Ask Questions

- [GitHub Discussions](https://github.com/sticknologic/payus-as-a-service/discussions)
- [Q&A Section](https://github.com/sticknologic/payus-as-a-service/discussions/new?category=q-a)

### Report Issues

- [GitHub Issues](https://github.com/sticknologic/payus-as-a-service/issues)

---

## Recognition

Contributors will be:
- Listed in the project's contributors page
- Mentioned in release notes (for significant contributions)
- Credited in the README (for major features)

---

## Ideas for First Contributions

New to open source? Try these beginner-friendly tasks:

- [ ] Add 10-20 new messages to any tone
- [ ] Fix typos in documentation
- [ ] Improve README examples
- [ ] Add your language translation
- [ ] Write a tutorial for your tech stack
- [ ] Create an integration example
- [ ] Update outdated documentation
- [ ] Add missing type hints
- [ ] Improve error messages
- [ ] Add more tests

Look for issues labeled `good first issue` or `help wanted`.

---

## Thank You!

Every contribution, no matter how small, is valuable. Thank you for helping make PayUs-as-a-Service better!

---

**Questions?** Ask in [Discussions](https://github.com/sticknologic/payus-as-a-service/discussions)

**Ready to contribute?** [Fork the repo](https://github.com/sticknologic/payus-as-a-service/fork) and get started!
