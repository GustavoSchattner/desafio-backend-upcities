<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'name',
        'cpf',
        'birth_date',
        'email',
        'phone_number',
        'address',
        'city',
        'state',
    ];
}
