# Book Appointment System

A Laravel-based medical appointment booking system that allows patients to schedule appointments with healthcare providers, with dedicated portals for patients, doctors, and administrators.

## Features

### Admin Dashboard
- Comprehensive overview of system metrics
  - Total appointments tracking
  - Registered doctors management
  - Patient registration statistics
  - Review monitoring
- Real-time appointment monitoring
- User management capabilities
- Spam control and user moderation
- Speciality/Department management
- Notification system integration
  - Push notifications for Android & iOS
  - Email notifications
  - Custom notification settings

### Doctor Features
- Profile management
- Appointment scheduling
- Patient history tracking
- Review management
- Online consultation tools
- Schedule management

### Patient Features
- Online appointment booking
- Doctor search and filtering
- Review and rating system
- Medical history access
- Appointment tracking
- Profile management

### Technical Features
- Built with Laravel Framework
- Payment integration via Paytm
- Rich text editing with CKEditor
- Responsive admin dashboard
- FontAwesome icons integration
- Push notification support for Android & iOS

## Installation

1. Clone the repository
```bash
git clone [repository-url]
```
2. Install dependencies:
```bash
composer install
npm install
```
3. Install NPM dependencies:
```bash
npm install
```
4. Configure the environment file:
```bash
cp .env.example .env
php artisan key:generate
```
5. Set up the database:
```bash
php artisan migrate
```
6. Import the database seed (optional):
```bash
php artisan db:seed
```

## System Requirements

- PHP >= 7.4
- MySQL/MariaDB
- Composer
- Node.js & NPM
- Laravel CLI