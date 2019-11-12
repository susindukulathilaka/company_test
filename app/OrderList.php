<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;
use App\orderHeader;

class OrderList extends Model
{
    public function items() {
        return $this->hasMany(Item);
    }

    public function orderHeader() {

        return $this->belongsTo(orderHeader);
    }

}
