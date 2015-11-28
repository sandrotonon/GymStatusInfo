<?php

use Illuminate\Database\Seeder;
use App\Role as Role;
use App\User as User;
use App\Permission as Permission;


class RolesAndUsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        DB::table('permissions')->delete();
        DB::table('permission_role')->delete();
        DB::table('role_user')->delete();

        $admin = new Role();
        $admin->name = 'admins';
        $admin->display_name = 'Administratoren';
        $admin->description = 'Darf wirklich alles!';
        $admin->save();

        $contributor = new Role();
        $contributor->name = 'contributors';
        $contributor->display_name = 'Mitwirkende';
        $contributor->description = 'Darf Hallenbelegungen verwalten!';
        $contributor->save();

        $guest = new Role();
        $guest->name = 'guests';
        $guest->display_name = 'Gäste';
        $guest->description = 'Darf Hallenbelegungen sehen!';
        $guest->save();

        $createUser = new Permission();
        $createUser->name = 'can_create_user';
        $createUser->display_name = 'Benutzeranlagerecht';
        $createUser->description = 'Darf Benutzer anlegen!';
        $createUser->save();

        $createLocation = new Permission();
        $createLocation->name = 'can_create_location';
        $createLocation->display_name = 'Hallenanlagerecht';
        $createLocation->description = 'Darf Hallen anlegen!';
        $createLocation->save();

        $bookLocation = new Permission();
        $bookLocation->name = 'can_book_location';
        $bookLocation->display_name = 'Hallenbuchungsrecht';
        $bookLocation->description = 'Darf Hallen buchen!';
        $bookLocation->save();

        $canRead = new Permission();
        $canRead->name = 'can_read';
        $canRead->display_name = 'Leserecht';
        $canRead->description = 'Darf Hallenbelegungen sehen!';
        $canRead->save();

        /* Attach permission to role */
        $admin->attachPermission($createUser);
        $admin->attachPermission($createLocation);
        $admin->attachPermission($bookLocation);
        $admin->attachPermission($canRead);

        $contributor->attachPermission($bookLocation);
        $contributor->attachPermission($canRead);

        $guest->attachPermission($canRead);

        /* Give user a role */
        $defaultAdminUser = User::where('email', '=', 'admin@bar.com')->first();       
        $defaultAdminUser->attachRole($admin);
    }
}