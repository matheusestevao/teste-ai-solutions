<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Category extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name'
    ];

    protected static function booted()
	{
	    static::creating(
            fn(Category $model) => $model->id = (string) Uuid::uuid4()
        );
	}
}
