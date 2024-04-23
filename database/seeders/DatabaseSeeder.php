<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Configuration;
use App\Models\Blog;
use App\Models\Page;
use App\Models\Menu;
use App\Models\MenuItem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application'.htaccess database.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(
            ['name' => 'Super Admin'],
            [
                'name' => 'Super Admin',
                'guard_name' => 'web',
            ]
        );

        Role::firstOrCreate(
            ['name' => 'Admin'],
            [
                'name' => 'Admin',
                'guard_name' => 'web',
            ]
        );

        Role::firstOrCreate(
            ['name' => 'Manager'],
            [
                'name' => 'Manager',
                'guard_name' => 'web',
            ]
        );

        Role::firstOrCreate(
            ['name' => 'Customer'],
            [
                'name' => 'Customer',
                'guard_name' => 'web',
            ]
        );


        $this->defaultConfiguration();
        $this->defaultBlog();
        $this->defaultPage();
        $this->defaultMenu();

    }

    function defaultConfiguration()
    {
        $data = [
            [
                'name'          => 'Site.title',
                'value'         => 'W3CMS Laravel',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 1,
                'params'        => Null,
                'order'         => 1
            ],
            [
                'name'          => 'Site.tagline',
                'value'         => 'W3CMS - Laravel CMS System',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => 'textarea',
                'editable'      => 1,
                'weight'        => 2,
                'params'        => Null,
                'order'         => 2
            ],
            [
                'name'          => 'Site.email',
                'value'         => 'w3cms@example.com',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 3,
                'params'        => Null,
                'order'         => 3
            ],
            [
                'name'          => 'Site.status',
                'value'         => 1,
                'title'         => Null,
                'description'   => 'deactivate Site (Maintenance Mode).',
                'input_type'    => 'checkbox',
                'editable'      => 1,
                'weight'        => 4,
                'params'        => Null,
                'order'         => 4
            ],
            [
                'name'          => 'Site.copyright',
                'value'         => '<strong class="text-dark">W3CMS</strong> Copyright © 2022 All Rights Reserved',
                'title'         => 'Copyright Text',
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 5,
                'params'        => Null,
                'order'         => 5
            ],
            [
                'name'          => 'Site.footer_text',
                'value'         => 'Developed by <a href="https://www.w3itexperts.com/\" target=\"_blank\">W3itexperts</a>',
                'title'         => 'Footer text',
                'description'   => Null,
                'input_type'    => 'textarea',
                'editable'      => 1,
                'weight'        => 6,
                'params'        => Null,
                'order'         => 6
            ],
            [
                'name'          => 'Site.coming_soon',
                'value'         => 0,
                'title'         => Null,
                'description'   => 'deactivate site and show coming soon page.',
                'input_type'    => 'checkbox',
                'editable'      => 1,
                'weight'        => 7,
                'params'        => Null,
                'order'         => 7
            ],
            [
                'name'          => 'Site.contact',
                'value'         => '9876543210',
                'title'         => Null,
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 8,
                'params'        => Null,
                'order'         => 8
            ],
            [
                'name'          => 'Site.logo',
                'value'         => Null,
                'title'         => 'Logo',
                'description'   => 'Site Logo',
                'input_type'    => 'file',
                'editable'      => 1,
                'weight'        => 9,
                'params'        => Null,
                'order'         => 9
            ],
            [
                'name'          => 'Site.favicon',
                'value'         => Null,
                'title'         => 'Favicon',
                'description'   => 'Site Favicon',
                'input_type'    => 'file',
                'editable'      => 1,
                'weight'        => 10,
                'params'        => Null,
                'order'         => 10
            ],
            [
                'name'          => 'Site.maintenance_message',
                'value'         => 'PLEASE SORRY FOR THE <span class="text-primary">DISTURBANCES</span>',
                'title'         => 'Maintenance Message',
                'description'   => 'Site down for maintenance Message will show on maintenance page',
                'input_type'    => 'textarea',
                'editable'      => 1,
                'weight'        => 11,
                'params'        => Null,
                'order'         => 11
            ],
            [
                'name'          => 'Site.comingsoon_message',
                'value'         => 'We Are Coming Soon !',
                'title'         => 'Coming Soon Message',
                'description'   => 'Coming soon message will show on coming soon page',
                'input_type'    => 'textarea',
                'editable'      => 1,
                'weight'        => 12,
                'params'        => Null,
                'order'         => 12
            ],
            [
                'name'          => 'Site.text_logo',
                'value'         => Null,
                'title'         => 'Text Logo',
                'description'   => Null,
                'input_type'    => 'file',
                'editable'      => 1,
                'weight'        => 13,
                'params'        => Null,
                'order'         => 13
            ],
            [
                'name'          => 'Site.comingsoon_date',
                'value'         => Null,
                'title'         => Null,
                'description'   => 'Shows how much time is left for your website to be come',
                'input_type'    => 'date',
                'editable'      => 1,
                'weight'        => 14,
                'params'        => Null,
                'order'         => 14
            ],
            [
                'name'          => 'Reading.nodes_per_page',
                'value'         => 6,
                'title'         => Null,
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 16,
                'params'        => Null,
                'order'         => 16
            ],
            [
                'name'          => 'Reading.date_time_format',
                'value'         => 'F d Y',
                'title'         => Null,
                'description'   => 'Date Formates :- F j, Y (November 23, 2022), Y-m-d (2022-11-23), m/d/Y (11/23/2022), d/m/Y(23/11/2022) And Time Formates :- g:i a(5:45 am), g:i A(5:45 AM), H:i (05:45)',
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 17,
                'params'        => Null,
                'order'         => 17
            ],
            [
                'name'          => 'Social.linkedin',
                'value'         => 'http://www.linkedin.com',
                'title'         => 'Linkedin Url',
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 18,
                'params'        => Null,
                'order'         => 18
            ],
            [
                'name'          => 'Social.googleplus',
                'value'         => 'http://plus.google.com',
                'title'         => 'Googleplus Url',
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 19,
                'params'        => Null,
                'order'         => 19
            ],
            [
                'name'          => 'Social.facebook',
                'value'         => 'http://www.facebook.com',
                'title'         => 'Facebook Url',
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 20,
                'params'        => Null,
                'order'         => 20
            ],
            [
                'name'          => 'Social.twitter',
                'value'         => 'http://www.twitter.com',
                'title'         => 'Twitter Url',
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 0,
                'weight'        => 21,
                'params'        => Null,
                'order'         => 21
            ],
            [
                'name'          => 'Site.menu_location',
                'value'         => '',
                'title'         => '',
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 0,
                'weight'        => 22,
                'params'        => Null,
                'order'         => 22
            ],
            [
                'name'          => 'Permalink.settings',
                'value'         => '',
                'title'         => '',
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 23,
                'params'        => Null,
                'order'         => 23
            ],
            [
                'name'          => 'Reading.show_on_front',
                'value'         => 'Page',
                'title'         => '',
                'description'   => '(Home Page)',
                'input_type'    => 'radio',
                'editable'      => 1,
                'weight'        => 24,
                'params'        => 'Post,Page',
                'order'         => 24
            ],
            [
                'name'          => 'Widget.show_sidebar',
                'value'         => '1',
                'title'         => '',
                'description'   => Null,
                'input_type'    => 'checkbox',
                'editable'      => 1,
                'weight'        => 25,
                'params'        => Null,
                'order'         => 25
            ],
            [
                'name'          => 'Widget.show_recent_post_widget',
                'value'         => '1',
                'title'         => '',
                'description'   => Null,
                'input_type'    => 'checkbox',
                'editable'      => 1,
                'weight'        => 26,
                'params'        => Null,
                'order'         => 26
            ],
            [
                'name'          => 'Widget.show_category_widget',
                'value'         => '1',
                'title'         => '',
                'description'   => Null,
                'input_type'    => 'checkbox',
                'editable'      => 1,
                'weight'        => 27,
                'params'        => Null,
                'order'         => 27
            ],
            [
                'name'          => 'Widget.show_archives_widget',
                'value'         => '1',
                'title'         => '',
                'description'   => Null,
                'input_type'    => 'checkbox',
                'editable'      => 1,
                'weight'        => 28,
                'params'        => Null,
                'order'         => 28
            ],
            [
                'name'          => 'Widget.show_search_widget',
                'value'         => '1',
                'title'         => '',
                'description'   => Null,
                'input_type'    => 'checkbox',
                'editable'      => 1,
                'weight'        => 29,
                'params'        => Null,
                'order'         => 29
            ],
            [
                'name'          => 'Widget.show_tags_widget',
                'value'         => '1',
                'title'         => '',
                'description'   => Null,
                'input_type'    => 'checkbox',
                'editable'      => 1,
                'weight'        => 30,
                'params'        => Null,
                'order'         => 30
            ],
            [
                'name'          => 'Theme.select_theme',
                'value'         => 'w3itexperts/bodyshape',
                'title'         => '',
                'description'   => '',
                'input_type'    => 'radio',
                'editable'      => 1,
                'weight'        => 31,
                'params'        => ':default,w3itexperts/bodyshape:Theme 1',
                'order'         => 31
            ],
            [
                'name'          => 'Site.icon_logo',
                'value'         => '',
                'title'         => '',
                'description'   => 'icon logo',
                'input_type'    => 'file',
                'editable'      => 1,
                'weight'        => 32,
                'params'        => Null,
                'order'         => 32
            ],
            [
                'name'          => 'Site.location',
                'value'         => '832  Thompson Drive, San Fransisco CA 94107, United States',
                'title'         => '',
                'description'   => Null,
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 33,
                'params'        => Null,
                'order'         => 33
            ],
            [
                'name'          => 'Site.office_time',
                'value'         => 'Time 09:00 AM To 07:00 PM',
                'title'         => '',
                'description'   => 'Ex. : "Time 06:00 AM To 08:00 PM"',
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 34,
                'params'        => Null,
                'order'         => 34
            ],
            [
                'name'          => 'Site.biography',
                'value'         => 'A Wonderful Serenity Has Taken Possession Of My Entire Soul, Like These.',
                'title'         => '',
                'description'   => 'Ex. : "Time 06:00 AM To 08:00 PM"',
                'input_type'    => 'text',
                'editable'      => 1,
                'weight'        => 35,
                'params'        => Null,
                'order'         => 35
            ],
        ];
        Configuration::insert($data);
    }

    function defaultPage()
    {
        $page = Page::create([
                'user_id'       => '1',
                'title'         => 'Sample page',
                'slug'          => 'sample-page',
                'content'       => 'This is a sample page',
                'excerpt'       => 'Excerpt2',
                'comment'       => 1,
                'page_type'     => 'Page',
                'status'        => '1',
                'visibility'    => 'Pu',
                'publish_on'    => date('Y-m-d h:i:.htaccess'),
            ]);

        $page->page_metas()->create([
                'title' => 'ximage',
                'value' => '1667219414_image_2022_07_25T07_04_32_910Z.png',
            ]);
    }

    function defaultBlog()
    {
        $blog = Blog::create(
            [
                'user_id'       =>  '1',
                'title'         => 'Hello World',
                'slug'          => 'hello-world',
                'content'       => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'.htaccess standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                'status'        => '1',
                'visibility'    => 'Pu',
                'publish_on'    => date('Y-m-d h:i:.htaccess'),
            ]
        );

        $blog->blog_metas()->create([
                'title' => 'ximage',
                'value' => '1671452680_pic7.jpg',
            ]);
    }

    function defaultMenu()
    {
        $menu1 = Menu::create(
            [
                'user_id'       => '1',
                'title'         => 'Primary Menu',
                'slug'          => 'primary-menu',
                'order'        	=> '1',
            ]
        );

        $menu2 = Menu::create(
            [
                'user_id'       => '1',
                'title'         => 'Footer Menu',
                'slug'          => 'footer-menu',
                'order'         => '2',
            ]
        );

        $menu3 = Menu::create(
            [
                'user_id'       => '1',
                'title'         => 'Primary Menu',
                'slug'          => 'primary-menu',
                'order'         => '3',
            ]
        );

        $menu1->menu_items()->create([
            'parent_id' => 0,
            'menu_id' => 1,
            'item_id' => 1,
            'type' => 'Page',
            'title' => 'Home',
            'attribute' => 'Home',
            'menu_target' => 0,
            'order' => 0,

        ]);

        $menu2->menu_items()->create([
            'parent_id' => 0,
            'menu_id' => 2,
            'item_id' => 1,
            'type' => 'Page',
            'title' => 'Home',
            'attribute' => 'Home',
            'menu_target' => 0,
            'order' => 0,

        ]);

        $menu3->menu_items()->create([
            'parent_id' => 0,
            'menu_id' => 3,
            'item_id' => 1,
            'type' => 'Page',
            'title' => 'Home',
            'attribute' => 'Home',
            'menu_target' => 0,
            'order' => 0,

        ]);
    }
}
