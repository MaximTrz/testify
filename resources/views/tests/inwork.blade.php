@extends('layouts.app')

@section('content')
    <div class="page">
        <h2 class="page__title">Заданные тесты</h2>

        @if($tests->isEmpty())
            <div class="message message--info">
                У вас пока нет доступных тестов.
            </div>
        @else

        <div class="tests">

            <ul class="tests__list">
                @foreach($tests as $test)
                    <li class="tests__item">
                        <a href="{{ route('tests.show', $test->id) }}" class="tests__link">
                            <strong class="tests__title">{{ $test->title }}</strong>
                            <div class="tests__time">
                                <span class="tests__time-label">Срок выполнения:</span>
                                <span class="tests__time-start">с {{ \Carbon\Carbon::parse($test->pivot->available_from)->format('d.m.Y H:i') }}
                                 до {{ \Carbon\Carbon::parse($test->pivot->available_until)->format('d.m.Y H:i') }}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>

        </div>

        @endif
    </div>

@endsection
