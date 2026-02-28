# Unit-Us

## Overview

Unit-Us is a modern HR SaaS platform designed to help companies manage their Corporate Social Responsibility (CSR) initiatives. The platform enables HR administrators to create volunteer events, invite employees, and track participation while driving engagement through a gamified rewards system.

## Key Features

### For HR Administrators
- **Employee Management**: Create and manage employee accounts with automated email invitations
- **Event Management**: Create, update, and manage volunteer events
- **Attendance Tracking**: Monitor and manage employee participation in events
- **Rewards System**: Create and manage rewards that employees can redeem with earned points
- **Points Management**: Manually adjust employee point balances
- **Redemption History**: Track all reward redemptions across the organization

### For Employees
- **Event Discovery**: Browse upcoming volunteer opportunities
- **Event Registration**: Register for events and track participation history
- **Points System**: Earn points by participating in volunteer events
- **Rewards Catalog**: Browse available rewards and redeem points
- **Leaderboard**: View company-wide participation rankings
- **Points History**: Track all point transactions

## Technical Architecture

### Multi-Tenant Database Architecture
Unit-Us implements a **rigorous multi-database tenancy architecture** to ensure complete data isolation between client companies:

- **Central Database**: Stores user accounts, company information, and authentication data
- **Tenant Databases**: Each company has a dedicated database for their operational data (profiles, events, rewards, points)
- **Dynamic Database Switching**: Middleware automatically switches database connections based on tenant slug

### Technology Stack

**Backend:**
- Laravel 11 (PHP 8.2+)
- MySQL (Multi-database architecture)
- Laravel Sanctum for API tokens


**Email:**
- Gmail SMTP integration
- Customized email templates
- Automated welcome emails with password setup links

### Security Features
- Token-based authentication with Sanctum
- Role-based access control (Admin/Employee)
- Tenant isolation middleware
- Secure password reset flow


## API Documentation

### Authentication

**Register Company**
```http
POST /api/register
Content-Type: application/json

{
  "company_name": "Tesla",
  "slug": "tesla",
  "email": "admin@tesla.com",
  "fullname": "Admin User",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Login**
```http
POST /api/{slug}/login
Content-Type: application/json

{
  "email": "admin@tesla.com",
  "password": "password123"
}
```

**Refresh Token**
```http
POST /api/{slug}/refresh
Authorization: Bearer {access_token}
```

### Employee Management (Admin Only)

**List Employees (Paginated)**
```http
GET /api/{slug}/admin/employees
Authorization: Bearer {access_token}
```

**Create Employee**
```http
POST /api/{slug}/admin/employees
Authorization: Bearer {access_token}
Content-Type: application/json

{
  "email": "employee@company.com",
  "fullname": "John Doe"
}
```

### Event Management

**Create Event (Admin)**
```http
POST /api/{slug}/admin/events
Authorization: Bearer {access_token}
Content-Type: application/json

{
  "title": "Beach Cleanup",
  "description": "Help clean the local beach",
  "location": "Santa Monica Beach",
  "event_date": "2024-03-15",
  "points_reward": 50
}
```

**Register for Event (Employee)**
```http
POST /api/{slug}/events/{eventId}/register
Authorization: Bearer {access_token}
```

### Rewards

**List Available Rewards**
```http
GET /api/{slug}/rewards
Authorization: Bearer {access_token}
```

**Purchase Reward**
```http
POST /api/{slug}/rewards/{rewardId}/purchase
Authorization: Bearer {access_token}
```

## User Flows

### New Employee Onboarding
1. Admin creates employee account via API
2. System sends automated welcome email with temporary password
3. Employee clicks link in email to set new password
4. Employee logs in and can start participating in events

### Event Participation
1. Employee browses upcoming events
2. Employee registers for an event
3. Admin marks attendance after event completion
4. Points are automatically credited to employee's account
5. Employee can redeem points for rewards

## Project Structure

```
unit-us/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # API controllers
│   │   ├── Middleware/      # Tenant identification
│   │   └── Requests/        # Form validation
│   ├── Livewire/           # Livewire components
│   ├── Models/             # Eloquent models
│   ├── Notifications/      # Email notifications
│   └── Services/           # Business logic
├── database/
│   └── migrations/         # Database migrations
├── resources/
│   └── views/              # Blade templates
└── routes/
    ├── api.php             # API routes
    └── web.php             # Web routes
```

## Contributing

This is a personal project currently under active development. Contributions, issues, and feature requests are welcome!

## License

This project is open-source and available under the MIT License.

## Contact

farajiomar99@gmail.com

---

**Status**: Active Development 🚀
