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
                                <a class="nav-link active" href="http://newss.com/addcat">Add Cetegories</a>
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
                    <div class="panel-heading">Add Categories</div>

                    <div class="panel-body">
                        <div class="col-md-4">
                            @if($errors->any())
                                <div class="alert alert-danger">{{$errors->first()}}</div>
                            @elseif (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <form method="POST" action="/addcat">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="addCategory">Category</label>
                                    <input name="category" type="text" class="form-control" id="addCategory"
                                           placeholder="Enter category">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection