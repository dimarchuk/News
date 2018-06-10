@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Menu</div>
                    <div class="panel-body">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="http://admin.8434-5a79ee928fcb5.st.php-academy.org/addcat">Add Cetegories</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="http://admin.8434-5a79ee928fcb5.st.php-academy.org/addnews">Add News</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="http://admin.8434-5a79ee928fcb5.st.php-academy.org/addadvertising">Add Advertising</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="http://admin.8434-5a79ee928fcb5.st.php-academy.org/setbgc">Set bachground</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="http://admin.8434-5a79ee928fcb5.st.php-academy.org/approved">Approved politition</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="http://admin.8434-5a79ee928fcb5.st.php-academy.org/comments">All comments</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Update comment</div>
                    <div class="panel-body">
                        <div class="col-md-7">
                            <form method="POST" action="/update">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="addCategory">Comment</label>
                                    <textarea name="content" class="form-control" id="content"
                                              rows="10">{{$comment->comment_text}}</textarea>
                                    <input type="hidden" name="id" value="{{$comment->id}}">
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
