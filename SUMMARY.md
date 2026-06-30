## Goal
تطوير منصة حجز متعددة الصلاحيات (عميل/موظف/مدير) لصالون مع لوحة إدارة كاملة.

## Constraints & Preferences
- جميع النصوص باللهجة الكويتية ومخاطبة المؤنث، ممنوع أي كلمة إنجليزية
- تسجيل الدخول موحد للجميع (عميل/موظف/مدير) عبر `/login` — النظام يكتشف الـ role تلقائياً
- رقم الجوال كويتي (يبدأ بـ 5/6/9/4)، 8 أرقام، يقبل عربي وإنجليزي
- الإيميل اختياري عند تسجيل العميل، الحجز كزائر بدون حساب متاح دائماً
- واجهة العميل: تصميم وردي/ذهبي | واجهة الإدارة والموظف: تصميم basic محايد
- الأولويات: VIP (أخضر)، عاجل (وردي)، عادي (سليت)
- فلترة الحجوزات حرة بدون فرض تاريخ معين
- VIP التلقائي يتحدد إذا إجمالي السعر ≥ 100 د.ك أو 3+ حجوزات سابقة
- تتبع الحجز: يكفي رقم التذكرة **أو** رقم الهاتف
- شريط جانبي يظهر دايماً بالديسكتوب، يختفي بالجوال مع زر قائمة
- منع الحجوزات المزيفة: Honeypot + Time detection + Throttle + حد 3 حجوزات نشطة لكل رقم
- الوقت (timezone): Asia/Kuwait
- لغة HTML: `ar` والاتجاه `rtl`
- الموظف الجديد ينشأ نشط تلقائياً
- عند اختيار باقة: ما تضاف الخدمات المضمنة كخدمات فردية
- السعر الإجمالي = سعر الباقة + سعر الخدمات الإضافية فقط
- اختيار الموظفة عند الحجز اختياري (في كل صفحات الحجز والتعديل)

## Progress
### Done
- كل ملفات Admin/Employee/Customer — ترجمة كاملة عربي
- تسجيل دخول موحد + واجهة العميل وردي/ذهبي + تأكيد حجز عربي
- صفحة حسابي + حجوزاتي + تفاصيل الحجز + إلغاء + تقييم (عميل)
- تقييم العميل inline في صفحة الحجز نفسه
- `RatingController` — حذف `create()`، ترجمة `store()`، إضافة `guestStore()` للزوار
- `customer/rating.blade.php` — حذف
- إعادة تصميم كل صفحات Admin و Employee و Customer
- `cancel_reason` — مجراشن + حقل في `$fillable` + تخزين + عرض
- صفحة `admin/cancelled/index.blade.php` + route + method
- رابط "ملغيات" في sidebar الأدمن + زر "إعادة حجز"
- إحصائيات الإلغاء (أكثر 5 أسباب) في التقارير
- جداول admin `overflow-x-auto` للتمرير الأفقي
- شريط جانبي responsive لكل layouts
- حساب الموظف منفصل عن العميل (middleware `role:customer`)
- زر التعديل مختفي في show.html للحالات completed/cancelled
- صفحة تأكيد الحجز (`confirmed.blade.php`) — فاتورة مرتبة مع تفاصيل كل خدمة/باقة وسعرها والإجمالي
- `display_priority` accessor — يستخدم في كل views الأدمن والموظف
- منع الحجوزات المزيفة: Honeypot + Time detection + Throttle + حد 3 حجوزات
- إضافة `$casts` لكل الموديلات المناسبة
- تغيير `dir="auto"` → `dir="rtl"` في كل layouts
- تغيير `timezone` إلى `Asia/Kuwait` في `config/app.php`
- إصلاح null phone في BookingController@store
- ترجمة صفحات Auth كاملة
- رابط اللوجو يستخدم `route('home')`
- أرقام واتساب وهاتف وإيميل من `config('app.*')`
- حذف `welcome.blade.php`
- إضافة `contact_email` و `phone` إلى `config/app.php`
- زر التحميل (loading state) في فورم الحجز
- تصنيف الخدمات مع أزرار فلتر
- إنشاء `CleanOldLogs` command + جدولته يومياً
- إصلاح total price (سعر الباقة + خدمات إضافية فقط)
- إضافة ملخص سعر ديناميكي في `book.blade.php`
- تحسين `confirmed.blade.php` و `track-result.blade.php`: يعرض الباقة مع خدماتها + توفير
- إصلاح `update()` في `EmployeeController`: `$request->boolean('is_active')`
- إصلاح `store()` في `EmployeeController`: `is_active = true`
- إصلاح responsive لجوال في كل صفحات الموظف (dashboard, appointments, show, available, ratings)
- ترتيب الحجوزات تلقائياً حسب قرب الموعد في: EmployeeController@appointments, AppointmentController@index و cancelled, CustomerController@appointments
- إشعارات فورية تعمل في كل صفحات الإدارة (وليس فقط dashboard):
  - جرص إشعارات في الهيدر مع badge
  - لوحة منسدلة تظهر الحجوزات الجديدة
  - Polling كل 7 ثواني في `layouts/admin.blade.php`
