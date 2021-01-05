<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {

        $question->answers()->create($request->validate([
            'body' => 'required',
        ]) + ['user_id' => Auth::id()]);
        return back()->with('success', "Your question is posted succesfully");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, Answer $answer)
    {

        return view('answer.edit', compact('question', 'answer'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->validate($request, [

            "body" => "required",
        ], [

            "body.required" => "You must ask question here",
        ]);
        $this->authorize('update', $answer);
        $answer->update($request->only('body'));
        return redirect()->route('questions.show', $question->slug)->with('success', "Your answer is update succesfully");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);
        $answer->delete();
        return back()->with('error', "Your question is deleted succesfully");

    }

    public function store_favorite(Question $question)
    {
        $question->favorites()->attach((Auth()->id()));
        return back()->with('success', 'You succesfully added  favorite question');
    }
    public function delete_favorite(Question $question)
    {
        $question->favorites()->detach((Auth()->id()));
        return back()->with('success', 'You succesfully remove  favorite question');

    }

    public function acceptAnswer($aid, $qid)
    {
        $question = Question::where('id', $qid)->first();
        $get_user = User::where('id', $question->user_id)->first();

        if ($get_user) {
            $question->best_answer_id = $aid;
            $question->save();
            return back()->with('success', 'You succesfully selected best answer');
        }

    }

}
