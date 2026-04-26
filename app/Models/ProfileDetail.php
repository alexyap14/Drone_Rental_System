<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileDetail extends Model
{
    use HasFactory;

    protected $table = 'profile_details';
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'address',
        'gender',
        'race',
        'religion',
        'date_of_birth',
    ];

    protected $attributes = [
        'full_name' => '',
        'phone' => '',  
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}