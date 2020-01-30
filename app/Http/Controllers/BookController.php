<?php

namespace App\Http\Controllers;

use App\Book;
use App\Lease;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {

        $book = new Book();
        try {
            $data = $this->validate($request, [
                'title' => 'required',
                'author' => 'required',
                'isbn' => 'required',
                'language' => 'required'
            ]);
        } catch (ValidationException $e) {
        }

        $book->saveBook($data);
        $book->save();
        return redirect('/home')->with('success',
            $book->title . ' by ' . $book->author . ' has been added!');

    }

    public function pdf(){

        $data['user'] = auth()->user()->email;
        $data['timestamp'] = now();
        $data['books'] =  Book::where('user_id', auth()->user()->id)->get();


        $pdf = PDF::loadView('pdf.books', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download(now()."_".'My Library'."_".$data['user']." ".'.pdf');
    }

    public function index()
    {

        $userID = auth()->user()->id;

        $books = Book::where('user_id', auth()->user()->id)->get();


        $leasedBooks = Lease::getLeasedBooksByID($userID);
        $leases = Lease::getLeasesByID($userID);

        foreach ($books as $book) {
            if (in_array($book->id, $leasedBooks)) {
                $book->leased = true;
            }

        }


        foreach ($leases as $leasedBook) {
            $leasedBook->leasedFromSomeone = true;
            $books->push($leasedBook);
        }


        $returnArray['books'] = $books;
        $returnArray['leasedBooks'] = $leasedBooks;
        $returnArray['leases'] = $leases;


        return view('user.index', compact('books'));
    }

    public function destroy($id)
    {
        $bookToDelete = Book::find($id);

        $titleToRetain = $bookToDelete->title;
        $authorToRetain = $bookToDelete->author;

        $bookToDelete->delete();
        return redirect('/books')->with('primary', $titleToRetain . ' by ' . $authorToRetain . ' has been deleted!');
    }

    public function edit($id)
    {
        $book = Book::where('user_id', auth()->user()->id)
            ->where('id', $id)
            ->first();

        return view('user.edit', compact('book', 'id'));
    }

    public function update(Request $request, $id)
    {
        $book = new Book();
        $data = $this->validate($request, [
            'title' => 'required',
            'author' => 'required',
            'isbn' => 'required',
            'language' => 'required'
        ]);
        $data['id'] = $id;
        $book->updateBook($data);
        return redirect('/books')->with('primary', 'Edit was successfully done!');
    }

    public function createISBN()
    {
        return view('user.createISBN');
    }

    public function storeISBN(Request $request)
    {
        $data = $this->validate($request, [
            'isbn' => 'required'
        ]);

        $queryISBN = str_replace("-", "", $data['isbn']);

        $queryUrl = "https://www.googleapis.com/books/v1/volumes?q=isbn:" . $queryISBN;


        $json = file_get_contents($queryUrl);
        $bookObject = json_decode($json);

        if (!property_exists($bookObject, 'items')) {
            return redirect('/create/isbn')
                ->withErrors("The provided ISBN:" . $queryISBN . " is not valid!");
        }

        $bookTitle = ($bookObject->items[0]->volumeInfo->title);
        $bookAuthor = implode(", ", ($bookObject->items[0]->volumeInfo->authors));
        $bookLanguage = $bookObject->items[0]->volumeInfo->language;

        $requestToSend = new Request();
        $requestToSend['title'] = $bookTitle;
        $requestToSend['author'] = $bookAuthor;
        $requestToSend['isbn'] = $queryISBN;
        $requestToSend['language'] = $bookLanguage;

        $this->store($requestToSend);

        return redirect('/home')->with('success',
            $bookTitle . ' by ' . $bookAuthor . ' has been added!');
    }

    public function createISBNBulk()
    {
        return view('user.create_isbn_bulk');
    }

    public function storeISBNBulk(Request $request)
    {
        $data = $this->validate($request, [
            'bulk_isbn' => 'required',
            'delimiter' => 'required'
        ]);

        $isbns = explode($data['delimiter'], $data['bulk_isbn']);

        foreach ($isbns as $isbn) {
            $request = Request();
            $request->setMethod('POST');
            $request->request->add(['isbn' => $isbn]);
            $this->storeISBN($request);
        }

        return view('user.create_isbn_bulk')->with('success', "addes");
    }
}
