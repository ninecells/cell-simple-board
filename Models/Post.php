<?php

namespace NineCells\SimpleBoard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'content', 'writer_id',
    ];

    protected static $_table;

    public static function fromTable($table, $parms = Array()){
        $ret = null;
        if (class_exists($table)){
            $ret = new $table($parms);
        } else {
            $ret = new static($parms);
            $ret->setTable($table);
        }
        return $ret;
    }

    public function setTable($table)
    {
        static::$_table = $table;
    }

    public function getTable()
    {
        return static::$_table;
    }

    public function getMdContentAttribute()
    {
        $content = $this->attributes['content'];
        $parsedown = new \Parsedown();
        return clean($parsedown->text($content));
    }

    public function writer()
    {
        return $this->hasOne('App\User', 'id', 'writer_id');
    }

    public function comments()
    {
        $table = $this->getTable().'_comments';
        $instance = Comment::fromTable($table);
        return new HasMany($instance->newQuery(), $this, $instance->getTable().'.post_id' , $this->getKeyName());
    }
}
