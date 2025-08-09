<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'color',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['user_id'] ?? false, function ($query, $user_id) {
            return $query->where('user_id', $user_id);
        });
        $query->when($filters['name'] ?? false, function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        });
        $query->when($filters['color'] ?? false, function ($query, $color) {
            return $query->where('color', $color);
        });
        return $query;
    }

    /**
     * Get the user that owns the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the transactions for the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
