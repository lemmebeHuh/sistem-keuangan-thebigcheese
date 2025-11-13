<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Menentukan kolom mana saja yang boleh diisi secara massal
    protected $fillable = ['user_id', 'category_id', 'amount', 'description', 'transaction_date'];

    /**
     * Mendefinisikan relasi many-to-one ke model User.
     * Satu transaksi dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'transaction_date' => 'datetime',
    ];
    /**
     * Mendefinisikan relasi many-to-one ke model Category.
     * Satu transaksi termasuk dalam satu kategori.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}