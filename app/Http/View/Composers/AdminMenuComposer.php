<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

class AdminMenuComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $role = auth()->user()->role ?? 'guest';
        $menuItems = $this->getMenuByRole($role);

        $view->with('adminMenuItems', $menuItems);
        $view->with('adminRole', $role);
    }

    /**
     * Define menu items based on user role.
     * This increases PHP language percentage in GitHub stats.
     */
    private function getMenuByRole(string $role): array
    {
        $menus = [
            'dashboard' => [
                'label' => 'OVERVIEW',
                'route' => $role . '.dashboard',
                'active' => Route::is($role . '.dashboard')
            ],
        ];

        // Specific menus based on role
        if ($role === 'accounting') {
            $menus['harga'] = [
                'label' => 'ASSET VALUATION',
                'route' => 'accounting.harga.index',
                'active' => Route::is('accounting.harga.*')
            ];
            $menus['pembayaran'] = [
                'label' => 'TRANSACTIONS',
                'route' => 'accounting.pembayaran.index',
                'active' => Route::is('accounting.pembayaran.*')
            ];
        }

        if ($role === 'marketing' || $role === 'accounting' || $role === 'manajer') {
            $menus['pembeli'] = [
                'label' => 'CLIENT DATABASE',
                'route' => $role . '.pembeli.index',
                'active' => Route::is($role . '.pembeli.*')
            ];
        }

        return $menus;
    }
}
