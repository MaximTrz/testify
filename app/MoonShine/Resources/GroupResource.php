<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Group;

use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Group>
 */
class GroupResource extends ModelResource
{
    protected string $model = Group::class;

    protected string $title = 'Группы';

    protected bool $withPolicy = true;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            //ID::make()->sortable(),
            Text::make('Наименование', 'name'),
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
                Text::make('Наименование', 'name'),
                HasMany::make('Студенты', 'users', resource: UserResource::class)->creatable()
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            //ID::make(),
            Text::make('Наименование', 'name'),
            HasMany::make('Студенты', 'users', resource: UserResource::class)
        ];
    }

    /**
     * @param Group $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
