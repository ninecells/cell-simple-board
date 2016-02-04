<?php

namespace NineCells\SimpleBoard\Http\Controllers;

use Auth;
use NineCells\SimpleBoard\Models\Board;
use NineCells\SimpleBoard\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private function getTable($board_key)
    {
        $board = Board::where('key', $board_key)->first();
        if (!$board) {
            return null;
        }
        return 'sboard_' . $board->key;
    }

    public function get_list($board_key)
    {
        $table = $this->getTable($board_key);
        if (!$table) {
            abort(404);
        }

        $posts = Post::fromTable($table)
            ->with('writer')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('ncells::sboard.pages.list', [
            'board_key' => $board_key,
            'posts' => $posts,
        ]);
    }

    public function get_item($board_key, $post_id)
    {
        $table = $this->getTable($board_key);
        if (!$table) {
            abort(404);
        }

        $post = Post::fromTable($table)
            ->with('writer')
            ->with('comments.writer')
            ->find($post_id);

        return view('ncells::sboard.pages.item', [
            'board_key' => $board_key,
            'post' => $post,
        ]);
    }

    public function get_write($board_key)
    {
        $this->authorize('sboard-write');
        return view('ncells::sboard.pages.write', ['board_key' => $board_key]);
    }

    public function post_write(Request $request, $board_key)
    {
        $table = $this->getTable($board_key);
        if (!$table) {
            abort(404);
        }

        $this->authorize('sboard-write');
        $request->merge(['writer_id' => Auth::user()->id]);
        $post = Post::fromTable($table)->create($request->all());
        return redirect("sboards/$board_key/{$post->id}");
    }

    public function get_edit($board_key, $post_id)
    {
        $table = $this->getTable($board_key);
        if (!$table) {
            abort(404);
        }

        $post = Post::fromTable($table)->find($post_id);
        $this->authorize('sboard-edit', $post);
        return view('ncells::sboard.pages.edit', ['board_key' => $board_key, 'post' => $post]);
    }

    public function put_edit(Request $request, $board_key, $post_id)
    {
        $table = $this->getTable($board_key);
        if (!$table) {
            abort(404);
        }

        $post = Post::fromTable($table)->find($post_id);
        $this->authorize('sboard-edit', $post);
        $input = $request->only(['title', 'content']);
        $post->where('id', $post_id)->update($input);
        return redirect("sboards/$board_key/{$post->id}");
    }

    public function delete_item($board_key, $post_id)
    {
        $table = $this->getTable($board_key);
        if (!$table) {
            abort(404);
        }

        $post = Post::fromTable($table)->find($post_id);
        $this->authorize('sboard-edit', $post);
        $post->delete();
        return redirect("sboards/$board_key");
    }
}
