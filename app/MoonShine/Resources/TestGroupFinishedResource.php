<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Contracts\Database\Eloquent\Builder;

use App\Models\TestGroup;

use MoonShine\Laravel\Enums\Ability;

/**
 * @extends ModelResource<TestGroup>
 */
class TestGroupFinishedResource extends TestGroupResource
{
    protected string $model = TestGroup::class;

    protected string $title = 'Завершенные';

    protected function modifyQueryBuilder(Builder $builder): Builder
    {
        // Фильтруем записи, чтобы показывать только те, где available_until > текущей даты
        $builder->where(function ($query) {
            $query->where('available_until', '<=', now())
                ->orWhereNull('available_until'); // Если нужно учитывать записи без даты
        });

        // Проверяем роль пользователя
        if (auth()->user()->moonshine_user_role_id !== 1) {
            $builder->where('teacher_id', auth()->id());
        }

        return $builder;
    }

    // Отключаем возможность создания новой записи
    public function can(Ability|string $ability): bool
    {
        if ($ability === Ability::CREATE || $ability === 'create') {
            return false; // Запрещаем создание записей
        }

        return parent::can($ability); // Передаем остальные действия в родительский метод
    }


}
