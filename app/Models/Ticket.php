<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(TicketCategory::class,'ticket_category_id');
    }

    public function sender()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class);
    }
}
