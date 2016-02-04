<?php

Route::group(['middleware' => ['web']], function () {

    Route::group(['namespace' => 'NineCells\SimpleBoard\Http\Controllers'], function() {

        Route::group(['prefix' => 'sboards'], function() {

            Route::group(['prefix' => '{board_key}'], function() {

                Route::get('write', 'PostController@get_write');
                Route::post('write', 'PostController@post_write');
                Route::get('{post_id}/edit', 'PostController@get_edit');
                Route::put('{post_id}/edit', 'PostController@put_edit');
                Route::delete('{post_id}/delete', 'PostController@delete_item');
                Route::get('{post_id}', 'PostController@get_item');
                Route::get('/', 'PostController@get_list');

                Route::post('comments/write', 'CommentController@post_write');
                Route::get('comments/{c_id}/edit', 'CommentController@get_edit');
                Route::put('comments/{c_id}/edit', 'CommentController@put_edit');
                Route::delete('comments/{c_id}/delete', 'CommentController@delete_item');
            });

            Route::get('/', 'BoardController@get_board_list');
        });
    });
});
