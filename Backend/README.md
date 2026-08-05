<p align="center">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="260" alt="Laravel Logo">
</p>

<div align="center">

# ⚙️ NextStep AI — Backend

### الخادم الخلفي (API) لمنصة NextStep AI للإرشاد الأكاديمي والمهني بالذكاء الاصطناعي

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-4169E1?logo=postgresql&logoColor=white)](#)
[![Status](https://img.shields.io/badge/Status-Pilot%20Phase-orange)](#)

</div>

---

## 📌 عن هذا المجلد

هذا المجلد يحتوي على **الخادم الخلفي (Backend API)** لمنصة **NextStep AI**، المبني باستخدام **Laravel**، وهو المسؤول عن:

- 🔐 **المصادقة وإدارة الحسابات** — تسجيل الطلاب، الجامعات، والمشرفين
- 🎓 **إدارة بيانات الطلاب** — الملف الشخصي، نتائج AI Assessment
- 🏛️ **إدارة الجامعات والتخصصات** — الكليات، الأقسام، الخطط الدراسية
- 🔗 **الربط مع خدمة الذكاء الاصطناعي (FastAPI)** — تمرير بيانات الاستبيان واستقبال التوصيات
- 📊 **لوحة الإدارة (Admin System)** — إدارة المحتوى والتحكم الكامل بالنظام

> يُستخدم Laravel كـ API خلفي (Headless) يخدم الواجهة الأمامية (Next.js)، بينما تُفصل خدمات الذكاء الاصطناعي في خدمة مستقلة (Python FastAPI) — راجع [الوثيقة الرئيسية للمشروع](../README.md) للتفاصيل الكاملة.

---

## 🛠️ التقنيات المستخدمة

| التقنية | الاستخدام |
|---|---|
| **Laravel** | إطار عمل الـ API الخلفي |
| **PostgreSQL** | قاعدة البيانات الرئيسية |
| **Laravel Sanctum / Passport** | مصادقة الـ API |
| **Python FastAPI** *(خدمة منفصلة)* | محرك التوصية والمساعد الأكاديمي (AI) |
| **Railway / Render** | استضافة ونشر الخادم |

---

## 📂 المكونات الأساسية (Modules)

```
Backend/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/              # تسجيل الدخول وإنشاء الحساب
│   │   ├── StudentController.php
│   │   ├── UniversityController.php
│   │   ├── MajorController.php        # التخصصات
│   │   ├── AssessmentController.php   # ربط نتائج الاستبيان بالـ AI Service
│   │   ├── RecommendationController.php
│   │   └── AdminController.php
│   ├── Models/
│   │   ├── Student.php
│   │   ├── University.php
│   │   ├── Major.php
│   │   └── Recommendation.php
│   └── Services/
│       └── AiServiceClient.php        # الاتصال بخدمة FastAPI
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   └── api.php
├── .env.example
└── README.md
```

> ⚠️ عدّل هذا القسم ليطابق الهيكلية الفعلية داخل مجلد `Backend/` في حال اختلفت.

---

## 🚀 التشغيل محليًا

### المتطلبات الأساسية

- PHP 8.2+
- Composer
- PostgreSQL
- Node.js (لبناء الأصول إن وُجدت)

### خطوات التثبيت

```bash
# 1. الانتقال إلى مجلد الباكند
cd Backend

# 2. تثبيت الحزم
composer install

# 3. إعداد ملف البيئة
cp .env.example .env
php artisan key:generate

# 4. إعداد قاعدة البيانات في .env ثم تشغيل الهجرات
php artisan migrate --seed

# 5. تشغيل الخادم محليًا
php artisan serve
```

الخادم سيعمل افتراضيًا على:
```
http://localhost:8000
```

---

## 🔑 متغيرات البيئة الأساسية

```env
APP_NAME="NextStep AI"
APP_ENV=local
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nextstep_ai
DB_USERNAME=postgres
DB_PASSWORD=

AI_SERVICE_URL=http://localhost:8001
```

---

## 🔗 الربط مع باقي أجزاء المشروع

| الخدمة | الوصف |
|---|---|
| **Frontend (Next.js)** | يستهلك الـ API عبر REST endpoints |
| **AI Service (FastAPI)** | يستقبل بيانات الاستبيان ويُعيد التوصيات ونتائج محرك الـ Weighted Matching |
| **Database (PostgreSQL)** | تخزين الطلاب، الجامعات، التخصصات، والتوصيات |

---

## 👥 المسؤولون عن هذا الجزء

| الاسم | الدور |
|---|---|
| **عمر حمدي** | Backend Engineer |
| **عيد أبو بيض** | CTO / AI Engineer |
| **نداء المدهون** | Information Security / Full Stack Developer |

---

## 🔒 الأمان

- جميع نقاط الوصول الحساسة محمية عبر مصادقة Token-based (Sanctum/Passport).
- بيانات الطلاب والجامعات تُخزّن في قاعدة بيانات مُدارة مع نسخ احتياطي تلقائي.
- في حال اكتشاف ثغرة أمنية، الرجاء التواصل المباشر مع فريق المشروع قبل الإفصاح العلني.

---

<div align="center">

جزء من مشروع **[NextStep AI](../README.md)** — راجع الوثيقة الرئيسية للمشروع لمزيد من التفاصيل حول الرؤية، النموذج، وخارطة الطريق.

</div>
