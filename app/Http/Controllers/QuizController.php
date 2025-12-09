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
        dump($tableData);
        dump($tableData->answers);
        return view("quiz");
    }

    //get the id
    //get data from quiz data base for the data
    //send this data to the view


    //receive send data
    //if tue or false
    //set boolean of user_cards?
}
