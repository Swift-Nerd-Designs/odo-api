# Client API

CodeIgniter 4 REST API — generic template for client websites.

## Requirements
- PHP 8.1+
- MySQL 5.7+ / MariaDB
- Composer

## Setup
```bash
composer install
cp .env.example .env
# Edit .env with your database credentials and API keys
php spark migrate
php spark serve   # runs on http://localhost:8080
```

## Routes
- `GET  /content/settings` — public site settings
- `GET  /content/pages` — all CMS pages
- `GET  /content/page/:slug` — single page by slug
- `POST /contact` — contact form submission
- `POST /admin/login` — admin login
- `GET  /admin/me` — check auth session
- `GET  /admin/pages` — list pages (admin)
- `POST /admin/pages/:slug` — create/update page (admin)
- `POST /admin/upload` — upload image to Cloudinary (admin)
- `POST /admin/upload-pdf` — upload PDF to Cloudinary (admin)

## Adding a New Content Type
1. Create migration for the table
2. Add admin CRUD controller in `app/Controllers/Admin/`
3. Add public content controller in `app/Controllers/Content/`
4. Register routes in `app/Config/Routes.php`

## Deployment (Afrihost cPanel)
See `../client-template/docs/04-deployment-afrihost.md`
