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
        'name',
        'address',
        'installation',
        'note',
        'status'
    ];

    protected function installation(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Carbon::parse($value)->format('Y-m-d'),
            set: fn(string $value) => Carbon::createFromFormat('Y-m-d', $value),
        );
    }

    public function users(): object
    {
        return $this->hasOne(
            User::class,
            'id',
            'user'
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
