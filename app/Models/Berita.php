<?php

// app/Models/Berita.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['judul', 'slug', 'konten', 'gambar', 'published_at'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}

