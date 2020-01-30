@extends('layouts.app')

@section('content')
    <style>
        a.disabled {
            pointer-events: none;
            cursor: default;
        }
    </style>

    <div class="container">

        @if(\Session::has('primary'))
            <div class="alert alert-primary">
                {{\Session::get('primary')}}
            </div>
        @endif
        <div class="container-fluid">
            <h1>My Library</h1>
            <h3>List of all books.</h3>
            <a href="{{url('/create/book')}}" class="btn btn-primary">Add Book</a>
            <a href="{{url('/create/isbn')}}" class="btn btn-primary">Add by ISBN</a>
            <a href="{{url('/books/pdf')}}" class="btn btn-dark float-right">Download PDF <i
                    class="far fa-file-pdf"></i></a>


            <br>
            <span class="badge badge-pill badge-warning">Leased to someone</span>
            <span class="badge badge-pill badge-danger">Leased from someone</span>

            @if(!count($books))
                <div class="alert alert-success">
                    You don't have any books in your library!
                </div>
            @else
                <table class="table table-sm ">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Language</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($books as $book)
                        <?php

                        $buttonStatus = "";
                        $tableRowClass = "";

                        if ($book->leased) {
                            $buttonStatus = "disabled";
                            $tableRowClass = "table-warning";
                        }

                        if ($book->leasedFromSomeone) {
                            $buttonStatus = "disabled";
                            $tableRowClass = "table-danger";
                        }
                        ?>

                        <tr class="{{$tableRowClass}}">
                            <td>{{$book->title}}</td>
                            <td>{{$book->author}}</td>
                            <td>{{$book->isbn}}</td>
                            <td>{{$book->language}}</td>
                            <td>
                                <a href="/delete/book/{{$book->id}}" class="{{$buttonStatus}}">
                                    <button class="btn btn-danger" {{$buttonStatus}}><i class="fas fa-trash"></i>
                                    </button>
                                </a>
                                <a href="/edit/book/{{$book->id}}" class="{{$buttonStatus}}">
                                    <button class="btn btn-warning" {{$buttonStatus}}><i class="fas fa-edit"></i>
                                    </button>
                                </a>
                                <a href="/create/lease/{{$book->id}}" class="{{$buttonStatus}}">
                                    <button class="btn btn-dark" {{$buttonStatus}}><i class="fas fa-hand-holding"></i>
                                    </button>
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
