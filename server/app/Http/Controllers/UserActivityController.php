<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class UserActivityController extends Controller
{

    /**
     * Save the user's answers to a quiz
     * 
     * @param Request $request
     * @param int $quiz_id The ID of the quiz
     * @return \Illuminate\Http\JsonResponse A JSON response with a message
     * 
     */
    public function save(Request $request, Quiz $quiz)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|integer',
            'answers.*.answer' => 'required|string|nullable',
        ]);

        $user_id = auth()->user()->id;

        // check if the user has already taken this quiz
        $activity = \App\Models\UserActivity::where('user_id', $user_id)
            ->where('quiz_id', $quiz->id)
            ->first();

        // If the user has already taken this quiz, return an error
        if ($activity) {
            return response()->json(['message' => 'User has already taken this quiz'], 400);
        }

        // Save the user's activity
        $activity = new \App\Models\UserActivity();
        $activity->user_id = $user_id;
        $activity->quiz_id = $quiz->id;
        $activity->answers = $request->input('answers');
        $activity->save();

        return response()->json(['message' => 'Activity saved']);
    }


    /**
     * Get the user's activity for a quiz
     * 
     * @param Request $request
     * @param int $quiz_id The ID of the quiz
     * 
     * @return \Illuminate\Http\JsonResponse The user's activity for the quiz with the quiz questions and correct answers
     */
    public function get(Request $request, Quiz $quiz)
    {
        $user_id = auth()->user()->id;

        // Load the quiz questions
        $quiz->load('questions');

        // Load the user activity for this quiz
        $activity = $quiz->userActivities()->where('user_id', $user_id)
            ->first();

        if (!$activity) {
            return response()->json(['message' => 'No activity found for this quiz'], 404);
        }

        // Merge the quiz and activity
        foreach ($quiz->questions as &$q) {
            // Make the 'correct_answer' visible for each question
            $q->makeVisible('correct_answer');

            $q->user_answer = null;
            foreach ($activity->answers as $a) {
                if ($a['question_id'] === $q->id) {
                    $q->user_answer = $a['answer'];
                    break;
                }
            }

            // Add a 'is_correct' property to each question
            $q->is_correct = $q->correct_answer === $a['answer'];
        }

        return response()->json($quiz);
    }
}
