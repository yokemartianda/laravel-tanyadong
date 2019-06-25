@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h1>Edit Answer For Question: <strong> {{ $question->title }} </strong></h1>
                    </div>
                    <form action="{{ route('questions.answers.update', [$question->id, $answer->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <textarea name="body" rows="7" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}">{{ old('body', $answer->body) }}</textarea>
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('body') }}</strong>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-outline-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection