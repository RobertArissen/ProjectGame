<?php

namespace App\Http\Controllers\API;

use App\Question;
use App\User;
use App\UsersQuestions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{

    public function unansweredByUser(Request $request)
    {
        $periodsId = $request->user()->class->periods_id;

        $answeredQuestionIds = User::find($request->user()->id)->answeredQuestions()
            ->where('periods_id', '=', $periodsId)
            ->pluck('question_id')->toArray();

        $unansweredQuestions = Question::where('period_id', '=', $periodsId)
            ->whereNotIn('id', $answeredQuestionIds)
            ->with(['answers'=>function($query){
                $query->select('id', 'name', 'question_id')->inRandomOrder();
            }])
            ->with(['type'=>function($query){
                $query->select('id', 'inCode');
            }])
            ->get(['id','name','points','questionType_id']);

        $unansweredQuestions = $unansweredQuestions->all();
        shuffle($unansweredQuestions);

        return $unansweredQuestions;
    }

    public function answer(Request $request)
    {
        $userQuestion = User::find($request->user()->id)->answeredQuestions()
            ->where('question_id', $request->questionId)
            ->pluck('question_id')->toArray();
    
        if (!empty($userQuestion)) {
            return response()->json(
                ['success' => false, 'error' => 'Je hebt deze vraag al beantwoord.', ]
            );
        }

        $question = Question::where('id', $request->questionId)->first();
        $questionType = $question->type;

        $correctAnswer = $question->answers()
            ->select('id')
            ->where('correct', true)
            ->orderBy('order', 'asc')
            ->get();

        $answerIsCorrect = false;
        $pointsEarned = 0;

        $answer = $request->answer;
        
        if (!empty($answer)) {
            if ($questionType->inCode == 'sort') {
                $answerIsCorrect = true;

                foreach ($answer as $key => $element) {
                    if ($correctAnswer[$key]->id != $element['id']) {
                        $answerIsCorrect = false;
                    }
                }
                
            } else if ($questionType->inCode == 'mc'
                    || $questionType->inCode == 'tf'
                ) {
                if ($correctAnswer[0]->id == $answer["id"]) {
                    $answerIsCorrect = true;
                }

            } else {
                return response()->json(
                    ['success' => false, 'error' => 'Dit type vraag wordt niet ondersteund.', ]
                );
            }

            $user = User::FindOrFail($request->user()->id);

            UsersQuestions::create([
                'users_id' => $user->id,
                'periods_id' => $user->class->periods_id,
                'question_id' => $question->id,
                'correct' => $answerIsCorrect
            ]);

            if ($answerIsCorrect) {
                // Update user coins 
                $user->coins = $user->coins + $question->points;
                $user->save();

                $pointsEarned = $question->points;
            } 
        }

        return response()->json([
            'answerIsCorrect' => $answerIsCorrect,
            'pointsEarned' => $pointsEarned
        ]);
    }

    public function getAnswer(Request $request)
    {
        $question = Question::where('id', $request->questionId)->first();

        $correctAnswer = $question->answers()
            ->where('correct', true)
            ->orderBy('order', 'asc')
            ->get(['id', 'name']);

        return $correctAnswer;
    }

}
