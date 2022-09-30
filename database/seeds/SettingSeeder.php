<?php

namespace Database\Seeders;

use App\Support\SettingJson;
use Illuminate\Database\Seeder;
use Laraeast\LaravelSettings\Facades\Settings;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['shop_terms', 'delegate_terms', 'customer_terms'] as $terms) {
            Settings::set(
                "$terms:ar",
                'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.'
            );

            Settings::set(
                "$terms:en",
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Cras ultricies ligula sed magna dictum porta.'
            );
        }

        Settings::set(
            'privacy:ar',
            'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.'
        );

        Settings::set(
            'privacy:en',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Cras ultricies ligula sed magna dictum porta.'
        );

        Settings::set(
            'about:ar',
            'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.'
        );

        Settings::set(
            'about:en',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Cras ultricies ligula sed magna dictum porta.'
        );

        Settings::set('name:en', 'Easy Get');
        Settings::set('name:ar', 'ايزي جيت');

        Settings::set('max_category_levels', 3);

        Settings::set('copyright:en', 'Copyright © '.date('Y').' '.app_name().' All rights reserved.');
        Settings::set('copyright:ar', 'جميع الحقوق محفوظة');

        Settings::set('facebook', 'https://facebook.com');
        Settings::set('instagram', 'https://instagram.com');
        Settings::set('snapchat', 'https://snapchat.com');
        Settings::set('twitter', 'https://twitter.com');
        Settings::set('apple', '#');
        Settings::set('android', '#');
        Settings::set('phone', '123456');
        Settings::set('email', 'support@demo.com');
        Settings::set('phone_prefix', '+968');

        Settings::set('shipping_cost', 20);

        Settings::set('home_slider')
            ->addMedia(public_path('images/slider.png'))
            ->preservingOriginal()
            ->toMediaCollection('home_slider');

        app(SettingJson::class)->update();
    }
}
