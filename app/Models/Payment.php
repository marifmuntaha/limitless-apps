<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['invoice', 'amount', 'method', 'at'];

    public function invoices(): object
    {
        return $this->hasOne(
            Invoice::class,
            'id',
            'invoice'
        );
    }
}
