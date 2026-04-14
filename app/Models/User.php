<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Helper methods
    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStudioStaff()
    {
        return $this->role === 'studio_staff';
    }

    public function isOwner()
    {
        return $this->role === 'owner';
    }
    
    /**
     * Check if user has admin privileges (admin or owner)
     */
    public function hasAdminAccess()
    {
        return in_array($this->role, ['admin', 'owner']);
    }
    
    /**
     * Get role display name
     */
    public function getRoleDisplayName()
    {
        return match($this->role) {
            'customer' => 'Pelanggan',
            'admin' => 'Admin',
            'studio_staff' => 'Petugas Studio',
            'owner' => 'Pemilik',
            default => 'Unknown'
        };
    }
    
    /**
     * Get role badge class for UI
     */
    public function getRoleBadgeClass()
    {
        return match($this->role) {
            'customer' => 'bg-primary',
            'admin' => 'bg-danger',
            'studio_staff' => 'bg-info',
            'owner' => 'bg-secondary',
            default => 'bg-secondary'
        };
    }
    
    /**
     * Get formatted ID with role prefix
     */
    public function getFormattedId()
    {
        $rolePrefix = match($this->role) {
            'customer' => 'PLG',
            'admin' => 'ADM',
            'studio_staff' => 'PTU',
            'owner' => 'OWN',
            default => 'USR'
        };
        
        return $rolePrefix . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }
    
    /**
     * Scope to get only customers
     */
    public function scopeCustomers($query)
    {
        return $query->where('role', 'customer');
    }
    
    /**
     * Scope to get only admins
     */
    public function scopeAdmins($query)
    {
        return $query->whereIn('role', ['admin', 'owner']);
    }
}
