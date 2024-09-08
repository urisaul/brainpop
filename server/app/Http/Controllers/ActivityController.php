<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function save(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $data['answers'] = json_encode($data['answers']);
        $quiz = \App\Models\Quiz::create($data);
        return response()->json($quiz);
    }

    public function get(Request $request)
    {
        $user_id = auth()->user()->id;
        $quiz = \App\Models\Quiz::where('user_id', $user_id)->get();
        return response()->json($quiz);
    }}
