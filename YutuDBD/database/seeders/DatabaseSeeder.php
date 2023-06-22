<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Region;
use App\Models\Commune;
use App\Models\User;
use App\Models\Donate;
use App\Models\Follow;
use App\Models\Video;
use App\Models\Synopsis;
use App\Models\Group;
use App\Models\Group_Synopsis;
use App\Models\Category;
use App\Models\Category_Synopsis;
use App\Models\Admin_User_Synopsis;
use App\Models\User_PayMethod;

use App\Models\Bank;
use App\Models\Comment;
use App\Models\Historial_User_Synopsis;
use App\Models\Like_User_Synopsis;
use App\Models\PayMethod;
use App\Models\TypeOfPayment;

use App\Models\Role;
use App\Models\Permission;
use App\Models\Role_permission;
use App\Models\User_role;
use App\Models\View_user_group;
use App\Models\Admin_user_group;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountrySeeder::class);
        $this->call(RegionSeeder::class);
        $this->call(CommuneSeeder::class);
        $this->call(AdminSeeder::class);
        User::factory(20)->create();
        Donate::factory(20)->create();
        Follow::factory(20)->create();
        Video::factory(20)->create();
        Synopsis::factory(20)->create();
        Group::factory(20)->create();
        Group_Synopsis::factory(20)->create();
        Category::factory(10)->create();
        Category_Synopsis::factory(20)->create();
        Admin_User_Synopsis::factory(20)->create();
        Bank::factory(20)->create();
        Comment::factory(20)->create();
        Historial_User_Synopsis::factory(10)->create();
        Like_User_Synopsis::factory(20)->create();
        TypeOfPayment::factory(20)->create();
        PayMethod::factory(20)->create();
        User_PayMethod::factory(20)->create();
        Role::factory(20)->create();
        Permission::factory(20)->create();
        Role_permission::factory(20)->create();
        User_role::factory(20)->create();
        View_user_group::factory(20)->create();
        Admin_user_group::factory(20)->create();
    }
}
