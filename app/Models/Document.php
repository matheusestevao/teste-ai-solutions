<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Document extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'category_id',
        'exercice',
        'title',
        'contents'
    ];

    protected static function booted()
	{
	    static::creating(
            fn(Document $model) => $model->id = (string) Uuid::uuid4()
        );
	}
}
