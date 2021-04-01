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
        $q = "INSERT INTO OlAccounts(AccSerial ,`Name` ,Email ,`Password`) VALUES($user->id , $user->name , $user->email , $user->password)";
        $phone = Phone::create($phoneRecord);
        $q = "INSERT INTO OlPhones(PhSerial,AccSerial ,`Phone`) VALUES($phone->id , $phone->AccSerial , $phone->phone)";
    }
}
