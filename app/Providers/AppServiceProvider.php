<?php

namespace App\Providers;

use App\Models\SocialLink;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('partials.footer', function ($view): void {
            try {
                $links = SocialLink::query()
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->get();

                if ($links->isEmpty()) {
                    $links = collect([
                        (object) ['platform' => 'Telegram', 'url' => 'https://t.me'],
                        (object) ['platform' => 'Instagram', 'url' => 'https://instagram.com'],
                        (object) ['platform' => 'Facebook', 'url' => 'https://facebook.com'],
                    ]);
                }

                $view->with('footerSocialLinks', $links);
            } catch (Throwable) {
                $view->with('footerSocialLinks', collect());
            }
        });
    }
}
