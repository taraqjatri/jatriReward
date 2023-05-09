<?php

namespace App\Models\B2CService;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $connection = 'mysql'; //b2c_service, default => mysql

    public function __construct() {
        $this->connection = config('database.b2c_service');
    }
}
