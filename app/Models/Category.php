<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Menentukan kolom mana saja yang boleh diisi secara massal
    protected $fillable = ['name', 'type'];

    /**
     * Mendefinisikan relasi one-to-many ke model Transaction.
     * Satu kategori bisa memiliki banyak transaksi.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}