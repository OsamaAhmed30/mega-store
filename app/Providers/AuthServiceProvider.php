<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Policies\ModelPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Category'=> 'App\Policies\ModelPolicy'
    ];
    public function register(): void
    {
    $this->app->bind('abilities',function(){
        return include(base_path('data\abilities.php'));
    });
       
    }
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void

    {

        Gate::before(function($user , $ability){
            if ($user->super_admin) {
                return true;
            }
        });


        // foreach (array_keys($this->app->make('abilities')) as $code ) {
        //     Gate::define($code,function($user) use ($code){
        //         return $user->hasAbility($code);
        //     });
        // }
       
       
    }
}
