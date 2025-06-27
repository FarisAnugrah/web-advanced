<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    use HasFactory;

    // Izinkan semua field untuk diisi secara massal (mass assignable)
    protected $guarded = [];

    /**
     * Mendefinisikan relasi "One-to-Many": Satu Tutorial memiliki banyak Detail.
     */
    public function details()
    {
        // Secara otomatis urutkan detail berdasarkan kolom 'sort_order'
        return $this->hasMany(TutorialDetail::class)->orderBy('sort_order', 'asc');
    }
}
