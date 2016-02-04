<?php

namespace NineCells\SimpleBoard\Http\Controllers;

use Auth;
use NineCells\SimpleBoard\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function get_board_list()
    {
        $boards = Board::orderBy('id', 'desc')->paginate(10);
        return view('ncells::sboard.pages.board_list', ['boards' => $boards]);
    }
}
