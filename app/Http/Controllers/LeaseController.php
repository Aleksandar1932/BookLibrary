<?php

namespace App\Http\Controllers;

use App\Book;

use App\Lease;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class LeaseController extends Controller
{
    public function index(){
        $leases = Lease::where('leased_from_id', auth()->user()->id)->get();

        return view('user.lease.index', compact('leases'));
    }

    public function myLeases(){
        $myLeases = Lease::where('leased_to_id', auth()->user()->id)->get();

        return view('user.lease.my_leases_index', compact('myLeases'));
    }

    public function destroy($id){

        $leaseToDelete = Lease::find($id);
        $leaseToDelete->delete();
        return redirect('/leases')->with('primary', 'The lease has been removed!');
    }

    public function create($id)
    {

        $book = Book::where('user_id', auth()->user()->id)
            ->where('id', $id)
            ->first();

        return view('user.lease.create', compact('book', 'id'));
    }

    public function store(Request $request, $id)
    {


        $data = $this->validate($request, [
            'lease_to' => 'required'
        ]);



        $leased_to_id = null; //initial value

        $leased_to_id = User::where('email', $data['lease_to'])
            ->firstOrFail()
            ->id;

        if($leased_to_id == auth()->user()->id){
            return redirect('/create/lease/'.$id)
                ->withErrors("You can't lease a book to yourself!");
        }


        $leased_from_id = auth()->user()->id;
        $book_id = $id;

        $lease = new Lease();
        $lease->createLease($leased_from_id,$leased_to_id,$book_id);


        return redirect('/home')->with('success',
            'A book has been leased to '.$data['lease_to']);
    }

    public function leases_pdf(){
        $data['user'] = auth()->user()->email;
        $data['timestamp'] = now();
        $data['leases'] =  Lease::where('leased_from_id', auth()->user()->id)->get();

        $pdf = PDF::loadView('pdf.leases', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download(now()."_".'Leases'."_".$data['user']." ".'.pdf');

    }

    public function leases_my_pdf(){
        $data['user'] = auth()->user()->email;
        $data['timestamp'] = now();
        $data['my_leases'] =  Lease::where('leased_to_id', auth()->user()->id)->get();

        $pdf = PDF::loadView('pdf.leases_my', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download(now()."_".'My_Leases'."_".$data['user']." ".'.pdf');
    }
}
