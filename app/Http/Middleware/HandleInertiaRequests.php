<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $permissions = !$request->user() ? [] : [
            'can' => [
                'manage_products' => $request->user()->can('manage products'),
                'manage_categories' => $request->user()->can('manage categories'),
                'manage_users' => $request->user()->can('manage users'),
            ]
        ] ;

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'token' => $request->session()->get('token'),
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            ...$permissions
        ];
    }
}
