<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('users')->insert([
        //   $user=User::create([
            'name' => 'admin',
            'username' => 'admin',
            'phone' => '0101001001',
            'job' => 1,
            'active'=>1,
            'email' => 'admin@admin.com ',
            'password' => Hash::make(123),
            'clinic_id' => 1,
         ]);
         $user=User::where('job',1)->first();
    //   $user->syncPermissions(['user-list','user-create','user-show','user-delete','user-edit']);


       $role = Role::create(['name' => 'Admin']);
    //   $permissions = Permission::pluck('id','id')->all();
      $role->syncPermissions(['user-list','user-create','user-show','user-delete','user-edit','role-list','role-show','role-create','role-edit','role-delete']);
      $user->assignRole([$role->id]);

    }
}
