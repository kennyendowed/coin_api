<?php

use Illuminate\Database\Seeder;
use App\Models\Transactions;
class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Let's truncate our existing records to start from scratch.
      Transactions::truncate();
    $faker = \Faker\Factory::create();

    // And now, let's create a few articles in our database:
    for ($i = 0; $i < 50; $i++) {
        Transactions::create([
            'customerid' => $faker->randomDigitNotNull,
            'type' => "debit" ?: "credit",
            'amount' =>  $faker->randomDigitNotNull,
            'accountNumber' =>   rand(100,9999),
            'bank' =>  $faker->state,
            'remarks' => $faker->sentence,
        ]);
    }
    }
}
