<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function getUrlAttribute()
    {
        // return route("questions.show", $this->id);
        return "#";
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function getAvatarAttribute()
    {
        $email = $this->email;
        $size = 32;

        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;

    }

    public function favorites()
    {
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps();
    }

    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class, 'votables');
    }

    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class, 'votables');
    }

    public function questionVote(Question $question, $vote)
    {
        $voteQuestions = $this->voteQuestions();
        if ($voteQuestions->where('votables_id', $question->id)->exists())
        {
            $voteQuestions->updateExistingPivot($question, ['vote' => $vote ]);
        }
        else
        {
            $voteQuestions->attach($question, ['vote' => $vote]);
        }

        $question->load('votes');
        $downVotes = (int) $question->downVotes()->sum('vote');
        $upVotes = (int) $question->upVotes()->sum('vote');

        $question->votes_count = $upVotes + $downVotes;
        $question->save();
    }

    public function answerVote(Answer $answer, $vote)
    {
        $voteAnswers = $this->voteAnswers();
        if ($voteAnswers->where('votables_id', $answer->id)->exists())
        {
            $voteAnswers->updateExistingPivot($answer, ['vote' => $vote ]);
        }
        else
        {
            $voteAnswers->attach($answer, ['vote' => $vote]);
        }

        $answer->load('votes');
        $downVotes = (int) $answer->downVotes()->sum('vote');
        $upVotes = (int) $answer->upVotes()->sum('vote');

        $answer->votes_count = $upVotes + $downVotes;
        $answer->save();
    }
}
