<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademyInfo extends Model
{
    protected $fillable = [
        'phone',
        'email',
        'address',
        'video_url',
        'about_text',
        'phone2',
        'whatsapp_phone',
        'facebook_url',
        'instagram_url',
        'tiktok_url'
    ];

    public function getFormattedWhatsappPhoneAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->whatsapp_phone ?? '01031224400');
        if (str_starts_with($phone, '0020')) {
            $phone = substr($phone, 2);
        }
        if (str_starts_with($phone, '0')) {
            $phone = '20' . substr($phone, 1);
        }
        if (!str_starts_with($phone, '20') && strlen($phone) === 10) {
            $phone = '20' . $phone;
        }
        return $phone;
    }
}
