<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_number',
        'user_id',
        'service_id',
        'booking_date',
        'booking_time',
        'photo_session_completed_at',
        'customer_name',
        'customer_phone',
        'customer_email',
        'notes',
        'location_address',
        'latitude',
        'longitude',
        'total_price',
        'payment_type',
        'dp_amount',
        'remaining_amount',
        'final_payment_deadline',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'booking_time' => 'datetime:H:i',
            'total_price' => 'decimal:2',
            'dp_amount' => 'decimal:2',
            'remaining_amount' => 'decimal:2',
            'photo_session_completed_at' => 'datetime',
            'final_payment_deadline' => 'datetime',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Helper methods
    public function getFormattedTotalPriceAttribute()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => 'Unknown'
        };
    }
    
    public function getPaymentTypeLabelAttribute()
    {
        return match($this->payment_type) {
            'full' => 'Pembayaran Penuh',
            'dp' => 'Down Payment (DP)',
            default => 'Unknown'
        };
    }
    
    public function getFormattedDpAmountAttribute()
    {
        return $this->dp_amount ? 'Rp ' . number_format($this->dp_amount, 0, ',', '.') : null;
    }
    
    public function getFormattedRemainingAmountAttribute()
    {
        return $this->remaining_amount ? 'Rp ' . number_format($this->remaining_amount, 0, ',', '.') : null;
    }
    
    public function getDpPaymentAttribute()
    {
        return $this->payments()->where('amount', $this->dp_amount)->first();
    }
    
    public function getFinalPaymentAttribute()
    {
        return $this->payments()->where('amount', $this->remaining_amount)->first();
    }
    
    public function getIsPaymentOverdueAttribute()
    {
        if (!$this->final_payment_deadline || $this->payment_type !== 'dp') {
            return false;
        }
        
        return now()->isAfter($this->final_payment_deadline) && 
               (!$this->final_payment || $this->final_payment->verification_status !== 'verified');
    }
    
    public function getDaysUntilPaymentDeadlineAttribute()
    {
        if (!$this->final_payment_deadline) {
            return null;
        }
        
        return now()->diffInDays($this->final_payment_deadline, false);
    }

    // Boot method for auto-generating booking number
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            $booking->booking_number = 'BK' . date('Ymd') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        });
    }
}
