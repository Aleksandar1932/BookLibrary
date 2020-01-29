@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br/>
        @endif


        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Lease <i>"{{$book->title}}"</i></div>

                    <div class="card-body">
                        <form method="post" action="{{action('LeaseController@store', $id)}}">
                            <div class="form-group">
                                <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                                <label for="title">Lease to:</label>
                                <input type="text" class="form-control" name="lease_to" value=""/>
                            </div>

                            <div class="form-group">
                                <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" name="title" value="{{$book->title}}" disabled/>
                            </div>

                            <div class="form-group">
                                <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                                <label for="author">Author:</label>
                                <input type="text" class="form-control" name="author" value="{{$book->author}}"
                                       disabled/>
                            </div>

                            <div class="form-group">
                                <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                                <label for="isbn">ISBN:</label>
                                <input type="number" class="form-control" name="isbn" value="{{$book->isbn}}" disabled/>
                            </div>

                            <div class="form-group">
                                <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                                <label for="language">Language:</label>
                                <input type="text" class="form-control" name="language" value="{{$book->language}}"
                                       disabled/>
                            </div>

                            <button type="submit" class="btn btn-primary">Lease</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
