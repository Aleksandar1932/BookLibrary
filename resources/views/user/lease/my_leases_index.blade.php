@extends('layouts.app')

@section('content')
    <div class="container">

        @if(\Session::has('primary'))
            <div class="alert alert-primary">
                {{\Session::get('primary')}}
            </div>
        @endif
        <div class="container-fluid">
            <h1>My Leases</h1>

            <a href="{{url('/leases/my/pdf')}}" class="btn btn-dark float-right">Download PDF <i
                    class="far fa-file-pdf"></i></a>
            @if(!count($myLeases))
                <div class="alert alert-success">
                    You don't have books leased from other people!
                </div>
            @else
                <h3 class="d-inline">List of all books leased from other people.</h3>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Leased from</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($myLeases as $myLease)
                        <tr>
                            <td>{{$myLease->getBookDetailsByID($myLease->book_id)[0]}}</td>
                            <td>{{$myLease->getBookDetailsByID($myLease->book_id)[1]}}</td>
                            <td>{{$myLease->getUserByID($myLease->leased_from_id)}}</td>
                            <td>{{$myLease->created_at}}</td>
                            <td>
                                <a href="/delete/lease/{{$myLease->id}}">
                                    <button class="btn btn-success"><i class="fas fa-undo-alt"></i></button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
@endsection
