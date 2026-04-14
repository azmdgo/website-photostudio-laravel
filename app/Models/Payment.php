<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_number',
        'booking_id',
        'amount',
        'payment_method',
        'status',
        'verification_status',
        'payment_proof',
        'paid_at',
        'verified_at',
        'verified_by',
        'verification_notes',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Helper methods
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Dibayar',
            'failed' => 'Gagal',
            'refunded' => 'Dikembalikan',
            default => 'Unknown'
        };
    }
    
    public function getVerificationStatusLabelAttribute()
    {
        return match($this->verification_status) {
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            default => 'Unknown'
        };
    }

    // Boot method for auto-generating payment number
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($payment) {
            $payment->payment_number = 'PAY' . date('Ymd') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        });
    }
}
