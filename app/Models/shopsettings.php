<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shopsettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_saupja_no',
        'company_owner',
        'company_tel',
        'company_fax',
        'company_tongsin_no',
        'company_buga_no',
        'company_zip',
        'company_addr',
        'company_info_name',
        'company_info_email',
        'company_bank_use',
        'company_bank_account',
        'company_use_point',
        'shop_img_width',
        'shop_img_height',
    ];

    protected $hidden = [

    ];

    protected $casts = [

    ];
}
