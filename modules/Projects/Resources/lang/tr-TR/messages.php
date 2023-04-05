<?php

return [

    'success' => [
        'added'             => ':type eklendi!',
        'updated'           => ':type güncellendi!',
        'deleted'           => ':type silindi!',
        'duplicated'        => ':type çoğaltıldı!',
        'imported'          => ':type içe aktarıldı!',
        'enabled'           => ':type etkinleştirildi!',
        'disabled'          => ':type devre dışı bırakıldı!',
        'started'           => ':type başlatıldı!',
        'stopped'           => ':type durduruldu!',
    ],

    'error' => [
        'over_payment'      => 'Hata: Ödeme Eklenmedi! Girdiğiniz :amount toplamı geçiyor',
        'not_user_company'  => 'Hata: Bu şirketi yönetme yetkiniz yok!',
        'customer'          => 'Hata: Kullanıcı oluşturulamadı. :name bu e-posta adresini kullanmaktadır.',
        'no_file'           => 'Hata: Dosya seçilmedi!',
        'last_category'     => 'Hata: Son :type kategorisini silemezsiniz!',
        'change_type'       => 'Hata: Tür değiştirilemez çünkü :text ilişki mevcut!',
        'invalid_apikey'    => 'Hata: Girdiğiniz API Anahtarı geçersiz!',
        'import_column'     => 'Hata: :message Sayfa ismi: :sheet. Satır numarası: :line.',
        'import_sheet'      => 'Hata: Sayfa ismi geçersiz. Lütfen, örnek dosyaya bakın.',
        'unknown'           => 'Bilinmeyen hata. Lütfen daha sonra tekrar deneyiniz.',
    ],

    'warning' => [
        'deleted'           => 'Uyarı: <b>:name</b> silinemez çünkü :text ile ilişkilidir.',
        'disabled'          => 'Uyarı: <b>:name</b> devre dışı bırakılamaz çünkü :text ile ilişkilidir.',
        'disable_code'      => 'Uyarı: <b>:name</b> devre dışı bırakılamaz veya kur değiştirilemez çünkü :text ile ilişkilidir.',
        'payment_cancel'    => 'Uyarı: :method ödemesini iptal ettiniz!',
    ],

];
