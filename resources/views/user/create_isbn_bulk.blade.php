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
                    <div class="card-header"><i class="fas fa-barcode"></i> Add books by theirs ISBNs</div>


                        <form method="post" action="{{url('/create/isbn/bulk')}}">
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                                    <label for="delimiter">Data delimiter:</label>
                                    <input type="text" class="form-control" name="delimiter"/>
                                </div>
                            <div class="form-group">
                                <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                                <label for="isbn">ISBNs:</label>
                                <textarea class="form-control" name="bulk_isbn" rows="5"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
