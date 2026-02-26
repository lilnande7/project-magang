<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class News extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'is_featured',
        'published_at',
        'author_id',
        'tags',
        'views_count'
    ];
    
    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'tags' => 'array',
        'views_count' => 'integer',
    ];
    
    // Relationships
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }
    
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
    
    public function scopeRecent($query, $limit = 5)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }
    
    // Mutators & Accessors
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
    
    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        // Auto-generate excerpt from content if not set
        return Str::limit(strip_tags($this->content), 150);
    }
    
    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200); // Average reading speed: 200 words per minute
        
        return $minutes . ' menit baca';
    }
    
    // Helper methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }
    
    public function isPublished()
    {
        return $this->status === 'published' && $this->published_at <= now();
    }
    
    public function publishNow()
    {
        $this->update([
            'status' => 'published',
            'published_at' => now()
        ]);
    }
}
