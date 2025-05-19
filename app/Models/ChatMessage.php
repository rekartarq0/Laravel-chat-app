<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;
    protected $fillable = ['reciver_id', 'sender_id', 'text'];

    public function reciver(){
        return $this->belongsTo(User::class,'reciver_id');
    }

    public function sender(){
        return $this->belongsTo(User::class,'sender_id');
    }
}
