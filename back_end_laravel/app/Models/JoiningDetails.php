<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoiningDetails extends Model
{
    use HasFactory;
    protected $table = 'joining_details';
    protected $fillable = [
        'id_user',
        'id_server',
        'role',
    ];
}
