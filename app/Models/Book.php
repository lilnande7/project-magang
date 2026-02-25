<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'author', 
        'isbn',
        'publisher',
        'year',
        'pages',
        'language',
        'description',
        'location',
        'status',
        'category_id',
        'cover_image',
        'subjects',
        'stock'
    ];
    
    protected $casts = [
        'year' => 'integer',
        'pages' => 'integer',
        'stock' => 'integer',
    ];
    
    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
    
    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
    
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
    
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%")
              ->orWhere('subjects', 'like', "%{$search}%");
        });
    }
}
