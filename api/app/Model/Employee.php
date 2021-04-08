<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Employee
 * @package App\Model
 */
class Employee extends Model
{
    protected $fillable = [
        'name', 'email', 'address', 'salary', 'phone', 'photo', 'nid', 'join_at'
    ];
}
