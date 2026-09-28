# 🏥 عيادة الشفاء — Clinic Management System

نظام متكامل لإدارة العيادات مبني بـ **Laravel**، بواجهة عربية بالكامل (RTL). بيغطي رحلة المريض من الحجز لحد الزيارة والروشتة الإلكترونية.

A full-stack clinic management system built with Laravel, featuring an Arabic RTL interface, role-based access, appointment booking, visits and electronic prescriptions.

## ✨ Features

- **Role-based access:** أدمن / دكتور / مريض، كل دور له صلاحياته وصفحاته
- **Departments & Services:** إدارة الأقسام الطبية والخدمات بأسعارها ومدتها
- **Doctors:** ملف لكل دكتور، مع مواعيد العمل والإجازات
- **Appointments:** حجز وتعديل وإلغاء المواعيد ومتابعة حالتها (قيد الانتظار / مؤكد / مكتمل / ملغي)
- **Visits & Prescriptions:** تسجيل الزيارات وإصدار الروشتات الإلكترونية وحفظ السجل الطبي
- **Patients:** إدارة بيانات المرضى وسجلهم
- **Authentication:** تسجيل دخول وإنشاء حساب
- **Landing page:** صفحة رئيسية بتعرض الأقسام والخدمات والأطباء
- **Responsive design:** بتشتغل على الموبايل والديسكتوب

## 🛠️ Tech Stack

- **Backend:** Laravel, PHP
- **Frontend:** Blade, custom CSS (RTL, Cairo font)
- **Database:** SQLite (قابل للتحويل لـ MySQL)
- **Architecture:** MVC, Form Requests, Middleware, Seeders

## 🚀 Getting Started

```bash
git clone https://github.com/mahmoudwalid77532006-art/clinic-management.git

composer install
cp .env.example .env
php artisan key:generate

php artisan migrate --seed
php artisan serve
```
## 🔑 Demo Accounts

بعد تشغيل `php artisan migrate --seed` تقدر تدخل بأي حساب من دول (الباسورد للكل: `password`):

| Role | Email |
|------|-------|
| Admin | `admin@clinic.test` |
| Doctor | `doctor1@clinic.test` |
| Patient | `patient1@clinic.test` |

## 📂 Project Structure

```
app/
 ├── Http/Controllers/     # Auth, Appointment, Doctor, Patient, Visit, Prescription...
 ├── Http/Middleware/      # Role-based access
 ├── Http/Requests/        # Form validation
 └── Models/               # Eloquent models & relations
database/
 ├── migrations/
 └── seeders/
resources/views/           # Blade templates (RTL)
public/css/clinic.css      # Design system
```

## 👤 Author

**Mahmoud Walid** — Computer Science student & Backend Developer

[LinkedIn](https://www.linkedin.com/in/mahmoud-walidd/) · [Portfolio](https://mahmoudwalid77532006-art.github.io/portofolio/)
