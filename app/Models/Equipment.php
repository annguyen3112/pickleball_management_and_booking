<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price'];

    public function createdAt()
    {
        return $this->created_at->diffForHumans();
    }

    public function updatedAt()
    {
        return $this->updated_at->diffForHumans();
    }

    public function price()
    {
        return printMoney($this->price);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_equipment', 'equipment_id', 'order_id')->withPivot(['price', 'quantity'])
        ->withTimestamps();
    }    

    public function countOrderSuccess()
    {
        return $this->orders->where('status','>=' , OrderStatusEnum::Finish)->count();
    }
}
