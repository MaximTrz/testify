<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Test;


use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;

use Illuminate\Contracts\Database\Eloquent\Builder;



/**
 * @extends ModelResource<Test>
 */
class TestResource extends ModelResource
{
    protected string $model = Test::class;

    protected string $title = 'Тесты';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            //ID::make()->sortable(),
            Text::make('Название', 'title'),
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
                Text::make('Название', 'title'),
                HasMany::make('Вопросы', 'Questions',  resource: QuestionResource::class)->creatable(),
                HasMany::make('Критерии оценки', 'GradingCriteria', resource: GradingCriteriaResource::class)->creatable()
            ])
        ];
    }

    public function beforeCreating(mixed $item): mixed
    {
        if ($item instanceof Test) {
            $item->teacher_id = auth()->id();
        }

        return $item;
    }

    protected function modifyQueryBuilder(Builder $builder): Builder
    {

        if (auth()->user()->moonshine_user_role_id === 1) {
            return $builder;
        }

        return $builder->where('teacher_id', auth()->id());
    }


//    public function newQuery(): Builder
//    {
//        $query = parent::newQuery();
//
//        if (auth()->user()->moonshine_user_role_id !== 1) {
//            $query->where('teacher_id', auth()->id());
//        }
//
//        return $query;
//    }


    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Название', 'title'),
            HasMany::make('Вопросы', 'Questions',  resource: QuestionResource::class)->creatable(),
            HasMany::make('Критерии оценки', 'GradingCriteria', resource: GradingCriteriaResource::class)->creatable()
        ];
    }

    /**
     * @param Test $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
