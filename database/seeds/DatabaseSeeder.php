<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        //Para cada cliente ira criar 20 endereços e atrelar ao mesmo
        factory(\App\Client::class, 10)->create()->each(function ($client) {
            foreach(range(1, 20) as $i) {
                $client->addresses()->save(factory(\App\Address::class)->make());
            }
        });
    }
}
