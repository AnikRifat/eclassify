<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class InstallationSeeder extends Seeder
{
    public function run()
    {
        Role::updateOrCreate(['name' => 'User']);
        Role::updateOrCreate(['name' => 'Super Admin']);

        $user = User::updateOrCreate(['id' => 1], [
            'id'       => 1,
            'name'     => 'admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
        $user->syncRoles('Super Admin');
        Language::updateOrInsert(
            ['id' => 1],
            [
                'name'            => 'English',
                'name_in_english' => 'English',
                'code'            => 'en',
                'panel_file'      => 'en.json',
                'app_file'        => 'en_app.json',
                'web_file'        => 'en_web.json',
                'image'           => 'language/en.svg'
            ]
        );
        Setting::upsert(config('constants.DEFAULT_SETTINGS'), ['name'], ['value', 'type']);
    }
}
