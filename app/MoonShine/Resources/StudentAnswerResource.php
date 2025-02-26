<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\StudentAnswer;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Checkbox;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<StudentAnswer>
 */
class StudentAnswerResource extends ModelResource
{
    protected string $model = StudentAnswer::class;

    protected string $title = 'Ответы студента';

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            Checkbox::make('Верный', 'is_correct'),
            BelongsTo::make('Вопрос', 'question', resource: QuestionResource::class, formatted: 'question_text'),
            BelongsTo::make('Ответ студента', 'answer', resource: AnswerResource::class, formatted: 'answer_text'),
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
                Checkbox::make('Верный', 'is_correct'),
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
            //Text::make('Текст ответа', 'answer_text'),
            Checkbox::make('Верный', 'is_correct'),
            //BelongsTo::make('Вопрос', 'question', resource: QuestionResource::class)->creatable()
        ];
    }

    /**
     * @param StudentAnswer $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
