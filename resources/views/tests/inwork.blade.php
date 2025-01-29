@extends('layouts.app')

@section('content')
    <div class="tests">
        @if($tests->isEmpty())
            <p class="tests__nothing">Нет доступных тестов.</p>
        @else
            <ul class="tests__list">
                @foreach($tests as $test)
                    <li class="tests__item">
                        <a href="{{ route('tests.show', $test->id) }}" class="tests__link">
                            <strong class="tests__title">Тест: {{ $test->title }}</strong>
                            <div class="tests__time">
                                Срок выполнения:
                                с {{ \Carbon\Carbon::parse($test->pivot->available_from)->format('d.m.Y H:i') }}
                                до
                                {{ \Carbon\Carbon::parse($test->pivot->available_until)->format('d.m.Y H:i') }}
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
