<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRoleResource;
use App\MoonShine\Resources\GroupResource;
use App\MoonShine\Resources\GroupStudentResource;
use App\MoonShine\Resources\UserResource;
use App\MoonShine\Resources\TestResource;
use App\MoonShine\Resources\QuestionResource;
use App\MoonShine\Resources\AnswerResource;
use App\MoonShine\Resources\GradingCriteriaResource;
use App\MoonShine\Resources\TestResultResource;
use App\MoonShine\Resources\TestGroupResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  MoonShine  $core
     * @param  MoonShineConfigurator  $config
     *
     */
    public function boot(CoreContract $core, ConfiguratorContract $config): void
    {
        // $config->authEnable();
        $config->locale('ru');
        $core
            ->resources([
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                GroupResource::class,
                UserResource::class,
                TestResource::class,
                QuestionResource::class,
                AnswerResource::class,
                GradingCriteriaResource::class,
                TestResultResource::class,
                TestGroupResource::class,
            ])
            ->pages([
                ...$config->getPages(),
            ])
        ;

    }
}
