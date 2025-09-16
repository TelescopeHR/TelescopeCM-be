<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Page;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::truncate();

        $adminUser = User::find(1);

        $i = 1;

        $adminUser->pages()->saveMany([
            new Page([
                'id' => 1,
                'link_name' => __('Main'),
                'slug' => 'index',
                'sorting' => $i++,
                'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
            ]),
            new Page([
                'id' => 2,
                'link_name' => __('Information'),
                'slug' => 'info',
                'sorting' => $i++,
                'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
            ]),
            new Page([
                'id' => 4,
                'link_name' => __('Register'),
                'slug' => 'register',
                'sorting' => $i++,
                'visible' => Page::VISIBLE_GUEST,
            ]),
            new Page([
                'id' => 5,
                'link_name' => __('Reset Password'),
                'slug' => 'profile/request-password-reset',
                'sorting' => $i++,
                'visible' => Page::VISIBLE_GUEST,
            ]),
            new Page([
                'id' => 6,
                'link_name' => __('Reset Password'),
                'slug' => 'profile/password',
                'sorting' => $i++,
            ]),
            new Page([
                'id' => 7,
                'link_name' => __('Login'),
                'slug' => 'login',
                'sorting' => $i++,
                'visible' => Page::VISIBLE_GUEST,
            ]),
            new Page([
                'id' => 8,
                'link_name' => __('Logout'),
                'slug' => 'logout',
                'sorting' => $i++,
                'visible' => Page::VISIBLE_LOGGED,
            ]),
            new Page([
                'id' => 9,
                'link_name' => __('My Profile'),
                'slug' => 'profile',
                'sorting' => $i++,
                'visible' => Page::VISIBLE_LOGGED,
            ]),
            new Page([
                'id' => 10,
                'link_name' => __('Edit Profile'),
                'slug' => 'profile/edit',
                'sorting' => $i++,
                'visible' => Page::VISIBLE_LOGGED,
            ]),
        ]);
    }
}
