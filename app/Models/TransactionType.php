<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    use HasFactory;

    protected $table = 'transaction_types';

    protected $fillable = [
        'id',
        'name',
        'type',
        'created_at',
        'updated_at'
    ];

    /**
     * Get all of the transaction for the TransactionType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
