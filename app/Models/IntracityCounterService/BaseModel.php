<?php

namespace App\Models\IntracityCounterService;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $connection = 'mysql'; //mysql_intracity_counter_service, default => mysql

    public function __construct() {
        $this->connection = config('database.intractiy_counter_service');
    }
}
