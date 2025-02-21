<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;


use App\Models\Question;



use MoonShine\Laravel\Fields\Relationships\BelongsTo;

use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Checkbox;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Question>
 */
class QuestionResource extends ModelResource
{
    protected string $model = Question::class;

    protected string $title = 'Вопросы';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            Text::make('Текст вопроса', 'question_text'),
            HasMany::make('Варианты ответа', 'Answers', resource: AnswerResource::class)->creatable()
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
                Text::make('Текст вопроса', 'question_text'),
                Number::make('Время', 'time_limit'),

                //HasMany::make('Варианты ответа', 'Answers', resource: AnswerResource::class)->creatable(),

                RelationRepeater::make(
                    'Варианты ответа',
                    'Answers',
                    resource: AnswerResource::class
                )->fields([
                    Text::make('Текст ответа', 'answer_text'),
                    Checkbox::make('Верный', 'is_correct'),
                ]),

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
            Text::make('Текст вопроса', 'question_text'),
        ];
    }

    /**
     * @param Question $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
