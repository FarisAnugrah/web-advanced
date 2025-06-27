<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorialDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Mendefinisikan relasi inverse "One-to-Many": Satu Detail dimiliki oleh satu Tutorial.
     */
    public function tutorial()
    {
        return $this->belongsTo(Tutorial::class);
    }
}
