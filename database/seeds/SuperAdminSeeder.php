<?php

use App\Models\HRD\KaryawanModel;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'super_admin')->first();
        $permission = Permission::where('name' , 'super_admin')->first();

        if (!$role && !$permission) {
            $role = Role::create(['name'=> 'super_admin']);
            $permission = Permission::create(['name' =>'super_admin']);

            $role->givePermissionTo($permission);
        }
        $karyawan = KaryawanModel::where('nik', '999999999')->first();

        if (!$karyawan) {
            $karyawan = new KaryawanModel();
            $karyawan->nik = '999999999';
            $karyawan->nm_lengkap = 'Super Admin';
            $karyawan->tmp_lahir = 'Makassar';
            $karyawan->tgl_lahir = '1990-01-01';
            $karyawan->jenkel = 1;

            $karyawan->save();

            $user = new User();
            $user->nik = $karyawan->nik;
            $user->password = Hash::make('password');
            $user->save();
        }

    }
}
