<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * @var string
     */
    protected $table = 'orders';

    public function car()
    {
        return $this->belongsTo('App\Order');
    }
}
