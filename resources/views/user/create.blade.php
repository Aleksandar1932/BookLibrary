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
            </div><br />
        @endif


            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Add book</div>

                        <div class="card-body">
                            <form method="post" action="{{url('/create/book')}}">
                                <div class="form-group">
                                    <input type="hidden" value="{{csrf_token()}}" name="_token" />
                                    <label for="title">Title:</label>
                                    <input type="text" class="form-control" name="title"/>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" value="{{csrf_token()}}" name="_token" />
                                    <label for="author">Author:</label>
                                    <input type="text" class="form-control" name="author"/>
                                </div>

                                <div class="form-group">
                                    <input type="hidden" value="{{csrf_token()}}" name="_token" />
                                    <label for="isbn">ISBN:</label>
                                    <input type="number" class="form-control" name="isbn"/>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" value="{{csrf_token()}}" name="_token" />
                                    <label for="language">Language:</label>
                                    <input type="text" class="form-control" name="language"/>
                                </div>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>


    </div>
@endsection
