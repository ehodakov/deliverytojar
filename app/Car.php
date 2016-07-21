<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    /**
     * @var string
     */
    protected $table = 'cars';

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
