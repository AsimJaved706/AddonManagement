<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addons extends Model
{
    use HasFactory;
    protected $fillable = [
            'user_id',
            'addon_name',
            'file_name',
            'file_path',
            'comments',
            'status',
            'action'
    ];
}
