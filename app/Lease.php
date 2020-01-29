<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Lease extends Model
{
    protected $fillable = [
        'leased_from_id',
        'leased_to_id',
        'book_id'
    ];

    public function getBookDetailsByID($id)
    {
        $book = new Book();
        $book = Book::find($id);

        $returnArray[0] = $book->title;
        $returnArray[1] = $book->author;

        return $returnArray;
    }

    public function getUserByID($id)
    {
        return User::find($id)->email;

    }

    public static function getLeasedBooksByID($id)
    {
        /*
         * Knigi koi se pozajmeni na drugi lica, i ne treba da se dostapni vo bibliotekata, nitu pak
         * da mozat da se pozajmat na drugi lica, nitu CRUD:
         *
         * Vraka lista od $id-a
         */

        return Lease::where('leased_from_id', auth()->user()->id)->pluck('book_id')->all();
    }

    public static function getLeasesByID($id)
    {

        /*Knigi koi se pozajmeni od drugi useri, i ne se nasi, pa nie ne smeeme da gi pozajmuvame, nitu CRUD
         *
         * Vraka lista od $id-a
         */

        $bookIDs = Lease::where('leased_to_id', auth()->user()->id)->pluck('book_id')->all();



        $leasesBooksArray = array();

        foreach ($bookIDs as $bookID) {
            array_push($leasesBooksArray, Book::find($bookID));
        }

        return $leasesBooksArray;
    }

    public function createLease($fromID, $toID, $bookID)
    {
        $this->leased_from_id = $fromID;
        $this->leased_to_id = $toID;
        $this->book_id = $bookID;

        $this->save();

    }
}
