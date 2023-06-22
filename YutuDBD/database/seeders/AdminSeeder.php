<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();

        $users = [
            ['admin', 'admin', 99, 'littlecornejo@gmail.com', 50000, $now, '2000-03-07', 330]
        ];

        $users = array_map(function($user) use ($now) {
            return [
                'nickname' => $user[0],
                'contrasenia' => $user[1],
                'edad' => $user[2],
                'email' => $user[3],
                'saldo' => $user[4],
                'email_verified_at' => $user[5],
                'fecha_nacimiento' => $user[6],
                'id_comuna' => $user[7],
                'updated_at' => $now,
                'created_at' => $now,
                'deleted' => 'false'
            ];
        }, $users);

        \DB::table('users')->insert($users);

        $permissions = [
            ['ver_video', 'visualización de videos'],
            ['crear_video', 'creación de video'],
            ['editar_video', 'editar una video'],
            ['borrar_video', 'borrar una video'],
            ['ver_lista', 'visualización de lista'],
            ['crear_lista', 'creación de listas'],
            ['editar_lista', 'editar una lista'],
            ['borrar_lista', 'borrar una lista'],
            ['ver_categoria', 'visualización de categoria'],
            ['crear_categoria', 'creación de categoria'],
            ['editar_categoria', 'editar una categoria'],
            ['borrar_categoria', 'borrar una categoria'],
            ['ver_usuario', 'visualización de usuario'],
            ['crear_usuario', 'creación de usuarios'],
            ['editar_usuario', 'editar una usuario'],
            ['borrar_usuario', 'borrar una usuario'],
            ['ver_countries', 'visualización de countries'],
            ['crear_countries', 'creación de countries'],
            ['editar_countries', 'editar una countries'],
            ['borrar_countries', 'borrar una countries'],
            ['ver_communes', 'visualización de communes'],
            ['crear_communes', 'creación de communes'],
            ['editar_communes', 'editar una communes'],
            ['borrar_communes', 'borrar una communes'],
            ['ver_regions', 'visualización de regions'],
            ['crear_regions', 'creación de regions'],
            ['editar_regions', 'editar una regions'],
            ['borrar_regions', 'borrar una regions'],
            ['ver_banks', 'visualización de banks'],
            ['crear_banks', 'creación de banks'],
            ['editar_banks', 'editar una banks'],
            ['borrar_banks', 'borrar una banks'],
            ['ver_type_of_payments', 'visualización de type_of_payments'],
            ['crear_type_of_payments', 'creación de type_of_payments'],
            ['editar_type_of_payments', 'editar una type_of_payments'],
            ['borrar_type_of_payments', 'borrar una type_of_payments'],
            ['ver_pay_methods', 'visualización de pay_methods'],
            ['crear_pay_methods', 'creación de pay_methods'],
            ['editar_pay_methods', 'editar una pay_methods'],
            ['borrar_pay_methods', 'borrar una pay_methods'],
            ['ver_category__synopses', 'visualización de category__synopses'],
            ['crear_category__synopses', 'creación de category__synopses'],
            ['editar_category__synopses', 'editar una category__synopses'],
            ['borrar_category__synopses', 'borrar una category__synopses'],
            ['ver_roles', 'visualización de roles'],
            ['crear_roles', 'creación de roles'],
            ['editar_roles', 'editar una roles'],
            ['borrar_roles', 'borrar una roles'],
            ['ver_permissions', 'visualización de permissions'],
            ['crear_permissions', 'creación de permissions'],
            ['editar_permissions', 'editar una permissions'],
            ['borrar_permissions', 'borrar una permissions'],
            ['ver_user_roles', 'visualización de user_roles'],
            ['crear_user_roles', 'creación de user_roles'],
            ['editar_user_roles', 'editar una user_roles'],
            ['borrar_user_roles', 'borrar una user_roles'],
            ['ver_user__pay_methods', 'visualización de user__pay_methods'],
            ['crear_user__pay_methods', 'creación de user__pay_methods'],
            ['editar_user__pay_methods', 'editar una user__pay_methods'],
            ['borrar_user__pay_methods', 'borrar una user__pay_methods'],
            ['ver_groups', 'visualización de groups'],
            ['crear_groups', 'creación de groups'],
            ['editar_groups', 'editar una groups'],
            ['borrar_groups', 'borrar una groups'],
            ['ver_follows', 'visualización de follows'],
            ['crear_follows', 'creación de follows'],
            ['editar_follows', 'editar una follows'],
            ['borrar_follows', 'borrar una follows'],
            ['ver_donates', 'visualización de donates'],
            ['crear_donates', 'creación de donates'],
            ['editar_donates', 'editar una donates'],
            ['borrar_donates', 'borrar una donates'],
            ['ver_group__synopses', 'visualización de group__synopses'],
            ['crear_group__synopses', 'creación de group__synopses'],
            ['editar_group__synopses', 'editar una group__synopses'],
            ['borrar_group__synopses', 'borrar una group__synopses'],
            ['ver_admin_user_synopses', 'visualización de admin_user_synopses'],
            ['crear_admin_user_synopses', 'creación de admin_user_synopses'],
            ['editar_admin_user_synopses', 'editar una admin_user_synopses'],
            ['borrar_admin_user_synopses', 'borrar una admin_user_synopses'],
            ['ver_role_permissions', 'visualización de role_permissions'],
            ['crear_role_permissions', 'creación de role_permissions'],
            ['editar_role_permissions', 'editar una role_permissions'],
            ['borrar_role_permissions', 'borrar una role_permissions'],
            ['ver_admin_user_groups', 'visualización de admin_user_groups'],
            ['crear_admin_user_groups', 'creación de admin_user_groups'],
            ['editar_admin_user_groups', 'editar una admin_user_groups'],
            ['borrar_admin_user_groups', 'borrar una admin_user_groups'],
            ['ver_view_user_groups', 'visualización de view_user_groups'],
            ['crear_view_user_groups', 'creación de view_user_groups'],
            ['editar_view_user_groups', 'editar una view_user_groups'],
            ['borrar_view_user_groups', 'borrar una view_user_groups'],
            ['ver_comments', 'visualización de comments'],
            ['crear_comments', 'creación de comments'],
            ['editar_comments', 'editar una comments'],
            ['borrar_comments', 'borrar una comments'],
            ['ver_historial_user_synopses', 'visualización de historial_user_synopses'],
            ['crear_historial_user_synopses', 'creación de historial_user_synopses'],
            ['editar_historial_user_synopses', 'editar una historial_user_synopses'],
            ['borrar_historial_user_synopses', 'borrar una historial_user_synopses'],
            ['ver_like_user_synopses', 'visualización de like_user_synopses'],
            ['crear_like_user_synopses', 'creación de like_user_synopses'],
            ['editar_like_user_synopses', 'editar una like_user_synopses'],
            ['borrar_like_user_synopses', 'borrar una like_user_synopses']
        ];

        $permissions = array_map(function($permission) use ($now) {
            return [
                'nombre' => $permission[0],
                'descripcion' => $permission[1],
                'updated_at' => $now,
                'created_at' => $now,
                'deleted' => 'false'
            ];
        }, $permissions);

        \DB::table('permissions')->insert($permissions);

        $roles = [
            ['administrador','soy admin']
        ];

        $roles = array_map(function($rol) use ($now) {
            return [
                'nombre' => $rol[0],
                'descripcion' => $rol[1],
                'updated_at' => $now,
                'created_at' => $now,
                'deleted' => 'false'
            ];
        }, $roles);

        \DB::table('roles')->insert($roles);

        $rol_permissions =[
            [1,1],
            [1,2],
            [1,3],
            [1,4],
            [1,5],
            [1,6],
            [1,7],
            [1,8],
            [1,9],
            [1,10],
            [1,11],
            [1,12],
            [1,13],
            [1,14],
            [1,15],
            [1,16]
        ];

        $role_permissions = array_map(function($role_permission) use ($now) {
            return [
                'id_rol' => $role_permission[0],
                'id_permiso' => $role_permission[1],
                'updated_at' => $now,
                'created_at' => $now,
                'deleted' => 'false'
            ];
        }, $rol_permissions);

        \DB::table('role_permissions')->insert($role_permissions);

        $user_roles = [
            [1,1]
        ];

        $user_roles = array_map(function($user_rol) use ($now) {
            return [
                'id_usuario' => $user_rol[0],
                'id_rol' => $user_rol[1],
                'updated_at' => $now,
                'created_at' => $now,
                'deleted' => 'false'
            ];
        }, $user_roles);

        \DB::table('user_roles')->insert($user_roles);
    }
}
