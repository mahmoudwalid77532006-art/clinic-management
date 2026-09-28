# Features — نظام إدارة عيادة

## 1. Authentication
- Register (للمريض بس)
- Login / Logout

## 2. Users & Roles
- Admin, Doctor, Receptionist, Patient
- الـ Admin هو اللي بيضيف الدكاترة والريسبشن

## 3. Patients Management
- Add / View / Edit / Patient Details
- Delete (Soft Delete)
- الريسبشن يقدر يسجل مريض من غير حساب

## 4. Doctors Management
- Add / View / Edit / Doctor Details
- Delete (Soft Delete)
- تحديد التخصص ومدة الكشف
- الجدول الأسبوعي (أيام وساعات العمل)
- الإجازات والأيام المقفولة

## 5. Services
- خدمات (كشف، استشارة، متابعة) بسعر ومدة
- ربط الخدمات بالدكاترة

## 6. Appointments
- عرض المواعيد الفاضية لدكتور في يوم معين
- Book / View / Edit / Cancel
- منع تعارض المواعيد لنفس الدكتور
- Appointment Status: pending, confirmed, completed, cancelled, no_show
- المريض يلغي قبل الميعاد بـ 24 ساعة كحد أدنى

## 7. Medical Records
- Patient Medical History
- Diagnosis / Notes / Treatment (بيكتبهم الدكتور لكل زيارة)

## 8. Prescriptions
- Create Prescription
- Add Medicines (اسم، جرعة، تكرار، مدة)
- View Prescription

## 9. Notifications
- تأكيد الحجز
- تذكير قبل الميعاد بـ 24 ساعة (Queue + Scheduler)
- إشعار عند الإلغاء

## 10. Dashboard & Reports
- Admin: عدد المرضى والدكاترة، مواعيد النهارده، الدخل، نسبة الإلغاء، أكتر دكتور وخدمة مطلوبة
- Doctor: مواعيد النهارده ومرضاه
- Receptionist: مواعيد اليوم بأزرار التأكيد والإلغاء
- Patient: مواعيده وزياراته

## 11. Search & Filtering
- Search Patients / Search Doctors
- Filter Appointments (بالتاريخ، الدكتور، الحالة)

## 12. Authorization
- Admin: كل حاجة
- Doctor: مواعيده ومرضاه، ويكتب التشخيص والروشتات
- Receptionist: الحجز والتأكيد والإلغاء وتسجيل المرضى، من غير الملف الطبي
- Patient: بياناته ومواعيده وزياراته بس

## أولويات التنفيذ
1. Auth + Roles + Authorization
2. Doctors + Schedules + Services
3. Patients
4. Appointments + منع التعارض
5. Medical Records + Prescriptions
6. Notifications
7. Dashboard + Search
