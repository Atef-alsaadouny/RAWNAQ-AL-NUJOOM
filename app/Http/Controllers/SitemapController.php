<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $locales = config('app.supported_locales');

        $staticRoutes = [
            ['loc' => route('home'), 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['loc' => route('services'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => route('about'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => route('gallery'), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => route('faq'), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => route('contact'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => route('book'), 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => route('track'), 'changefreq' => 'monthly', 'priority' => '0.6'],
        ];

        $urls = [];
        foreach ($staticRoutes as $route) {
            $urls[] = $this->buildUrl($route['loc'], $route['changefreq'], $route['priority'], $locales);
        }

        $sitemapUrl = route('home') . '/sitemap.xml';

        return response()->view('sitemap', [
            'urls' => $urls,
            'sitemapUrl' => $sitemapUrl,
        ])->header('Content-Type', 'text/xml');
    }

    private function buildUrl($baseLoc, $changefreq, $priority, $locales)
    {
        $alternates = [];
        foreach ($locales as $locale) {
            $alternates[] = [
                'hreflang' => $locale,
                'href' => $baseLoc . '?locale=' . $locale,
            ];
        }
        $alternates[] = [
            'hreflang' => 'x-default',
            'href' => $baseLoc,
        ];

        return [
            'loc' => $baseLoc,
            'alternates' => $alternates,
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];
    }
}
