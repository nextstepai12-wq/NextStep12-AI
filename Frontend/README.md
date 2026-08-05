<div align="center">

# 🎨 NextStep AI — Frontend

### الواجهة الأمامية لمنصة NextStep AI للإرشاد الأكاديمي والمهني بالذكاء الاصطناعي

[![Next.js](https://img.shields.io/badge/Next.js-000000?logo=next.js&logoColor=white)](#)
[![React](https://img.shields.io/badge/React-20232A?logo=react&logoColor=61DAFB)](#)
[![Status](https://img.shields.io/badge/Status-Pilot%20Phase-orange)](#)

</div>

---

## 📌 عن هذا المجلد

هذا المجلد يحتوي على **الواجهة الأمامية (Frontend)** لمنصة **NextStep AI**، المسؤولة عن تجربة المستخدم الخاصة بـ:

- 🎓 **الطالب** — التسجيل، الملف الشخصي، اختبار AI Assessment، صفحة التوصيات
- 🏛️ **صفحات الجامعات والتخصصات** — استعراض البرامج والكليات والأقسام
- 🤖 **واجهة المساعد الأكاديمي (AI Advisor)** — محادثة تفاعلية مع الطالب
- 📊 **لوحات تحكم مبسطة** — لإدارة المحتوى (جامعة / إدارة المنصة)

> النسخة الحالية ضمن مرحلة الـ **Pilot** تغطي منصة الويب فقط، على أن يُضاف تطبيق الموبايل (Flutter) في مراحل لاحقة من خارطة الطريق.

---

## 🛠️ التقنيات المستخدمة

| التقنية | الاستخدام |
|---|---|
| **Next.js (React)** | إطار العمل الأساسي للواجهة الأمامية |
| **TypeScript / JavaScript** | لغة البرمجة |
| **Tailwind CSS** *(أو ما يعادلها)* | تنسيق وتصميم الواجهات |
| **Axios / Fetch API** | الاتصال بالـ Backend (Laravel API) و AI Service (FastAPI) |
| **Vercel** | النشر (Deployment) |

---

## 📂 هيكلية المشروع المقترحة

```
Frontend/
├── public/                 # الملفات الثابتة (صور، أيقونات...)
├── src/
│   ├── app/ أو pages/       # صفحات المنصة (Next.js routing)
│   │   ├── auth/            # تسجيل الدخول / إنشاء حساب
│   │   ├── assessment/      # صفحة اختبار AI Assessment
│   │   ├── profile/         # الملف الشخصي للطالب (Student AI Profile)
│   │   ├── recommendations/ # صفحة التوصيات (تخصصات / جامعات)
│   │   ├── universities/    # صفحات الجامعات والتخصصات
│   │   └── advisor/         # واجهة المساعد الأكاديمي (Chat)
│   ├── components/          # مكونات UI قابلة لإعادة الاستخدام
│   ├── services/ أو api/    # طبقة الاتصال بالـ APIs
│   ├── hooks/                # React Hooks مخصصة
│   ├── styles/                # ملفات التنسيق العامة
│   └── types/                 # تعريفات TypeScript
├── .env.example              # نموذج متغيرات البيئة
├── next.config.js
├── package.json
└── README.md
```

> ⚠️ عدّل هذا القسم ليطابق الهيكلية الفعلية داخل مجلد `Frontend/` في حال اختلفت.

---

## 🚀 التشغيل محليًا

### المتطلبات الأساسية

- [Node.js](https://nodejs.org/) v18 أو أحدث
- npm أو yarn أو pnpm

### خطوات التشغيل

```bash
# 1. الانتقال إلى مجلد الواجهة الأمامية
cd Frontend

# 2. تثبيت الحزم
npm install

# 3. إعداد متغيرات البيئة
cp .env.example .env.local

# 4. تشغيل بيئة التطوير
npm run dev
```

بعد التشغيل، افتح المتصفح على:
```
http://localhost:3000
```

---

## 🔑 متغيرات البيئة

أنشئ ملف `.env.local` وأضف المتغيرات التالية (حسب إعداد الباكند لديك):

```env
NEXT_PUBLIC_API_URL=https://api.nextstepai.example.com
NEXT_PUBLIC_AI_SERVICE_URL=https://ai.nextstepai.example.com
NEXT_PUBLIC_APP_ENV=development
```

---

## 📜 الأوامر المتاحة

| الأمر | الوصف |
|---|---|
| `npm run dev` | تشغيل بيئة التطوير المحلية |
| `npm run build` | بناء نسخة الإنتاج (Production Build) |
| `npm run start` | تشغيل نسخة الإنتاج بعد البناء |
| `npm run lint` | فحص جودة الكود |

---

## 🌐 النشر (Deployment)

يتم نشر الواجهة الأمامية عبر **Vercel** بربط مباشر من فرع `main` على GitHub، وهي خطة كافية ومجانية لمرحلة الـ Pilot الحالية.

---

## 🔗 الربط مع باقي أجزاء المشروع

| الخدمة | الوصف |
|---|---|
| **Backend (Laravel API)** | إدارة المستخدمين، الجامعات، التخصصات، والمصادقة |
| **AI Service (FastAPI)** | محرك التوصية (Weighted Matching) والمساعد الأكاديمي (AI Advisor) |
| **Database (PostgreSQL)** | تخزين بيانات الطلاب والجامعات والتخصصات |

---

## 👥 المسؤولون عن هذا الجزء

| الاسم | الدور |
|---|---|
| **مريم تابيل** | Frontend Engineer |
| **نداء المدهون** | Information Security / Full Stack Developer |

---

<div align="center">

جزء من مشروع **[NextStep AI](../README.md)** — راجع الوثيقة الرئيسية للمشروع لمزيد من التفاصيل حول الرؤية، النموذج، وخارطة الطريق.

</div>
