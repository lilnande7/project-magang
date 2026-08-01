<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Borrowing extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'book_id',
        'requested_at',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
        'fine_amount',
        'notes',
        'approved_by',
        'approved_at',
        'rejection_reason',
    ];
    
    protected $casts = [
        'requested_at' => 'date:Y-m-d',
        'borrowed_at'  => 'date:Y-m-d',
        'due_date'     => 'date:Y-m-d',
        'returned_at'  => 'date:Y-m-d',
        'approved_at'  => 'datetime',
        'fine_amount'  => 'decimal:2',
    ];
    
    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    
    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'active')
                    ->where('due_date', '<', now());
    }
    
    // Accessors & Mutators
    public function getIsOverdueAttribute()
    {
        return $this->status === 'active' && $this->due_date < now();
    }
    
    public function getDaysOverdueAttribute()
    {
        if (!$this->is_overdue) {
            return 0;
        }
        
        return now()->diffInDays($this->due_date);
    }
    
    public function calculateFine()
    {
        if (!$this->is_overdue) {
            return 0;
        }
        
        // Denda Rp 1.000 per hari
        return $this->days_overdue * 1000;
    }
}
