<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Admin>
 */
class AdminFactory extends Factory
{
    protected $model = Admin::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'Taraq Rahman',
            'email' => 'taraq.jatri@gmail.com',
            'password' => '$2y$10$uf0foq2LVSHeEmnXfEtH6.T60GgIx6XDh2xJFDenOUyizb2aC6G1S', // 12345678
            'phone' => '123453323',
            'designation' => 'developer',
            'status' => '1',
            'roles' => '[1,2,3,4,5]',
            'admin_type' => 'SYSTEM_ADMIN'
        ];
    }
}
