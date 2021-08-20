<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Vacancy extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'amount',
        'company_id',
        'salary'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (!isset( $this->attributes['created_by_user'])){
            $this->attributes['created_by_user'] = Auth::user() ? Auth::user()->id : 2;
        }
//        $this->attributes['created_by_user'] = Auth::user()->id;
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_user');
    }

    public function userThatBooked(){
        return $this->belongsToMany(User::class, 'vacancies_booked_by_users');
    }
}
