<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'id_peliserie',
        'comment',
    ];

    public function commentedBy()
    {
        $user = User::where('id',$this->user_id)->first();
        return $user->name;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}