@push('css')

@endpush

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4>Edit your Answer here</h4>
                        <div class="ml-auto">
                            <a class="btn btn-info" href="{{ route('questions.index') }}">All QUESTIONS</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('questions.answers.update',[$question->id,$answer->id]) }}" method="POST">
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label for="questions-body">Update your answer</label>
                            <textarea class="form-control @error('body') is-invalid @enderror" id="body"
                                name="body">{{ $answer->body }}</textarea>
                            @error('body')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-lg btn-outline-info" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('js')

<script src="{{ asset('/') }}js/jquery.js"></script>
<script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace( 'body', {
    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
    filebrowserUploadMethod: 'form'
    });
</script>


@endpush