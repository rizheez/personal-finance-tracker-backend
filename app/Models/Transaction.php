<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'amount',
        'description',
        'date',
        'type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'amout' => 'decimal:2',
        'date' => 'date',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['user_id'] ?? false, function ($query, $user_id) {
            return $query->where('user_id', $user_id);
        });
        $query->when($filters['name'] ?? false, function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        });

        $query->when($filters['category_id'] ?? false, fn($q, $v) => $q->where('category_id', $v));
        $query->when($filters['type'] ?? false, fn($q, $v) => $q->where('type', $v));
        $query->when($filters['date'] ?? false, fn($q, $v) => $q->whereDate('date', $v));


        return $query;
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }

    /**
     * Get the category that owns the transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope to filter transactions by type.
     *
     * @return string
     */

    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }
}
