<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\TestGroup;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;

/**
 * @extends ModelResource<TestGroup>
 */
class TestGroupResource extends ModelResource
{
    protected string $model = TestGroup::class;

    protected string $title = 'Заданные тесты';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            //ID::make()->sortable(),
            BelongsTo::make('Группа', 'group', resource: GroupResource::class, formatted: 'name'),
            BelongsTo::make('Тест', 'test', resource: TestResource::class, formatted: 'title'),
            Date::make('Доступен с', 'available_from')->withTime()->format('d-m-Y H:i'),
            Date::make('Доступен по', 'available_until')->withTime()->format('d-m-Y H:i'),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                //ID::make(),
                BelongsTo::make('Группа', 'group', resource: GroupResource::class, formatted: 'name'),
                BelongsTo::make('Тест', 'test', resource: TestResource::class, formatted: 'title'),
                Date::make('Доступен с', 'available_from')->withTime()->required(),
                Date::make('Доступен по', 'available_until')->withTime()->required()
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
        ];
    }

    /**
     * @param TestGroup $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
