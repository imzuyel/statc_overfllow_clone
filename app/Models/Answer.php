<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = [
        'body',
        'user_id',

    ];
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function boot()
    {
        parent::boot();
        static::created(function ($answer) {
            $answer->question->increment('answer_count');
            $answer->question->save();
        });
        static::deleted(function ($answer) {
            $question = $answer->question;
            $question->decrement('answer_count');
            if ($question->best_answer_id === $answer->id) {
                $question->best_answer_id = null;
                $question->save();
            }

        });

    }
    public function getStatusAttribute(){
        return $this->id===$this->question->best_answer_id ? 'accept':'';
    }
    public function getIsBestAttribute(){
        return $this->id===$this->question->best_answer_id;
    }
    public function getCreateDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    public function getUrlAttribute()
    {
        return route('questions.show', $this->slug);
    }


}
