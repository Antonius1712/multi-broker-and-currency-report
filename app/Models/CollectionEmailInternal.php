<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionEmailInternal extends Model
{
    use HasFactory;

    protected $table = 'collection_email_internal';

    protected $fillable = [
        'email',
    ];
}
