<?php

namespace App;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'author',
        'isbn',
        'language'
    ];



    public function book()
    {
        return $this->belongsTo('App\User');
    }

    public function saveBook($data)
    {
        $this->user_id = auth()->user()->id;
        $this->title = $data['title'];
        $this->author = $data['author'];
        $this->isbn = $data['isbn'];
        $this->language = $data['language'];
        return 1;
    }

    public function updateBook($data)
    {

        $bookToUpdate = $this->find($data['id']);
        $bookToUpdate->user_id = auth()->user()->id;
        $bookToUpdate->title = $data['title'];
        $bookToUpdate->author = $data['author'];
        $bookToUpdate->isbn = $data['isbn'];
        $bookToUpdate->language = $data['language'];
        $bookToUpdate->save();
        return 1;
    }


}
