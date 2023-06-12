<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'invoice_date', 'invoice_number'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
