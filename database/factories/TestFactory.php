<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Test;
use MoonShine\Laravel\Models\MoonshineUser;

class TestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Test::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'time_limit' => $this->faker->numberBetween(30, 180), // от 30 до 180 минут
            'teacher_id' => MoonshineUser::factory(),
            'status' => $this->faker->randomElement(['available', 'not_available', 'completed']),
        ];
    }

    /**
     * Указывает, что тест доступен
     */
    public function available()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'available',
            ];
        });
    }

    /**
     * Указывает, что тест недоступен
     */
    public function notAvailable()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'not_available',
                'available_from' => now()->addWeek(), // будет доступен через неделю
                'available_until' => now()->addWeeks(2), // доступен до через 2 недели
            ];
        });
    }

    /**
     * Указывает, что тест завершен
     */
    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'completed',
                'available_from' => now()->subWeeks(2), // был доступен 2 недели назад
                'available_until' => now()->subWeek(), // перестал быть доступным неделю назад
            ];
        });
    }

    /**
     * Указывает конкретного учителя
     */
    public function forTeacher($teacherId)
    {
        return $this->state(function (array $attributes) use ($teacherId) {
            return [
                'teacher_id' => $teacherId,
            ];
        });
    }

    /**
     * Указывает лимит времени
     */
    public function withTimeLimit($minutes)
    {
        return $this->state(function (array $attributes) use ($minutes) {
            return [
                'time_limit' => $minutes,
            ];
        });
    }

    /**
     * Указывает период доступности
     */
    public function withAvailability($from, $until)
    {
        return $this->state(function (array $attributes) use ($from, $until) {
            return [
                'available_from' => $from,
                'available_until' => $until,
            ];
        });
    }
}
