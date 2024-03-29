@extends('layouts.app')

@section('content')
    <div class="container">

        @if(\Session::has('primary'))
            <div class="alert alert-primary">
                {{\Session::get('primary')}}
            </div>
        @endif


        <div class="container-fluid">
            <h1>My Leased Books</h1>
            <h3 class="d-inline">List of all books leased to other people.</h3>
            @if(!count($leases))
                <div class="alert alert-success">
                    You don't have books leased to other people!
                </div>
            @else
                <a href="{{url('/leases/pdf')}}" class="btn btn-dark float-right">Download PDF <i
                        class="far fa-file-pdf"></i></a>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Leased to</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($leases as $lease)
                        <tr>
                            <td>{{$lease->getBookDetailsByID($lease->book_id)[0]}}</td>
                            <td>{{$lease->getBookDetailsByID($lease->book_id)[1]}}</td>
                            <td>{{$lease->getUserByID($lease->leased_to_id)}}</td>
                            <td>{{$lease->created_at}}</td>
                            <td>
                                <a href="/delete/lease/{{$lease->id}}">
                                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
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
