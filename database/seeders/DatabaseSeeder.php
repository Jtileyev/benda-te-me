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
            ['platform' => 'Telegram', 'url' => 'https://t.me', 'sort_order' => 1, 'is_active' => true],
            ['platform' => 'Instagram', 'url' => 'https://instagram.com', 'sort_order' => 2, 'is_active' => true],
            ['platform' => 'Facebook', 'url' => 'https://facebook.com', 'sort_order' => 3, 'is_active' => true],
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
