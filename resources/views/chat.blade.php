@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></div>
                
                <div class="card-body">
                    <h1>Чат c пользователем {{ $user->name }}</h1>

                    <div >
                        @foreach ($messages as $message)
                            <div class="
                                @if ($message->user_id == Auth::id())
                                    text-primary pl-1
                                @else
                                    text-success pl-5
                                @endif
                                "
                            >{{ $message->message }}</div>


                            
                        @endforeach
                    </div>

                    <div class="mt-4 mb-2">Отправить сообщение</div>
                    <form method="post" action="{{ route('message', ['userHostId' => $user->id]) }}" >
                        @csrf
                            <div class="form-group">
                                <textarea class="form-control" name = "message"
                                    placeholder="Ваше сообщения" rows = "2" required></textarea>
                            </div>
                            <div class = "form-group">
                                <button type = "submit" class = "btn btn-primary">Отправить</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection