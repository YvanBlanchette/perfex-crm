# Perfex CRM — Laravel 11 + React 18

A full-featured CRM clone built with Laravel 11 (API backend) and React 18 (SPA frontend).

## Stack
- **Backend**: Laravel 11, Sanctum, MySQL, DomPDF
- **Frontend**: React 18, Vite, Tailwind CSS, TanStack Query, Zustand, React Router v6

## Quick Start

### Backend
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

### Frontend
```bash
cd frontend
npm install
npm run dev
```

## Demo Login
- URL: http://localhost:5173
- Email: admin@perfexcrm.com
- Password: password

## Modules
Dashboard, Clients, Contacts, Projects, Tasks, Invoices (PDF), Estimates, Payments, Leads (Kanban), Expenses, Users, Settings, Activity Log, Notifications, Client Portal

## Deployment
See README-DEPLOYMENT.md for Nginx/Apache/Supervisor/cron setup.
