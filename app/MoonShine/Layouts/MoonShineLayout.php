<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Resources\TestGroupFinishedResource;
use MoonShine\Laravel\Fields\Relationships\HasOne;
use MoonShine\Laravel\Layouts\CompactLayout;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Components\Layout\{Locales, Notifications, Profile, Search};
use MoonShine\UI\Components\{Breadcrumbs,
    Components,
    Layout\Flash,
    Layout\Div,
    Layout\Body,
    Layout\Burger,
    Layout\Content,
    Layout\Footer,
    Layout\Head,
    Layout\Favicon,
    Layout\Assets,
    Layout\Meta,
    Layout\Header,
    Layout\Html,
    Layout\Layout,
    Layout\Logo,
    Layout\Menu,
    Layout\Sidebar,
    Layout\ThemeSwitcher,
    Layout\TopBar,
    Layout\Wrapper,
    When};
use App\MoonShine\Resources\GroupResource;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use App\MoonShine\Resources\GroupStudentResource;
use App\MoonShine\Resources\UserResource;
use App\MoonShine\Resources\TestResource;
use App\MoonShine\Resources\QuestionResource;
use App\MoonShine\Resources\AnswerResource;
use App\MoonShine\Resources\GradingCriteriaResource;
use App\MoonShine\Resources\TestResultResource;
use App\MoonShine\Resources\TestGroupResource;
use App\MoonShine\Resources\StudentAnswerResource;

final class MoonShineLayout extends CompactLayout
{
    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        $user = auth()->user();
        return [

            ...($user->isSuperUser() ? parent::menu() : []),

            MenuGroup::make('Справочники', [
                MenuItem::make('Группы', GroupResource::class),
                MenuItem::make('Студенты', UserResource::class),
            ]),
            MenuItem::make('Тесты', TestResource::class),
           // MenuItem::make('Вопросы', QuestionResource::class),
            //MenuItem::make('Результаты', TestResultResource::class),
            MenuItem::make('Заданные', TestGroupResource::class),
            MenuItem::make('Завершенные', TestGroupFinishedResource::class),
            //MenuItem::make('Ответы студента', StudentAnswerResource::class),
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }

    public function build(): Layout
    {
        return parent::build();
    }
}
