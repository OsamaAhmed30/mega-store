<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // timestamps column will be created time
        User::create([
            'name' => "osama Ahmed",
            'email'=>"osama.omar@guc.edu.eg",
            'password'=>Hash::make("Aa123456"),
            'phone_number'=>'01112223336',
            'type'=> 'super-admin'
            
         ]);
        // timestamps column will be null
        // DB::table('admins')->insert([
        //     'name' => "Osama Ahmed",
        //     'username'=>"Osama.Ahmed21",
        //     'email'=>"osama.ao2026@gmail.com",
        //     'password'=>Hash::make("Aa123456"),
        //     'phone_number'=>'01112223336',
        //     'created_at'=>Carbon::now()
           
        // ]);
    }
}
