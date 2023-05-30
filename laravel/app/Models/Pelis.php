<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelis extends Model
{
    use HasFactory;
    protected $table = 'pelis';
    protected $fillable = [
        'url',
        'id_peliserie'
    ];
}
