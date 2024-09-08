<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{

    /**
     * Get a quiz with its questions
     * 
     * @param Request $request
     * @param Quiz $quiz The quiz
     * @return \Illuminate\Http\JsonResponse The quiz with its questions (correct answer is hidden)
     * 
     */
    public function get(Request $request, Quiz $quiz)
    {
        $quiz->load('questions');
        return response()->json($quiz);
    }
}
