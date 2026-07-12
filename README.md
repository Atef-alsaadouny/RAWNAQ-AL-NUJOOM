<div align="center">
  <img src="https://rawnaq-al-nujoom.onrender.com/images/logo.webp" alt="Rawnaq Al Nujoom Logo" width="120" />
  <h1 align="center">راونق النجوم | Rawnaq Al Nujoom</h1>
  <p align="center"><strong>Beauty Salon Management System</strong> — A full-stack booking & administration platform for beauty salons, serving real customers in Kuwait.</p>
  <p align="center">
    <a href="https://rawnaq-al-nujoom.onrender.com/" target="_blank"><strong>🌐 Live Demo →</strong></a>
  </p>
  <br>
</div>

---

## About The Project

Rawnaq Al Nujoom is a **production-grade, bilingual (Arabic/English) web application** built for a real beauty salon business in Kuwait. It replaces traditional phone-based booking and paper records with a complete digital ecosystem: an interactive public-facing website for clients, and dedicated dashboards for administrators, employees, and customers — all within a single unified platform.

The project demonstrates **full-stack proficiency**, **database-driven architecture**, **role-based access control**, **responsive UI design**, and **real-world deployment** using modern cloud infrastructure.

### Live Demo

🔗 [https://rawnaq-al-nujoom.onrender.com/](https://rawnaq-al-nujoom.onrender.com/)

> The live demo is deployed on **Render** (web service) with a managed **Aiven** MySQL database. It runs in production and serves real user traffic.

---

## Tech Stack

| Layer | Technology |
|-------|------------|
| **Backend Framework** | Laravel 12 (PHP 8.2) |
| **Frontend** | Tailwind CSS, Alpine.js, JavaScript, Vite |
| **Database** | MySQL (managed via Aiven Cloud) |
| **Authentication** | Laravel Breeze (session-based, custom guards) |
| **Authorization & Roles** | Spatie Laravel Permission (Admin, Employee, Customer) |
| **Localization** | i18n with full Arabic/English support (`lang/ar.json`, `lang/en.json`) |
| **Payments** | Integrated payment gateway (KNET / Visa / Mastercard) |
| **Mailing** | Laravel Mail (SMTP) — transactional emails for bookings & contact form |
| **Queue & Scheduling** | Laravel Queue + Scheduler (appointment expiry, log cleanup) |
| **Deployment** | Render (Cloud Web Service) + Aiven (Managed MySQL) |
| **Version Control** | Git / GitHub |
| **Containerization** | Docker (Dockerfile + docker-compose for local dev) |

---

## Key Features

### 👩‍💼 Customer-Facing Website

- **Service Catalog** — Browse all salon services and packages with pricing and descriptions
- **Online Booking System** — Step-by-step booking flow: choose service/package → select employee → pick date/time → confirm
- **Booking Tracking** — Track appointment status using a unique barcode reference
- **Gallery** — Visual showcase of salon work
- **FAQ Section** — Common questions answered
- **Contact Form** — Sends email notification on submission
- **WhatsApp Integration** — Floating WhatsApp button for instant communication
- **Fully Responsive** — Built with Tailwind CSS, optimized for mobile, tablet, and desktop
- **Bilingual (AR/EN)** — Full Arabic and English interfaces with RTL/LTR support

### 🔐 Role-Based Dashboards

#### Admin Dashboard
- Complete CRUD management for **services**, **packages**, **employees**, **customers**, and **appointments**
- **Performance Reports** — Employee performance metrics and booking statistics
- **Schedule Management** — Manage weekly availability for each employee
- **Appointment Assignment** — Assign unassigned bookings to employees
- **Real-time Insights** — Dashboard stats: total bookings, revenue, active customers, etc.

#### Employee Dashboard
- View personal daily/weekly appointment schedule
- Mark appointments as completed or no-show
- View booking details and customer information
- Performance rating display

#### Customer Portal
- View personal booking history and status
- Modify or cancel upcoming appointments
- Update profile information
- Guest editing via barcode reference (no login required)

### 🔧 Technical Highlights

- **Role-Based Access Control** — Three distinct user roles with granular permissions using Spatie
- **Queue & Background Jobs** — Email notifications, appointment expiry handled asynchronously
- **Database Migrations & Seeders** — Reproducible schema and sample data
- **Custom Middleware** — Role verification, booking ownership, and authorization middleware
- **Barcode Integration** — Unique reference code per booking for guest tracking
- **Environment Configuration** — Multi-environment setup (local, staging, production)
- **Docker Support** — `Dockerfile` and `docker-compose.yml` for consistent local development

---

## Screenshots

> _Coming soon — UI screenshots demonstrating the public website, admin dashboard, and booking flow._

---

## Getting Started (Local Development)

```bash
# 1. Clone the repository
git clone https://github.com/Atef-alsaadouny/RAWNAQ-AL-NUJOOM.git
cd RAWNAQ-AL-NUJOOM

# 2. Install PHP dependencies
composer install

# 3. Install frontend dependencies
npm install && npm run build

# 4. Environment setup
cp .env.example .env
php artisan key:generate

# 5. Configure your database in .env, then run:
php artisan migrate --seed

# 6. Start the development server
php artisan serve

# 7. In a separate terminal, compile assets:
npm run dev
```

---

## Project Structure (High-Level)

```
├── app/
│   ├── Http/Controllers/       # Route controllers (Admin, Customer, Employee, Auth, etc.)
│   ├── Models/                  # Eloquent models
│   ├── Mail/                    # Mailable classes (booking confirmation, contact form)
│   ├── Services/                # Business logic layer
│   ├── Middleware/              # Custom middleware (role checks, etc.)
│   └── helpers.php             # Global helper functions
├── resources/views/            # Blade templates (public, admin, customer, employee, auth)
│   ├── layouts/                # Layout files (public, admin, customer, employee, guest)
│   ├── components/             # Reusable Blade components
│   └── partials/               # Include partials (flash messages, WhatsApp button)
├── routes/
│   ├── web.php                 # Public & authenticated web routes
│   ├── auth.php                # Authentication routes
│   ├── admin.php               # Admin-specific routes
│   ├── employee.php            # Employee-specific routes
│   └── console.php             # Scheduled tasks
├── public/                     # Entry point (index.php), assets, images
├── config/                     # Application configuration
├── database/
│   ├── migrations/             # Database schema migrations
│   └── seeders/                # Seed data for development
├── docker-compose.yml          # Local Docker setup
└── Dockerfile                  # Production build image
```

---

## What This Project Demonstrates

To a **technical recruiter** or **engineering manager**, this project shows:

- **Full-stack capability** — From database schema design and backend API logic to responsive frontend UI and cloud deployment
- **Clean architecture** — Separation of concerns (Controllers, Services, Models), middleware abstraction, and reusable components
- **Production mindset** — Real-world features (authentication, authorization, payments, email, scheduling, queueing, error pages)
- **Code quality** — Organized routes, meaningful commit history, structured views, and consistent coding patterns
- **DevOps awareness** — Docker setup, environment configuration, deployment to Render with managed database hosting
- **UX consideration** — Responsive design, bilingual support, intuitive booking flow, mobile-first approach

---

## License

This project is open-sourced under the MIT license.

---

<div align="center">
  <p>Built with ❤️ by <a href="https://github.com/Atef-alsaadouny">Atef Alsaadouny</a></p>
  <p>
    <a href="https://rawnaq-al-nujoom.onrender.com/">Live Demo</a> ·
    <a href="https://github.com/Atef-alsaadouny/RAWNAQ-AL-NUJOOM">GitHub Repository</a>
  </p>
</div>
