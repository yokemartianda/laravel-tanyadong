<div class="media post">
    <div class="d-flex flex-column counters">
        <div class="vote">
            <strong>{{$question->votes_count}}</strong> {{str_plural('vote', $question->votes_count)}}
        </div>
        <div class="status {{$question->status}}">
                <strong>{{$question->answers_count}}</strong> {{str_plural('answer', $question->answers_count)}}
        </div>
        <div class="view">
                {{$question->views ." ". str_plural('view', $question->views)}}
        </div>
    </div>
    <div class="media-body">
        <div class="d-flex align-items-center">
            <h3 class="mt-0"><a href="{{$question->url}}"> {{$question->title}} </a></h3>
            <div class="ml-auto">
            </div>
        </div>
        <p class="lead">
            Ditanyakan oleh
            <a href="{{$question->user->url}}">{{$question->user->name}}</a>
            <small class="text-muted">{{$question->created_date}}</small>
        </p>
        {{ $question->excerpt(300) }}
    </div>
</div>