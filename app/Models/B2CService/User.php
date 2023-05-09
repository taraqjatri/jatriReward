<?php
namespace App\Models\B2CService;
class User extends BaseModel
{
    protected $table = 'users';
    protected $fillable = ['id', 'phone', 'first_name', 'last_name', 'password', 'address', 'city', 'email', 'gender', 'date_of_birth', 'image', 'balance','tag', 'tracking_active_to_date', 'tracking_status', 'role_id', 'api_token', 'device_token'];
    protected $hidden = ['password', 'api_token'];


}
