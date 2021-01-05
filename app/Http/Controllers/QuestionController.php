<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
// use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct(){
        return $this->middleware('auth',[
            'except'=>['index','show']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::latest()->paginate(7);
        return view('questions.index', [
            "questions" => $questions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "title" => "required",
            "body" => "required",
        ], [
            "title.required" => "You can't bland this field",
            "body.required" => "You must ask question here",
        ]);
        $request->user()->questions()->create($request->only('title', 'body'));
        return redirect()->route('questions.index')->with('succes', "Your question is Submitted");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
   $answers=Answer::latest()->where('question_id',$question->id)->get();

        return view('questions.show',[
            'answers'=>$answers,
            'question'=>$question,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {

        $this->authorize('update', $question);
        return view('questions.edit', compact('question'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $this->validate($request, [
            "title" => "required",
            "body" => "required",
        ], [
            "title.required" => "You can't bland this field",
            "body.required" => "You must ask question here",
        ]);
        $this->authorize('update', $question);
        $question->update($request->only('title', 'body'));
        return redirect()->route('questions.index')->with('success', "Your question is update succesfully");

    }

    /**isan serve
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {


        $this->authorize('delete', $question);
        $question->delete();
        return redirect()->route('questions.index')->with('success', "Your question is deleted succesfully");

    }
}
