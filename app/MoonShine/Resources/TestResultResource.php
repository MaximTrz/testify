<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;



use App\Models\TestResult;


use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;

use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Number;

use MoonShine\Laravel\Enums\Ability;

use Illuminate\Contracts\Database\Eloquent\Builder;

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
            Number::make('Правильных ответов', 'score'),
            Number::make('Оценка', 'grade')->disabled()
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
                BelongsTo::make('Тест', 'test', resource: TestResource::class, formatted:  'title')->disabled(),
                BelongsTo::make('Студент', 'user', resource: UserResource::class, formatted:  'name')->disabled(),
                Number::make('Правильных ответов', 'score')->disabled(),
                Number::make('Оценка', 'grade')->disabled()
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            BelongsTo::make('Тест', 'test', resource: TestResource::class, formatted:  'title' )->disabled(),
            BelongsTo::make('Студент', 'user', resource: UserResource::class, formatted:  'name')->disabled(),
            Number::make('Правильных ответов', 'score')->disabled(),
            Number::make('Оценка', 'grade')->disabled(),
            HasMany::make('Ответы студента', 'answers', resource: StudentAnswerResource::class)
        ];
    }



    protected function filters(): iterable
    {
        return [
            BelongsTo::make('Тест', 'test', resource: TestResource::class, formatted: 'title')
            ->valuesQuery(function (Builder $query, BelongsTo $field) {

                if (auth()->user()->moonshine_user_role_id === 1) {
                    return $query;
                }

                return $query->where('teacher_id', auth()->id());
            })->nullable(),
            BelongsTo::make('Студент', 'user', resource: UserResource::class, formatted:  'name')
                ->nullable(),
            BelongsTo::make('Группа', 'group', resource: GroupResource::class, formatted:  'name')
                ->nullable(),
        ];
    }

    protected function modifyQueryBuilder(Builder $builder): Builder
    {

        if (auth()->user()->moonshine_user_role_id === 1) {
            return $builder;
        }

        return $builder->where('teacher_id', auth()->id());
    }

    // Отключаем возможность создания новой записи
    public function can(Ability|string $ability): bool
    {
        // Запрещаем создание и редактирование записей
        if (in_array($ability, [Ability::CREATE, Ability::UPDATE, 'create', 'update'])) {
            return false;
        }

        return parent::can($ability); // Передаем остальные действия в родительский метод
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
