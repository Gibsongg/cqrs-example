<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
           [
               'id'         => '00000000-0000-0000-0000-000000000001',
               'email'      => 'user1@mail.ru',
               'password'   => '$2y$10$LOA9mRsjKr2R9ZHojaDShOuCj6qyYtWWFWCWEQNpsRep9emZlXmo.',
               'status'     => '2',
               'created_at' => '2021-08-06 16:39:52',
               'updated_at' => '2021-08-06 16:39:52',
           ],
           [
               'id'         => '00000000-0000-0000-0000-000000000002',
               'email'      => 'user2@mail.ru',
               'password'   => '$2y$10$LOA9mRsjKr2R9ZHojaDShOuCj6qyYtWWFWCWEQNpsRep9emZlXmo.',
               'status'     => '2',
               'created_at' => '2021-08-06 16:39:52',
               'updated_at' => '2021-08-06 16:39:52',
           ],
        ]);

        DB::table('followers')->insert([
           'owner_id'    => '00000000-0000-0000-0000-000000000002',
           'follower_id' => '00000000-0000-0000-0000-000000000001'
        ]);
    }
}
