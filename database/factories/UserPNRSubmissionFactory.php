<?php

namespace Database\Factories;

use App\Constants\SellerType;
use App\Enum\ProductListEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPNRSubmission>
 */
class UserPNRSubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status_of_pnr = fake()->randomElement(['VALID','INVALID']);
        $product = fake()->randomElement(array_column(ProductListEnum::cases(),'name'));
        $seller_type = fake()->randomElement(array_column(SellerType::all(),'name'));
        $random_existing_user = DB::connection(config('database.b2c_service'))->table('users')
            ->select('id')
            ->inRandomOrder()
            ->first();
        $common_attributes = [
            'pnr' =>  fake()->creditCardNumber(),
            'user_id' => $random_existing_user->id,
            'status' =>  $status_of_pnr
        ];
        if($status_of_pnr == 'VALID')
        {
            $valid_attributes = [
                'user_name' =>  fake()->userName(),
                'user_mobile' =>  fake()->phoneNumber(),
                'product' =>  $product,
                'from_stoppage' =>  fake()->word(),
                'to_stoppage' =>  fake()->word(),
                'amount' =>   fake()->numberBetween(2,60),
                'company_id' =>  fake()->randomNumber(5, false),
                'company_name' =>  fake()->word(),
                'seller_id' =>  fake()->randomDigitNotZero(),
                'seller_name' =>  fake()->userName(),
                'seller_mobile' =>  fake()->phoneNumber(),
                'seller_type' =>  $seller_type,
                'user_point' =>  fake()->numberBetween(5,20),
                'seller_point' =>  fake()->numberBetween(5,20),
                'journey_date' =>  fake()->creditCardExpirationDate(),
                'vehicle_no' =>  fake()->randomAscii(),
                'serial' =>  fake()->randomNumber(),
                'created_at' => fake()->dateTimeThisMonth(),
            ];
            $common_attributes = array_merge($common_attributes, $valid_attributes);
        }
        return $common_attributes;
    }
}
