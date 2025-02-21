<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\TestResult;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Number;

/**
 * @extends ModelResource<TestResult>
 */
class TestResultResource extends ModelResource
{
    protected string $model = TestResult::class;

    protected string $title = 'TestResults';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            //ID::make()->sortable(),
            BelongsTo::make('Студент', 'user', resource: UserResource::class, formatted:  'name'),
            BelongsTo::make('Тест', 'test', resource: TestResource::class, formatted:  'title'),
            Number::make('Правильных ответов', 'score')
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
                BelongsTo::make('Тест', 'test', resource: TestResource::class)->disabled(),
                BelongsTo::make('Студент', 'user', resource: UserResource::class, formatted:  'name')->disabled(),
                Number::make('Правильных ответо', 'score')->disabled()
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
     * @param TestResult $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
