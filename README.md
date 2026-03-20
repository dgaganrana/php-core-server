# PHP Core Server

A minimalist PHP 8 project that demonstrates routing, controllers, services, and response handling for building web pages and APIs.

---

## 📦 Features
- 🚀 Lightweight routing for GET/POST requests
- 🌐 Dual support for web pages (`public/`) and JSON APIs
- 📦 Response abstraction with status codes, headers, and body
- 🛡️ Centralized error handling
- ⚙️ Environment configuration via `vlucas/phpdotenv`
- 📝 Logging support with Monolog

---

## 🛠️ Prerequisites
Before running this project, make sure you have:

- **PHP 8.0+** installed (with CLI support)  
- **Composer** (latest version) for dependency management  
- **Git** for cloning and version control  
- Optional: **cURL** or **Postman** for testing API endpoints  
- Optional: **PHPUnit 13+** for running the test suite  

---

## 📂 Project Structure
```
php-core-server/
├── composer.json          # Project dependencies & autoload
├── composer.lock          # Locked dependency versions
├── config/                # App configuration & routes
│   ├── AppEnv.php
│   ├── constants.php
│   └── routes.php
├── docs/
│   └── request-flow.md
├── phpunit.xml            # PHPUnit configuration
├── public/                # Public entrypoint for web server
│   ├── homePage.php
│   └── index.php
├── src/                   # Application source code
│   ├── Controllers/       # Controllers (Home, Health)
│   ├── Http/              # Response abstraction
│   ├── Routing/           # Router
│   └── Services/          # Business logic services
└── tests/                 # Test suite
    ├── bootstrap.php
    ├── Feature/           # Feature tests
    └── Unit/              # Unit tests
```

---

## 🔄 Request Flow

The lifecycle of a request in **php-core-server** is documented in detail.

👉 [View full Request Flow documentation](docs/request-flow.md)

---

## 🚀 Getting Started

### 1. Clone the Repository
```bash
git clone https://github.com/dgaganrana/php-core-server.git
cd php-core-server
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Run Local Development Server
```bash
composer start
```
Visit `http://localhost:8000` in your browser.

To stop the server:
```bash
composer stop
```

---

## 🧪 Running Tests
```bash
vendor/bin/phpunit --testdox
```

---

## 🔧 Scripts
- `composer start` → Start PHP built-in server at `localhost:8000`
- `composer stop` → Stop the server
- `composer restart` → Restart the server

---

## 📜 License
MIT License © 2026 Gagan
