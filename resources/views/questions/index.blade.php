@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h3>All QUESTIONS</h3>
                        <div class="ml-auto">
                            <a class="btn btn-info" href="{{ route('questions.create') }}">Ask Questions</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('layouts.message')
                    @foreach ($questions as $item)
                    <div class="media">
                        <div class="d-flex flex-column counters">
                            <div class="vote">
                                <strong>{{ $item->votes_count }}</strong>
                                {{ Str::plural('vote',$item->votes_count) }}
                            </div>
                            <div class="status {{ $item->status }}">
                                <strong>{{ $item->answer_count }}</strong>
                                {{ Str::plural('answer',$item->answer_count) }}
                            </div>
                            <div class="views">
                                {{ $item->views }}
                                {{ Str::plural('view',$item->views) }}
                            </div>
                        </div>
                        <div class="media-body">
                            <div class="d-flex align-items-center">
                                <h3 class="mt-0">
                                    <a href="{{ $item->url }}">
                                        {{ $item->title }}
                                    </a>
                                </h3>
                                @can('update', $item)
                                <div class="ml-auto">
                                    <a href="{{ route('questions.edit',$item->id) }}"
                                        class="btn btn-sm btn-outline-info" href="">edit</a>
                                </div>
                                @endcan
                                @can('delete', $item)
                                <form class="form-delete" action="{{ route('questions.destroy',$item->id) }}"
                                    method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button onclick="return confirm('Are you sure ')"
                                        class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                                @endcan
                            </div>
                            {!!Str::limit($item->body,250)!!}
                            <div class="float-right mt-4">
                                <span class="text-muted">
                                    Asked {{ $item->create_date }}
                                </span>
                                <div class="media">
                                    <a href="{{ $item->user->ulr }}">
                                        <img src="{{ asset('/') }}images/user.png " style="height: 30px; width: 30px;border-radius: 30px"
                                            alt="supplier Image">
                                    </a>
                                    <div class="media-body">
                                        <a href="{{ $item->user->ulr }}">
                                            {{ $item->user->name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                    <hr>
                    @endforeach

                    <div class="">
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
