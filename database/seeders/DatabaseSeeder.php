<?php

namespace Database\Seeders;

use App\Models\SiteContent;
use App\Models\SocialLink;
use App\Models\User;
use App\Models\ViewCounter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if ($this->shouldSeedDefaultAdmin()) {
            User::updateOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Admin',
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                    'status' => 'active',
                ]
            );
        }

        $contents = [
            ['key' => 'hero_title', 'locale' => 'en', 'value' => 'BENDA TE ME', 'updated_by' => null],
            ['key' => 'hero_title', 'locale' => 'ru', 'value' => 'БЕНДА ТЕ МЕ', 'updated_by' => null],
            ['key' => 'hero_subtitle', 'locale' => 'en', 'value' => 'Search and support platform for missing persons.', 'updated_by' => null],
            ['key' => 'hero_subtitle', 'locale' => 'ru', 'value' => 'Платформа поиска и поддержки пропавших людей.', 'updated_by' => null],
            ['key' => 'join_title', 'locale' => 'en', 'value' => 'Join our project', 'updated_by' => null],
            ['key' => 'join_title', 'locale' => 'ru', 'value' => 'Присоединяйтесь к проекту', 'updated_by' => null],
            ['key' => 'join_subtitle', 'locale' => 'en', 'value' => 'Join our project and to see his relatives get other opportunities!', 'updated_by' => null],
            ['key' => 'join_subtitle', 'locale' => 'ru', 'value' => 'Вместе мы поможем семьям найти ответы.', 'updated_by' => null],
        ];

        foreach ($contents as $content) {
            SiteContent::updateOrCreate(
                ['key' => $content['key'], 'locale' => $content['locale']],
                ['value' => $content['value'], 'updated_by' => null]
            );
        }

        $social = [
            ['platform' => 'Facebook', 'url' => 'https://www.facebook.com/profile.php?id=61572317708326&mibextid=wwXIfr', 'sort_order' => 1, 'is_active' => true],
            ['platform' => 'Instagram', 'url' => 'https://www.instagram.com/li_benda_te_me__?igsh=MXZlMWhibGxrNWluMA%3D%3D&utm_source=qr', 'sort_order' => 2, 'is_active' => true],
            ['platform' => 'TikTok', 'url' => 'https://www.tiktok.com/@bt.com.bt?_t=8oP9iW4TedR&_r=1', 'sort_order' => 3, 'is_active' => true],
            ['platform' => 'VK', 'url' => 'https://m.vk.com/id841711778', 'sort_order' => 4, 'is_active' => true],
            ['platform' => 'Telegram', 'url' => 'https://t.me/BT_NMG', 'sort_order' => 5, 'is_active' => true],
            ['platform' => 'X', 'url' => 'https://x.com/benda_li83105', 'sort_order' => 6, 'is_active' => true],
            ['platform' => 'OK', 'url' => 'https://ok.ru/profile/587992629098', 'sort_order' => 7, 'is_active' => true],
            ['platform' => 'YouTube', 'url' => 'https://www.youtube.com/@sterkenkurd1112?si=gevElIkHga0JUhL9', 'sort_order' => 8, 'is_active' => true],
            ['platform' => 'Snapchat', 'url' => 'https://snapchat.com/t/55yPSFtF', 'sort_order' => 9, 'is_active' => true],
        ];

        foreach ($social as $link) {
            SocialLink::updateOrCreate(
                ['platform' => $link['platform']],
                ['url' => $link['url'], 'sort_order' => $link['sort_order'], 'is_active' => $link['is_active']]
            );
        }

        ViewCounter::firstOrCreate(['page_key' => 'home'], ['total_views' => 223652]);
    }

    private function shouldSeedDefaultAdmin(): bool
    {
        if (app()->environment(['local', 'testing'])) {
            return true;
        }

        return filter_var(env('SEED_DEFAULT_ADMIN', false), FILTER_VALIDATE_BOOL);
    }
}
