@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ Auth::user()->name }}'s <strong>BookLibrary</strong></div>

                    <div class="card-body">
                        @if(\Session::has('success'))
                            <div class="alert alert-success">
                                {{\Session::get('success')}}
                            </div>
                        @endif

                        <div class="row">
                            <a href="{{url('/create/book')}}"
                               class="card bg-primary text-white p-1 m-2 col d-inline-flex align-items-center">
                                <div class="card-body">Add Book Manually</div>
                            </a>
                            <a href="{{url('/create/isbn')}}"
                               class="card bg-primary text-white p-1 m-2 col d-inline-flex align-items-center">
                                <div class="card-body">Add Book By ISBN</div>
                            </a>

                            <a href="{{url('/create/isbn/bulk')}}"
                               class="card bg-primary text-white p-1 m-2 col d-inline-flex align-items-center">
                                <div class="card-body">Add Books By ISBNs</div>
                            </a>


                        </div>
                        <div class="row">
                            <a href="{{url('/books')}}"
                               class="card bg-success text-white p-1 m-2 col d-inline-flex align-items-center">
                                <div class="card-body">My Library</div>
                            </a>
                        </div>


                        <div class="row">
                            <a href="{{url('/leases')}}"
                               class="card bg-dark text-white p-1 m-2 col d-inline-flex align-items-center">
                                <div class="card-body">Leased Books</div>
                            </a>
                            <a href="{{url('/leases/my')}}"
                               class="card bg-dark text-white p-1 m-2 col d-inline-flex align-items-center">
                                <div class="card-body">My Leases</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
