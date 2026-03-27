<?php

namespace App\Providers;

use App\Models\Warehouse\FuelTank;
use App\Models\Warehouse\PurchasingComparison;
use App\Models\Warehouse\PurchasingOrder;
use App\Models\Warehouse\ReceivingDetail;
use App\Models\Warehouse\SparePart;
use App\Observers\FuelTankObserver;
use App\Observers\PurchasingComparisonObserver;
use App\Observers\PurchasingOrderObserver;
use App\Observers\ReceivingDetailObserver;
use App\Observers\SparePartObserver;
use App\ProfilPerusahaan;
use App\Repository\Workshop\SettingRepository;
use Illuminate\Support\ServiceProvider;
use stdClass;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SettingRepository::class, function () {
            return new SettingRepository();
        });

        $this->app->singleton(ProfilPerusahaan::class, function () {
            return ProfilPerusahaan::getInstance();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('breadCrumb', [
            [
                'text' => 'Dashboard',
                'url' => '/',
                'isActive' => false
            ]
        ]);

        // Register Observer

        SparePart::observe(SparePartObserver::class);
        FuelTank::observe(FuelTankObserver::class);
        PurchasingComparison::observe(PurchasingComparisonObserver::class);
        PurchasingOrder::observe(PurchasingOrderObserver::class);
        // ReceivingDetail::observe(ReceivingDetailObserver::class);

        $this->bindUserDataToViews();
    }

    private function bindUserDataToViews()
    {

        view()->composer('*', function ($view) {

            $currentUser = new Stdclass();
            $currentUser->nama = null;
            $currentUser->nik = null;
            $currentUser->jabatan = null;
            $currentUser->dept = null;

            if(!is_null(auth()->user()) && auth()->user()->nik !== '999999999'){
                $currentUser = auth()->user();
                $currentUser->nama = auth()->user()->karyawan->nm_lengkap;
                $currentUser->nik = auth()->user()->karyawan->nik;
                $currentUser->dept = isset(auth()->user()->karyawan->get_departemen->nm_dept) ?? '';
                $currentUser->jabatan = isset(auth()->user()->karyawan->get_jabatan->nm_jabatan) ? auth()->user()->karyawan->get_jabatan->nm_jabatan : '';
                $currentUser->idKaryawan = auth()->user()->karyawan->id;
            }

            $view->with('currentUser', $currentUser);
        });
    }
}
