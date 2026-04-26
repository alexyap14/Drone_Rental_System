<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $table = 'contact_messages';

    // Disable timestamps because the table has no updated_at column

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
    ];
}