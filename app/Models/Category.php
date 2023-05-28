<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Jika nama table tidak plurel harus di inisialisasi
// protected $table = 'books';

// Jika nama primaryKey bukan id harus di inisialisasi
// protected $primaryKey = 'book_id';

// Jika primaryKey bukan auto Increment harus di inisialisasi
// public $incrementing = false;

// Jika primaryKey bukan integer harus di inisialisasi
// protected $keyType = 'string';

// Jika nama table tidak sama dengan nama file
//    protected $table = "class";
class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['category_name'];
    protected $dateFormat = 'Y-m-d H:i:s';

    public function books()
    {
        return $this->hasMany(Book::class, 'cate_id', 'id');
    }

    // Mengubah Format Date
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
