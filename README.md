from pathlib import Path

readme_content = """
# 📰 Laravel News Dashboard (with Redis & Meilisearch)

This is a Laravel-powered content management system with advanced features like real-time notifications, Redis-based caching, Meilisearch search engine, authorization control, and full support for SEO.

---

## 🚀 Features

- 🧠 Role & Permission System
- 💬 Real-time Comment Notifications (via Pusher)
- 🔍 Full-text Search with Meilisearch
- ⚡ Redis Caching for better performance
- 📧 Laravel Mail Support
- 📑 SEO Meta Management
- 🔐 Multi-auth Guards (Admin/User)
- 🗂️ AJAX & jQuery Integration
- 🧪 Validation (Client, Server, DB levels)
- 📊 Admin Dashboard with stats
- 📆 Carbon for date/time formatting
- 💬 Laravel Socialite for social login


---

## 🔧 Technologies Used

| Feature             | Stack/Tool                     |
|---------------------|--------------------------------|
| Framework           | Laravel 10.x                   |
| Frontend            | Bootstrap 4, jQuery            |
| Database            | MySQL                          |
| Caching             | Redis                          |
| Search              | Meilisearch                    |
| Realtime Events     | Laravel Echo + Pusher          |
| Authorization       | Gates + Policies + Middleware  |
| File Uploads        | Laravel Storage (local)        |
| SEO Optimization    | Canonical, Meta tags, Title    |
| Notifications       | Laravel Notifications          |
| Laravel Socialite   | Laravel Socialite          |

---

## 🧠 Advanced Features

### ✅ Authorization System
- Uses roles and permissions stored in the database (JSON field).
- Supports both `User` and `Admin` models.
- Guards setup in `config/auth.php`.
- Policies and Middleware used to restrict access.
- Dynamic menu and route protection based on role.

### ✅ Admin OTP Authentication
- Custom login for Admins using **One Time Password (OTP)**.
- OTP structure:
  - `identifier` (e.g., email or phone)
  - `code` (verification code)
  - `token` (temporary session token)
- OTP expiration and validation handled in middleware.
- Prevents brute force and ensures high-level security.

### ✅ Notification System

#### 📧 Mail Notifications
- Laravel Mail used to send:
  - Admin-to-User messages.
  - User Contact/Support forms.
- Markdown-based mails using:  
  ```bash
  php artisan make:mail ContactMessageMail --markdown=mail.contact.message



## To Use 
1. meilisearch -> Run It 
2. Redis-server -> Run It
3. Pusher
4. Laravel Socilalite 

