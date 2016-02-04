<?php

namespace NineCells\SimpleBoard\Console;

use Schema;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use NineCells\SimpleBoard\Models\Board;

class CreateBoardCommand extends Command
{
    protected $signature = 'sboard:create_board {board_key}';

    protected $description = '게시판을 만듭니다';

    public function fire()
    {
        $board_key = $this->argument('board_key');

        Board::create(['key' => $board_key]);

        Schema::create('sboard_'.$board_key, function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->longText('content');
            $table->integer('writer_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sboard_'.$board_key.'_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_id');
            $table->longText('content');
            $table->integer('writer_id')->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index('post_id');
        });
    }
}
