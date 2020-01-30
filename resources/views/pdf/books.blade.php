@extends('pdf.reports_layout')



@section('content_pdf')
    <h1>BookLibrary</h1>
    <hr>
    <h2>My Library Report</h2>
    <p>Generated by: {{$user}}</p>
    <p>Generated at: {{$timestamp}}</p>

<table class="table table-sm" id="">
    <thead>
    <tr>
        <th>#</th>
        <th>Title</th>
        <th>Author</th>
        <th>Language</th>
        <th>ISBN</th>

    </tr>
    </thead>
    <tbody>
    @foreach($books as $book)
        <tr>
            <td>{{ $book->id }}</td>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td>{{$book->language}}</td>
            <td>{{ $book->isbn }}</td>

        </tr>
    @endforeach
    </tbody>
</table>
