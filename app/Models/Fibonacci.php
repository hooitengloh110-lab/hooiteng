<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fibonacci extends Model
{
    protected $table = 'fibonacci';
    protected $dates = ['created_at','updated_at','deleted_at'];
    protected $fillable = ['value', 'result'];

    public function getRecursiveAttribute($result) {
        if($result) {
            $result = json_decode($result, true);
        }

        return $result;
    }

    public function getIterativeAttribute($result) {
        if($result) {
            $result = json_decode($result, true);
        }
        return $result;
    }
}
