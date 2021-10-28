<?php


use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(User::where('email','admin@gmail.com')->first()== null){
            $user = new User();
            $user->name = 'admin';
            $user->role = 'admin';
            $user->email = 'admin@gmail.com';
            $user->password = Hash::make('12345678') ;
            $user->save();

            $user = new User();
            $user->name = 'Test';
            $user->email = 'user@gmail.com';
            $user->role = 'user';
            $user->password = Hash::make('12345678') ;
            $user->save();
        }


    }
}
