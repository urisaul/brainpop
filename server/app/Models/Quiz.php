<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // relationships
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function userActivities()
    {
        return $this->hasMany(UserActivity::class);
    }
}
