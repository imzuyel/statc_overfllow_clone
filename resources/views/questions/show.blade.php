@push('css')
<link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/prism1.css') }}" rel="stylesheet">
@endpush

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4>{{ $question->title }}</h4>
                        <div class="ml-auto">
                            <a class="btn btn-info" href="{{ route('questions.index') }}">QUESTIONS</a>
                        </div>
                    </div>
                </div>
                <div class="media p-3">
                    <div class="d-flex flex-column vote-controll">
                        <a href="" class="vote-up">
                            <i style="color: gray !important; " class="fa fa-caret-up fa-3x" aria-hidden="true"></i>
                        </a>
                        <span class="votes-count">{{ $question->votes_count }}</span>
                        <a href="" class="vote-down off">
                            <i style="color: gray !important; " class="fa fa-caret-down fa-3x" aria-hidden="true"></i>
                        </a>
                        <a  class="mt-3  {{  ($question->is_favorited) ? 'favourite' : 'favourite_none' }}"
                            onclick="event.preventDefault();document.getElementById('favorite.question-{{ $question->id }}').submit()">
                            <form id="favorite.question-{{ $question->id}}" style="display: none;"
                                action="/question/{{ $question->id }}/favorites" method="POST">
                                @csrf
                                @if ($question->is_favorited)
                                @method('DELETE')
                                @endif
                            </form>
                            <i class="fa fa-star fa-2x" aria-hidden="true"></i>
                            <span class="favorited">
                                {{ $question->favorites_count }}
                            </span>
                        </a>


                    </div>

                    <div class=" media-body">
                        <span class="line-numbers"> {!!$question->body!!}</span>
                        <div class="float-right mt-4">
                            <span class="text-muted">
                                Asked {{ $question->create_date }}
                            </span>
                            <div class="media">
                                <a href="{{ $question->user->ulr }}">
                                    <img src="{{ asset('/') }}images/user.png "
                                        style="height: 30px; width: 30px;border-radius: 30px" alt="supplier Image">
                                </a>
                                <div class="media-body">
                                    <a href="{{ $question->user->ulr }}">
                                        {{ $question->user->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-title">
                    <h2>Your answer</h2>
                    <form action="{{ route('questions.answers.store',$question->id) }}" method="POST">
                        @csrf
                        @include('layouts.message')
                        <div class="form-group">

                            <textarea class="form-control @error('body') is-invalid @enderror" id="body"
                                name="body">{{ old('body') }}</textarea>
                            @error('body')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <button class="btn  btn-outline-info m-1 float-right" type="submit">Submit</button>
                        </div>

                    </form>
                </div>
                <h5 class="card-header">{{ $question->answer_count }}
                    {{ Str::plural('Answer',$question->answer_count) }}
                </h5>
                <div class="card-body">

                    @foreach ($answers as $answer)
                    <div class="media">
                        <div class="d-flex flex-column vote-controll">
                            <a href="" class="vote-up">
                                <i style="color: gray !important; " class="fa fa-caret-up fa-3x" aria-hidden="true"></i>
                            </a>
                            <span class="votes-count">{{ $question->votes_count }}</span>
                            <a href="" class="vote-down off mb-4">
                                <i style="color: gray !important; " class="fa fa-caret-down fa-3x"
                                    aria-hidden="true"></i>
                            </a>
                            @can('accept', $answer)
                            <a href="{{ route('answer.accept',['aid'=>$answer->id,'qid'=>$question->id]) }}"
                                class="none {{ $answer->status }}">
                                <i style="font-size: 20px" class="fa fa-check fa-2x" aria-hidden="true"></i>
                            </a>
                            @else
                            @if ($answer->is_best)
                            <a title="Best answer" style="cursor: not-allowed;text-decoration: none;"
                                class="none {{ $answer->status }}">
                                <i style="font-size: 20px" class="fa fa-check fa-2x" aria-hidden="true"></i>
                            </a>
                            @endif
                            @endcan
                        </div>
                        <div class="media-body">

                            <span class="line-numbers"> {!!$answer->body!!}</span>

                            <div class="row">
                                <div class="col-md-4">
                                    <div>
                                        <span>
                                            <form class="form-inline"
                                                action="{{ route('questions.answers.destroy',[$question->id,$answer->id]) }}"
                                                method="POST">
                                                @can('update',$answer)
                                                <a href="{{ route('questions.answers.edit',[$question->id,$answer->id]) }}"
                                                    class="btn btn-sm btn-outline-danger" href=""><i
                                                        class="fas fa-edit"></i>
                                                </a>
                                                @endcan
                                                @csrf
                                                @method('DELETE')
                                                @can('delete', $answer)
                                                <button onclick="return confirm('Are you sure ')"
                                                    class="btn btn-sm btn-outline-info ml-1"><i class="fa fa-trash"
                                                        aria-hidden="true"></i></button>
                                                @endcan
                                            </form>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="float-right mt-4">
                                <span class="text-muted">
                                    Answerd {{ $answer->create_date }}
                                </span>
                                <div class="media">
                                    <a href="{{ $answer->user->ulr }}">
                                        <img src="{{ asset('/') }}images/user.png "
                                            style="height: 30px; width: 30px;border-radius: 30px" alt="supplier Image">
                                    </a>
                                    <div class="media-body">
                                        <a href="{{ $answer->user->ulr }}">
                                            {{ $answer->user->name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    @endforeach


                </div>
            </div>
        </div>
    </div>

    @endsection


    @push('js')

    <script src="{{ asset('/') }}js/all.min.js"></script>
    <script src="{{ asset('/') }}js/prism1.js"></script>
    {{--  <script>
        Prism.hooks.add('after-highlight', function (env) {
        var pre = env.element.parentNode;
        if (!pre || !/pre/i.test(pre.nodeName) || pre.className.indexOf('line-numbers') === -1) {
            return;
        }

        var linesNum = (1 + env.code.split('\n').length);
        var lineNumbersWrapper;

        lines = new Array(linesNum);
        lines = lines.join('<span></span>');

        lineNumbersWrapper = document.createElement('span');
        lineNumbersWrapper.className = 'line-numbers-rows';
        lineNumbersWrapper.innerHTML = lines;

        if (pre.hasAttribute('data-start')) {
            pre.style.counterReset = 'linenumber ' + (parseInt(pre.getAttribute('data-start'), 10) - 1);
        }

        env.element.appendChild(lineNumbersWrapper);

        });
    </script>  --}}
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'body', {
        filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
        });
    </script>

    @endpush
