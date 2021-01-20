<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Task extends Model
{
    // use HasFactory;
    public function todos()
    {
        return $this->hasMany('App\Models\Todo');
    }
}
