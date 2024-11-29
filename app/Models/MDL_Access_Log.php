<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDL_Access_Log extends Model
{
    use HasFactory;

    protected $table = 'access_log';

    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
}
