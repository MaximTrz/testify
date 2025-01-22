@extends('layouts.app')

@section('content')

            <div class="flex-shrink-0 p-3 bg-white">
                <div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                </div>
            </div>

@endsection
