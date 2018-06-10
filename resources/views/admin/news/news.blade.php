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
                    <div class="panel-heading">Add News</div>

                    <div class="panel-body">
                        <div class="col-md-6">
                            @if($errors->any())
                                <div class="alert alert-danger">{{$errors->first()}}</div>
                            @elseif (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <form enctype="multipart/form-data" method="POST" action="/addnews">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input name="title" type="text" class="form-control" id="title"
                                           placeholder="Some text">
                                </div>
                                <div class="form-group">
                                    <label for="content">Content</label>
                                    <textarea name="content" class="form-control" id="content" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="title">Add tags:</label>
                                    <input name="tags" type="text" class="form-control" id="tags"
                                           placeholder="Renres, views, CaRs">
                                </div>
                                @if(isset($categories) && is_object($categories))
                                    <div class="form-group">
                                        <label for="category">Select category:</label>
                                        <select name="category" class="form-control" id="category">
                                            @foreach($categories as $category)
                                                @php
                                                    echo "<option value=\"{$category->id}\">{$category->category_name}</option>"
                                                @endphp
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="img">Add file:</label>
                                    <input name="img" type="file" class="form-control-file" id="img">
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