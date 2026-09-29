<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'footer_description',
        'whatsapp_url',
        'instagram_url',
    ];

    /**
     * @return array<string, string>
     */
    public static function defaults(): array
    {
        return [
            'site_name' => 'FynePromos',
            'footer_description' => 'Ofertas de tecnologia selecionadas para você encontrar boas oportunidades sem perder tempo.',
            'whatsapp_url' => '#',
            'instagram_url' => '#',
        ];
    }
}
