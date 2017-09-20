@extends('app')

@section('content')

    <div class="articles">
        <div class="container">

            @foreach($articles as $key => $value)

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 articleBlock">
                    <button type="button" class="close remove" data-toggle="modal" data-id="{{$value->id}}" data-target="#myModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <a href="/dashboard/edit/{{$value->id}}">
                        <span class="glyphicon glyphicon-pencil edit"></span>
                    </a>
                    <div class="articleContent">
                        <div class="pull-left imageBlock">
                            <img src="{{$value->image}}" alt="Article image">
                        </div>
                        <div class="titleBlock">
                            <a href="{{$value->url}}" target="_blank" class="articleUrl">
                                <h4>{{$value->title}}</h4>
                            </a>
                        </div>
                        <div class="pull-left dateBlock">
                            <p>{{$value->posted_at}}</p>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left descBlock">
                            <p>{{$value->description}}</p>
                        </div>
                    </div>
                </div>

            @endforeach

            <!--Pagination-->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 paginationBlock">
                {{ $articles->links() }}
            </div>

            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Warning:</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure You want to delete the post?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info submitDelete" data-accept="modal" data-token="{{ csrf_token() }}">Delete</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>

            <!--Notifications-->
            <div class="col-xs-11 col-sm-11 col-md-7 col-lg-7 alert alert-success successMessage">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> The article was deleted.
            </div>

            <div class="col-xs-11 col-sm-11 col-md-7 col-lg-7 alert alert-danger errorMessage">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Danger!</strong> Something went wrong.
            </div>

        </div>
    </div>

@endsection