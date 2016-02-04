<?php

namespace NineCells\SimpleBoard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use SoftDeletes;

    protected $table = 'sboards';

    protected $fillable = [
        'key',
    ];
}
