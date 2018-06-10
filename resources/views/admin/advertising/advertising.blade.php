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
                    <div class="panel-heading">Add Advertising</div>

                    <div class="panel-body">
                        <div class="col-md-6">
                            @if($errors->any())
                                <div class="alert alert-danger">{{$errors->first()}}</div>
                            @elseif (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <form method="POST" action="/addadvertising">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input name="product_name" type="text" class="form-control" id="product_name"
                                           placeholder="Some text">
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input name="price" type="number" class="form-control" id="price">
                                </div>
                                <div class="form-group">
                                    <label for="salesman">Salesman</label>
                                    <input name="salesman" type="text" class="form-control" id="salesman"
                                           placeholder="Some text">
                                </div>
                                <div class="form-group">
                                    <label for="discount">Discount</label>
                                    <input name="discount" type="text" class="form-control" id="discount"
                                           placeholder="AxXr34Fds">
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