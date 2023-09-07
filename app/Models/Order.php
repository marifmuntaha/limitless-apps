<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['member', 'product', 'price', 'cycle', 'due', 'status'];

    public function products(): object
    {
        return $this->hasOne(
            Product::class,
            'id',
            'product'
        );
    }

    public function members(): object
    {
        return $this->hasOne(
            Member::class,
            'id',
            'member'
        );
    }
}
