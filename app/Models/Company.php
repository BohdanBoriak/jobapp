<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'country',
        'city'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (!isset( $this->attributes['created_by'])){
            $this->attributes['created_by'] = Auth::user() ? Auth::user()->id : 2;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class, 'created_by_user');
    }
}
