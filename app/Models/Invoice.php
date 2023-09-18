<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'member',
        'product',
        'desc',
        'price',
        'discount',
        'fees',
        'amount',
        'status',
        'due',
        'note'
    ];
    public function members(): object
    {
        return $this->hasOne(
            Member::class,
            'id',
            'member'
        );
    }
    public function products(): object
    {
        return $this->hasOne(
            Product::class,
            'id',
            'product'
        );
    }
    public function payments(): object
    {
        return $this->hasMany(
            Payment::class,
            'invoice',
            'id'
        );
    }
}
