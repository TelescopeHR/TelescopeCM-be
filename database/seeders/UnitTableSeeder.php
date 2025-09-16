<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\UnitCategory;
use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  Unit::truncate();

        Unit::updateOrCreate( // 1
            ['slug' => 'dashboard'],
            [
                'parent_id' => null,
                'category_id' => null,
                'name' => __('Dashboard'),
                'slug' => 'dashboard',
                'icon_class' => null,
                'visible' => true,
                'sorting' => 0,
            ]);

        Unit::updateOrCreate( // 2
            ['slug' => 'client.profile'],
            [
                'parent_id' => null,
                'category_id' => 1,
                'name' => __('Profile'),
                'slug' => 'client.profile',
                'icon_class' => 'fa fa-users',
                'visible' => true,
                'sorting' => 1,
            ]
        );

        Unit::updateOrCreate( // 3
            ['slug' => 'client.care-plans'],
            [
                'parent_id' => null,
                'category_id' => 1,
                'name' => __('Care Plans'),
                'slug' => 'client.care-plans',
                'icon_class' => 'fa fa-heartbeat',
                'visible' => true,
                'sorting' => 1,
            ]
        );

        Unit::updateOrCreate(
            ['slug' => 'client.schedule'],
            [
                'parent_id' => null,
                'category_id' => 1,
                'name' => __('Schedules'),
                'slug' => 'client.schedule',
                'icon_class' => 'fa fa-heartbeat',
                'visible' => true,
                'sorting' => 1,
            ]
        );

     /*   Unit::updateOrCreate( // 4
            ['slug' => 'client.medical'],
            [
                'parent_id' => null,
                'category_id' => 1,
                'name' => __('Medical'),
                'slug' => 'client.medical',
                'icon_class' => 'fas fa-book-medical',
                'visible' => true,
                'sorting' => 2,
            ]
        ); */

        Unit::updateOrCreate( // 5
            ['slug' => 'client.schedule'],
            [
                'parent_id' => null,
                'category_id' => 1,
                'name' => __('Schedules'),
                'slug' => 'client.schedule',
                'icon_class' => 'fas fa-calendar-alt',
                'visible' => true,
                'sorting' => 3,
            ]
        );

        Unit::updateOrCreate( // 6
            ['slug' => 'client.visit'],
            [
                'parent_id' => null,
                'category_id' => 1,
                'name' => __('Visits'),
                'slug' => 'client.visit',
                'icon_class' => 'fas fa-hand-holding-medical',
                'visible' => true,
                'sorting' => 4,
            ]
        );

        Unit::updateOrCreate( // 6
            ['slug' => 'client.files'],
            [
                'parent_id' => null,
                'category_id' => 1,
                'name' => __('Files'),
                'slug' => 'client.files',
                'icon_class' => 'fas fa-hand-holding-medical',
                'visible' => true,
                'sorting' => 6,
            ]
        );

        Unit::updateOrCreate( // 7
            ['slug' => 'client.note'],
            [
                'parent_id' => null,
                'category_id' => 1,
                'name' => __('Admin notes'),
                'slug' => 'client.note',
                'icon_class' => 'fas fa-sticky-note',
                'visible' => true,
                'sorting' => 5,
            ]
        );

        Unit::updateOrCreate( // 8
            ['slug' => 'employee.profile'],
            [
                'parent_id' => null,
                'category_id' => 2,
                'name' => __('Profile'),
                'slug' => 'employee.profile',
                'icon_class' => 'fas fa-sticky-note',
                'visible' => true,
                'sorting' => 1,
            ]
        );

        Unit::updateOrCreate( // 9
            ['slug' => 'employee.schedule'],
            [
                'parent_id' => null,
                'category_id' => 2,
                'name' => __('Schedules'),
                'slug' => 'employee.schedule',
                'icon_class' => 'fas fa-calendar-alt',
                'visible' => true,
                'sorting' => 3,
            ]
        );

        Unit::updateOrCreate( // 10
            ['slug' => 'employee.visit'],
            [
                'parent_id' => null,
                'category_id' => 2,
                'name' => __('Visits'),
                'slug' => 'employee.visit',
                'icon_class' => 'fas fa-hand-holding-medical',
                'visible' => true,
                'sorting' => 4,
            ]
        );

        Unit::updateOrCreate( // 11
            ['slug' => 'employee.note'],
            [
                'parent_id' => null,
                'category_id' => 2,
                'name' => __('Admin notes'),
                'slug' => 'employee.note',
                'icon_class' => 'fas fa-sticky-note',
                'visible' => true,
                'sorting' => 5
            ]
        );

        Unit::updateOrCreate( // 6
            ['slug' => 'employee.files'],
            [
                'parent_id' => null,
                'category_id' => 2,
                'name' => __('Files'),
                'slug' => 'employee.files',
                'icon_class' => 'fas fa-hand-holding-medical',
                'visible' => true,
                'sorting' => 6,
            ]
        );

        Unit::updateOrCreate( // 12
            ['slug' => 'user'],
            [
                'parent_id' => null,
                'category_id' => 3,
                'name' => __('Users'),
                'slug' => 'user',
                'icon_class' => 'fa fa-users',
                'visible' => true,
                'sorting' => 1,
            ]);

        Unit::updateOrCreate( // 13
            ['slug' => 'company'],
            [
                'parent_id' => null,
                'category_id' => 3,
                'name' => __('Companies'),
                'slug' => 'company',
                'icon_class' => 'fas fa-building',
                'visible' => true,
                'sorting' => 3,
            ]);

        Unit::updateOrCreate( // 14
            ['slug' => 'role'],
            [
                'parent_id' => null,
                'category_id' => 3,
                'name' => __('Roles'),
                'slug' => 'role',
                'icon_class' => 'fa fa-user-secret',
                'visible' => true,
                'sorting' => 4,
            ]);

        Unit::updateOrCreate( // 15
            ['slug' => 'permission'],
            [
                'parent_id' => null,
                'category_id' => 3,
                'name' => __('Permissions'),
                'slug' => 'permission',
                'icon_class' => 'fa fa-universal-access',
                'visible' => true,
                'sorting' => 5,
            ]);

        Unit::updateOrCreate( // 16
            ['slug' => 'setting'],
            [
                'parent_id' => null,
                'category_id' => 3,
                'name' => __('Settings'),
                'slug' => 'setting',
                'icon_class' => 'fa fa-cogs',
                'visible' => true,
                'sorting' => 6,
            ]);

        Unit::updateOrCreate( // 17
            ['slug' => 'unit'],
            [
                'parent_id' => null,
                'category_id' => 3,
                'name' => __('Units'),
                'slug' => 'unit',
                'icon_class' => 'fa fa-folder',
                'visible' => true,
                'sorting' => 7,
            ]);

        Unit::updateOrCreate( // 18
            ['slug' => 'unitCategory'],
            [
                'parent_id' => 3,
                'category_id' => null,
                'name' => __('Unit Categories'),
                'slug' => 'unitCategory',
                'icon_class' => null,
                'visible' => true,
                'sorting' => 8,
            ]);


        Unit::updateOrCreate( // 19
            ['slug' => 'bodyArea'],
            [
                'parent_id' => null,
                'category_id' => 3,
                'name' => __('Body Areas'),
                'slug' => 'bodyArea',
                'icon_class' => 'fa fa-folder',
                'visible' => false,
                'sorting' => 9
            ]
        );

        Unit::updateOrCreate( // 20
            ['slug' => 'scheduleType'],
            [
                'parent_id' => null,
                'category_id' => 3,
                'name' => __('Schedule Types'),
                'slug' => 'scheduleType',
                'icon_class' => 'fa fa-folder',
                'visible' => true,
                'sorting' => 10,
            ]
        );

        Unit::updateOrCreate( // 21
            ['slug' => 'visitBodyArea'],
            [
                'parent_id' => 12,
                'category_id' => 3,
                'name' => __('Visit Body Areas'),
                'slug' => 'visitBodyArea',
                'icon_class' => 'fa fa-folder',
                'visible' => false,
                'sorting' => 15,
            ]
        );

        Unit::updateOrCreate( // 22
            ['slug' => 'client.shift-note'],
            [
                'parent_id' => null,
                'category_id' => 1, //client
                'name' => __('Employee notes'),
                'slug' => 'client.shift-note',
                'icon_class' => 'fas fa-book-medical',
                'visible' => true,
                'sorting' => 6,
            ]
        );

        Unit::updateOrCreate( // 23
            ['slug' => 'employee.shift-note'],
            [
                'parent_id' => null,
                'category_id' => 2, //employee
                'name' => __('Employee notes'),
                'slug' => 'employee.shift-note',
                'icon_class' => 'fas fa-book-medical',
                'visible' => true,
                'sorting' => 6,
            ]
        );

        $category = UnitCategory::where('name', 'Mobile API')->first();

        if (!$category) {
            $this->command->error('Категория "Category "Mobile API" not found. Run UnitCategoryTableSeeder again.');
            return;
        }

        $parentUnit = Unit::updateOrCreate([
            'slug' => 'mobile-api',
        ], [
            'category_id' => $category->id,
            'parent_id' => null,
            'name' => 'Mobile API',
            'slug' => 'mobile-api',
            'icon_class' => 'fa fa-mobile',
            'visible' => false,
            'sorting' => 10,
        ]);

        $children = [
            [
                'name' => 'API Get Schedule',
                'slug' => 'mobile-api.schedule',
                'icon_class' => 'fa fa-calendar',
                'sorting' => 10,
            ],
            [
                'name' => 'API Clock Dashboard',
                'slug' => 'mobile-api.clock',
                'icon_class' => 'fa fa-lock',
                'sorting' => 20,
            ],
        ];

        foreach ($children as $child) {
            Unit::updateOrCreate([
                'slug' => $child['slug'],
            ], [
                'category_id' => $category->id,
                'parent_id' => $parentUnit->id,
                'name' => $child['name'],
                'slug' => $child['slug'],
                'icon_class' => $child['icon_class'],
                'visible' => false,
                'sorting' => $child['sorting'],
            ]);
        }
    }
}
