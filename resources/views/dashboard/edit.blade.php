@extends('app')

@section('content')
    <div class="editForm">
        <div class="container">
            <div class="row">
                <form action="/dashboard/update/{{$article->id}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PATCH">

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" value="{{$article->title}}" name="artTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea id="desc" class="form-control" name="artDesc" required>{{$article->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <div class="image imageBlock">
                            <img src="/{{$article->image}}" alt="Main Image">
                        </div>
                        <label for="image">Image</label>
                        <input type="file" id="image" class="form-control" value="{{$article->image}}" name="artImage">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <input type="submit" class="btn btn-primary" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection