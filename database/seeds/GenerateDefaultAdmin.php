<?php

use Illuminate\Database\Seeder;
use App\User;

class GenerateDefaultAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();

            $defaultUser = User::where('firstname', '=', 'admin')->first();

            if ($defaultUser) {
                $defaultUser->delete();
            }

            $defaultUserData = [
                'firstname' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456'),
	            'role'   => config('user.role.admin')
            ];

            User::insert($defaultUserData);
            DB::commit();
            echo "Seeding user data has done.\n";
        }
        catch (\ Exception $e) {
            echo "Seeding Company data has fail.\n";
            DB::rollback();
            die($e->getMessage());
            return false;
        }
    }
}
