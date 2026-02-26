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
        ];
    }
    
    // Relationships
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
    
    public function activeBorrowings()
    {
        return $this->hasMany(Borrowing::class)->where('status', 'active');
    }
    
    public function overdueBorrowings()
    {
        return $this->hasMany(Borrowing::class)->where('status', 'active')
                    ->where('due_date', '<', now());
    }
    
    // Role & Permission relationships
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }
    
    // Helper methods for roles & permissions
    public function hasRole($roles): bool
    {
        // If single role passed as string
        if (is_string($roles)) {
            return $this->roles->contains('slug', $roles);
        }
        
        // If array of roles passed
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->roles->contains('slug', $role)) {
                    return true;
                }
            }
            return false;
        }
        
        // If Role model instance passed
        return $this->roles->contains($roles);
    }
    
    public function hasPermission($permission): bool
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }
        
        return false;
    }
    
    public function assignRole($role): void
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->first();
        }
        
        if ($role && !$this->hasRole($role)) {
            $this->roles()->attach($role->id);
        }
    }
    
    public function isAdmin(): bool
    {
        return $this->hasRole('admin') || $this->hasRole('super-admin');
    }
    
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }
}
