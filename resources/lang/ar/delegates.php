<?php

return [
    'plural' => 'المندوبين',
    'singular' => 'المندوب',
    'empty' => 'لا توجد مندوبين',
    'select' => 'اختر المندوب',
    'permission' => 'ادارة المندوبين',
    'trashed' => 'المندوبين المحذوفين',
    'perPage' => 'عدد النتائج في الصفحة',
    'collect' => 'تحصيل',
    'balance' => 'الرصيد',
    'transactions' => 'المعاملات',
    'actions' => [
        'list' => 'كل المندوبين',
        'show' => 'عرض',
        'create' => 'إضافة',
        'new' => 'إضافة',
        'edit' => 'تعديل  المندوب',
        'delete' => 'حذف المندوب',
        'restore' => 'استعادة',
        'forceDelete' => 'حذف نهائي',
        'save' => 'حفظ',
        'filter' => 'بحث',
    ],
    'messages' => [
        'created' => 'تم إضافة المندوب بنجاح .',
        'updated' => 'تم تعديل المندوب بنجاح .',
        'deleted' => 'تم حذف المندوب بنجاح .',
        'restored' => 'تم استعادة المندوب بنجاح .',
    ],
    'attributes' => [
        'name' => 'اسم المندوب',
        'phone' => 'رقم الهاتف',
        'email' => 'البريد الالكترونى',
        'created_at' => 'تاريخ الإنضمام',
        'old_password' => 'كلمة المرور القديمة',
        'password' => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'type' => 'نوع المستخدم',
        'avatar' => 'الصورة الشخصية',
        'national_id' => 'رقم الهوية',
        'national_front_image' => 'صورة الهوية الامامية',
        'national_back_image' => 'صورة الهوية الخلفية',
        'vehicle_type' => 'نوع المركبة',
        'vehicle_model' => 'موديل المركبة',
        'vehicle_image' => 'صورة المركبة',
        'vehicle_number' => 'رقم المركبة',
        'is_available' => 'متاح',
        'is_approved' => 'مفعل',
        'lat' => 'خط العرض',
        'lng' => 'خط الطول',
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد حذف المندوب ؟',
            'confirm' => 'حذف',
            'cancel' => 'إلغاء',
        ],
        'restore' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد استعادة المندوب ؟',
            'confirm' => 'استعادة',
            'cancel' => 'إلغاء',
        ],
        'forceDelete' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد حذف المندوب نهائياً؟',
            'confirm' => 'حذف نهائي',
            'cancel' => 'إلغاء',
        ],
    ],
];
