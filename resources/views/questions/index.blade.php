@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2>Semua Pertanyaan</h2>
                        <div class="ml-auto">
                            <a href="{{ route('questions.create')}}" class="btn btn-outline-secondary">Mari Bertanya</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('layouts._messages')
                    @forelse ($questions as $question)
                        @include('questions._question')
                    @empty
                        <div class="alert alert-warning">
                            <strong>Wah belum ada yang bertanya nih!</strong>
                        </div>
                    @endforelse

                    {{$questions->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
