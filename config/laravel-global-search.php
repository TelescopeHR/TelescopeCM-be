<?php

use App\Models\Country;
use App\Models\FaqCategory;
use App\Models\FaqItem;
use App\Models\Mail;
use App\Models\MediaCategory;
use App\Models\MediaFile;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\PageCategory;
use App\Models\Permission;
use App\Models\Quote;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Snippet;
use App\Models\Unit;
use App\Models\User;

return [
    'resources' => [
        Country::class,
        // FaqCategory::class,
        // FaqItem::class,
        // Mail::class,
        // MediaCategory::class,
        // MediaFile::class,
        // Menu::class,
        // MenuItem::class,
        Page::class,
        PageCategory::class,
        Permission::class,
        // Quote::class,
        Role::class,
        Setting::class,
        // Slider::class,
        // Snippet::class,
        Unit::class,
        User::class,
    ],
    'limit' => 30
];