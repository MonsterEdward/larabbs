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
        $this->call(UsersTableSeeder::class);
		// $this->call(ReplysTableSeeder::class); // 草, 这个顺序为什么看不出来? 为什么会先把Reply table先填充?!
        $this->call(TopicsTableSeeder::class);
        $this->call(ReplysTableSeeder::class);
    }
}
