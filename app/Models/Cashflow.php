<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashflow extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'payment', 'type', 'desc', 'amount', 'method', 'created_at'];

    public function methods(): object
    {
        return $this->hasOne(
            Account::class,
            'id',
            'method'
        );
    }
}
