<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OrderList;

class orderHeader extends Model
{
    public function OrderList() {

        return $this->hasMany(OrderList);
    }
}
