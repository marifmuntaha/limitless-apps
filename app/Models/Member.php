<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'category',
        'name',
        'address',
        'installation',
        'pppoe_user',
        'pppoe_password',
        'note',
        'status'
    ];
    public function users(): object
    {
        return $this->hasOne(
            User::class,
            'id',
            'user'
        );
    }
    public function categories(): object
    {
        return $this->hasOne(
            Category::class,
            'id',
            'category'
        );
    }

    public function invoices(): object
    {
        return $this->hasMany(
            Invoice::class,
            'member',
            'id'
        );
    }

    public function orders(): object
    {
        return $this->hasMany(
            Order::class,
            'member',
            'id'
        );
    }
}
