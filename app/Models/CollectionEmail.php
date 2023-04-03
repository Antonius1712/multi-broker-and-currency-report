<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionEmail extends Model
{
    use HasFactory;

    protected $table = 'collection_email';

    protected $fillable = [
        'id_profile',
        'broker_name',
        'pic_on_system',
        'pic_email_on_system',
        'pic_emailed_by_finance',
    ];
}
