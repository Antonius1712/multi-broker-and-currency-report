<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSendingCollection extends Model
{
    use HasFactory;

    protected $table = 'log_sending_collection';

    protected $fillable = [
        'id_profile',
        'email_sent',
        'email_subject',
        'email_body',
        'year',
        'month',
        'day',
        'time',
    ];

    public function collection_email(){
        return $this->hasOne(CollectionEmail::class, 'id_profile', 'id_profile');
    }
}
