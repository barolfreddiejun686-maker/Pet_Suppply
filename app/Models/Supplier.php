<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{

    protected $fillable = ['name', 'contact_person', 'email', 'phone', 'address'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
