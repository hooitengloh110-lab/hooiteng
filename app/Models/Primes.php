<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Primes extends Model
{
    protected $table = 'primes';
    protected $dates = ['created_at','updated_at','deleted_at'];
    protected $fillable = ['value', 'result'];

    public function getResultAttribute($result) {
        if($result) {
            $result = json_decode($result, true);
        }
        return $result;
    }
}
