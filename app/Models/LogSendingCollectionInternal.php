<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSendingCollectionInternal extends Model
{
    use HasFactory;

    protected $table = 'log_sending_collection_internal';

    protected $fillable = [
        'email',
        'email_sent',
        'email_subject',
        'email_body',
        'year',
        'month',
        'day',
        'time',
    ];
}
