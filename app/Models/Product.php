<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_id',
        'name',
        'image',
        'description',
        'price',
        'quantity',
    ];
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function orders(){
        return $this->belongsToMany(Order::class,'order_details','order_id','product_id')->withPivot('quantity','price');
    }
}
