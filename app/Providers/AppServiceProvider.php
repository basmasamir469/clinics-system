<?php

namespace App\Providers;
use Validator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    App::singleton('clinic_id', function () {
      return Auth::user()->clinic->id;
    });
    Validator::extend('without_spaces', function($attr, $value){
      return preg_match('/^\S*$/u', $value);
  });
     Paginator::useBootstrapFive();
     Paginator::useBootstrapFour();

  }
}
