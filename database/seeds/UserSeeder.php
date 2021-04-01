<?php

use App\Phone;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = ['name' => 'test' , 'email' => 'test@test.com' , 'password' => bcrypt(123456)];
        $phone = '01022052546';
        $user = User::create($user);
        $phoneRecord =  [
            'Phone' =>$phone,
            'AccSerial' =>$user->id,
        ];
        $phone = Phone::create($phoneRecord);
    }
}
