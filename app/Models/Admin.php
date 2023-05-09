<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as AuthTable;

class Admin extends AuthTable
{
    use HasFactory;

    protected $fillable = [
        'email', 'password', 'roles'
    ];

    protected $connection = 'mysql';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ 'password' ];

    public function line_manager(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'line_manager_id');
    }
}
