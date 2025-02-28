<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\Test;
use App\Models\TestResult;
use App\MoonShine\Resources\TestGroupResource;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Components\Heading;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Layout\LineBreak;
use MoonShine\UI\Components\Metrics\Wrapped\ValueMetric;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\Preview;
use MoonShine\UI\Fields\Text;


class Dashboard extends Page
{
    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle()
        ];
    }

    public function getTitle(): string
    {
        return $this->title ?: 'Главная';
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
	{
        return [

            Grid::make([
                Column::make(
                    [
                        ValueMetric::make('Всего тестов')->value(Test::query()->where('teacher_id', auth()->id())->count())->columnSpan(6),
                    ],
                    colSpan: 6,
                    adaptiveColSpan: 6
                ),
                Column::make(
                    [
                        ValueMetric::make('Выполнено тестов')->value(TestResult::query()->where('teacher_id', auth()->id())->count())->columnSpan(6),
                    ],
                    colSpan: 6,
                    adaptiveColSpan: 6
                ),
            ]),



            LineBreak::make(),

            Grid::make([
                Column::make(
                    [
                        TableBuilder::make()
                            ->items(Test::query()->where('teacher_id', auth()->id())->limit(10)
                                ->get()->toArray())
                            ->fields([
                                Text::make('Последние созданные тесты', 'title'),
                            ]),
                    ],
                    colSpan: 12,
                    adaptiveColSpan: 12
                ),

            ])
        ];
	}
}
