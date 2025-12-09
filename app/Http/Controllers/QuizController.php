<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    //
    public function showQuiz(Quiz $quiz, int $id)
    {
        $tableData = DB::table('quiz')
            ->where('card_id', '=', $id)
            ->get()
            ->first();
//        dump($tableData);
//        dump((json_decode($tableData->answers)));
        return view("quiz")->with('data', $tableData);
    }

//how to make the elements random? Or how to shuffle elements within an array?
}
