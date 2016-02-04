<?php

namespace NineCells\SimpleBoard\Console;

use Illuminate\Console\Command;
use NineCells\SimpleBoard\Models\Board;

class DeleteBoardCommand extends Command
{
    protected $signature = 'sboard:delete_board {board_key}';

    protected $description = '게시판을 지웁니다';

    public function fire()
    {
        $board_key = $this->argument('board_key');
        Board::where(['key' => $board_key])->delete();
    }
}
