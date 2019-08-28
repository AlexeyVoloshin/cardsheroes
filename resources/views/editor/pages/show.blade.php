
@extends('editor.editor-index')

@section('title', 'show')

@section('content')
        @isset($hero)
            <div class="card border-primary col-md-6 "   >
                <div class="card-body">
                    <img  src="{{$hero->image != '' ? asset('storage/uploads/' . $hero->image) : asset('storage/img/question.png') }}" class="card-img-top col-md-6 float-left" >
                    <div style="padding-top: 10px">
                        <h5 class="card-title" >Псевдоним: {{$hero->nickname}}</h5>
                        <h5 class="card-title">Имя: {{$hero->real_name}}</h5>
                        <p class="card-text">Описание: {{$hero->original_description}}</p>
                        <p class="card-text">Супер сила: {{$hero->superpower}}</p>
                        <p class="card-text">Коронная фраза: {{$hero->catch_phrase}}</p>
                        <a href="{{URL::to('editor-hero/'. $hero->id). '/edit'}}" style="float: left; margin-right: 5px" class=" btn btn-outline-info btn-inf  ">Изменить</a>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['editor-hero.destroy', $hero->id]]) !!}
                        {!! Form::submit('Удалить', ['class' => 'btn btn-danger '] ) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        @endisset
@endsection

