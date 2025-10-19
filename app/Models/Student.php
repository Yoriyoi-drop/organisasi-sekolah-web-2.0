<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'class',
        'address',
    ];

    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_student')->withTimestamps();
    }
}
