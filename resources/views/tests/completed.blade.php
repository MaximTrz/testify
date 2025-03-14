@extends('layouts.app')

@section('content')
    <div class="page">
        <h2 class="page__title">Выполненные тесты</h2>

        @if($results->isEmpty())
            <div class="message message--info">
                У вас пока нет завершенных тестов с оценкой.
            </div>
        @else
            <ul class="test-list">
                @foreach($results as $result)
                    <li class="test-list__item">
                        <div class="test-list__info">
                            <!-- Проверяем, есть ли заголовок теста -->
                            <strong class="test-list__title">{{ $result->test->title ?? 'Удаленный тест' }}</strong>
                            <div class="test-list__score-value">
                                Правильных ответов: <span>{{ $result->score }}</span>
                            </div>
                            <div class="test-list__date">
                                Завершено: <span>{{ Carbon\Carbon::parse($result->completed_at)->format('d.m.Y H:i') }}</span>
                            </div>
                        </div>
                        <div class="test-list__score">
                            <span class="test-list__grade">{{ $result->grade }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>

            <!-- Блок пагинации -->
            <div class="pagination">
                {{ $results->links() }}
            </div>
        @endif
    </div>

@endsection
