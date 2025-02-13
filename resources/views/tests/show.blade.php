@extends('layouts.app')

@section('content')
    <div class="test">
        <h1 class="test__title">Тест: {{ $test->title }}</h1>
        <p class="test__time">
            <strong class="test__time-title">Срок выполнения:</strong>
            с {{ \Carbon\Carbon::parse($test->pivot->available_from)->format('d.m.Y H:i') }}
            до {{ \Carbon\Carbon::parse($test->pivot->available_until)->format('d.m.Y H:i') }}
        </p>

        <div class="test__instruction">
            <strong class="test__instruction-title">Инструкция: </strong>
            <p class="test__instruction-block">Количество вопросов: {{ $test->questions_count }} </p>
            <p class="test__instruction-block">
                Исправить выбранный ответ невозможно.
            </p>
            <p class="test__instruction-block">
                Тест проводится с ограничением по времени, при этом для каждого вопроса отводится определённое количество времени, которое зависит от его сложности.
            </p>
        </div>

        @if($test->gradingCriteria->isNotEmpty())
            <div class="test__criteria">
                <h3 class="test__criteria-title">Критерии оценки:</h3>
                <ul class="test__criteria-list">
                    @foreach($test->gradingCriteria as $criteria)
                        <li class="test__criteria-item">
                            {{ $criteria->min_correct_answers }}-{{ $criteria->max_correct_answers  }} верных ответов - {{ $criteria->grade }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="test__criteria">
                <h3 class="test__criteria-title">Критерии оценки не заданы</h3>
            </div>
        @endif

        <div class="test__start">
            <a href="/tests/{{$test->id}}/questions" class="start">
                <img class="start__icon" src="{{ asset('img/start.svg') }}" alt="start">
                Начать тестирование
            </a>
        </div>

    </div>
@endsection