- حقل اختيار الموظفة في الحجز (اختياري):
  - كل الكونترولرات (BookingController, Admin/AppointmentController) تقبل `employee_id`
  - إذا اختيرت موظفة → الحالة تصير `assigned` + سجل
  - يظهر في: `book.blade.php`، `edit.blade.php`، `guest-edit.blade.php`، `admin/appointments/create.blade.php`
- عند دخول الموظف للموقع الرئيسي للحجز: خانات الاسم ورقم الهاتف تظهر فاضية
- إظهار الموظفة المختارة في صفحات العرض: `customer/show.blade.php`، `confirmed.blade.php`، `track-result.blade.php`
- `Admin/AppointmentController@store` يقبل `employee_id`

### Blocked
- (none)

## Key Decisions
- دمج `/staff/login` مع `/login` الموحد — field detection ذكي
- ألوان الأولوية مختلفة عن ألوان الحالة
- التقييم inline في صفحة الحجز
- `cancel_reason` حقل منفصل في `appointments`
- جدول الحجوزات الملغية كصفحة مستقلة
- تتبع الحجز: يكفي حقل واحد مطابق
- الموظف المسجل ما يشوف "حسابي" — له "لوحة الموظف" فقط
- شريط جانبي يستخدم CSS transform
- `display_priority` يحل محل `priority` في العرض
- التنبيهات اللحظية في الـ layout (تظهر بكل الصفحات)
- اختيار الموظفة عند الحجز: اختياري، إذا اختيرت → الحالة `assigned` + سجل
- الموظف اللي يسوي حجز يشوف خانات فاضية للاسم والهاتف

## Critical Context
- `Appointment.getAutoPriorityAttribute()`: `vip` إذا ≥ 100 د.ك أو ≥ 3 حجوزات سابقة
- `Appointment.getDisplayPriorityAttribute()`: يرجع `vip` إذا auto_priority، وإلا `$this->priority`
- `Appointment.getTotalPriceAttribute()`: يستثني خدمات الباقات من مجموع الخدمات الفردية
- `AppointmentLog` يُنشأ عند اختيار موظفة في الحجز
- `BookingController@store`: يضبط `status = assigned` إذا `employee_id` موجود
- التنبيهات: polling في `layouts/admin.blade.php` كل 7 ثواني
- تحديث dashboard: polling في `admin/dashboard.blade.php` كل 15 ثانية

## Relevant Files
- `app/Http/Controllers/Admin/AppointmentController.php`: `create()` و `store()` يمررون/يقبلون `$employees` و `employee_id`
- `app/Http/Controllers/Customer/BookingController.php`: جميع الدوال تدعم `employee_id`
- `resources/views/customer/book.blade.php`: حقل اختيار الموظفة مع أزرار راديو منسقة
- `resources/views/customer/edit.blade.php`: حقل اختيار الموظفة مع تحديث ديناميكي
- `resources/views/customer/guest-edit.blade.php`: حقل اختيار الموظفة
- `resources/views/customer/show.blade.php`: يعرض الموظفة
- `resources/views/customer/confirmed.blade.php`: يعرض الموظفة
- `resources/views/track-result.blade.php`: يعرض الموظفة
- `resources/views/admin/appointments/create.blade.php`: حقل اختيار الموظفة (select)
- `resources/views/admin/appointments/edit.blade.php`: حقل اختيار الموظفة (select) — موجود مسبقاً
