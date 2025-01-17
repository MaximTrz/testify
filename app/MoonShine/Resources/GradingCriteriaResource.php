<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\GradingCriteria;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Number;

/**
 * @extends ModelResource<GradingCriteria>
 */
class GradingCriteriaResource extends ModelResource
{
    protected string $model = GradingCriteria::class;

    protected string $title = 'GradingCriteria';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            Number::make('от', 'min_correct_answers'),
            Number::make('до', 'max_correct_answers '),
            Number::make('Оценка', 'grade')->sortable(),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Number::make('от', 'min_correct_answers'),
                Number::make('до', 'max_correct_answers '),
                Number::make('Оценка', 'grade'),
                BelongsTo::make('Тест', 'test', resource: TestResource::class)
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
            Number::make('от', 'min_correct_answers'),
            Number::make('до', 'max_correct_answers '),
            Number::make('Оценка', 'grade')
        ];
    }

    /**
     * @param GradingCriteria $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
