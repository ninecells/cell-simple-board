<?php

namespace NineCells\SimpleBoard\Http\Controllers;

use NineCells\SimpleBoard\Models\Board;
use NineCells\SimpleBoard\Models\Comment;
use Illuminate\Http\Request;
use Auth;

class CommentController extends Controller
{
    private function getTable($board_key)
    {
        $board = Board::where('key', $board_key)->first();
        if (!$board) {
            return null;
        }
        return 'sboard_' . $board->key . '_comments';
    }

    public function post_write(Request $request, $board_key)
    {
        $table = $this->getTable($board_key);
        if (!$table) {
            abort(404);
        }

        $this->authorize('sboard-write');
        $request->merge(['writer_id' => Auth::user()->id]);
        $c = Comment::fromTable($table)->create($request->all());
        return redirect("sboards/$board_key/{$c->post_id}");
    }

    public function get_edit($board_key, $c_id)
    {
        $table = $this->getTable($board_key);
        if (!$table) {
            abort(404);
        }

        $c = Comment::fromTable($table)->find($c_id);
        $this->authorize('sboard-edit', $c);
        return view('ncells::sboard.pages.edit_comment', ['board_key' => $board_key, 'c' => $c]);
    }

    public function put_edit(Request $request, $board_key, $c_id)
    {
        $table = $this->getTable($board_key);
        if (!$table) {
            abort(404);
        }

        $c = Comment::fromTable($table)->find($c_id);
        $this->authorize('sboard-edit', $c);
        $input = $request->only(['content']);
        $c->update($input);
        return redirect("sboards/$board_key/{$c->post_id}");
    }

    public function delete_item($board_key, $c_id)
    {
        $table = $this->getTable($board_key);
        if (!$table) {
            abort(404);
        }

        $c = Comment::fromTable($table)->find($c_id);
        $this->authorize('sboard-edit', $c);
        $c->delete();
        return redirect("sboards/$board_key/{$c->post_id}");
    }
}
