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
                    <div class="panel-heading">Approved</div>

                    <div class="panel-body">
                        <table class="table table-dark">
                            <thead>
                            <tr>
                                <th scope="col">News ID</th>
                                <th scope="col">News title</th>
                                <th scope="col">Text</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($comments as $comment)
                                <tr>
                                    <td>{{$comment->id}}</td>
                                    <td>{{$comment->title}}</td>
                                    <td>{{$comment->comment_text}}</td>
                                    <td>
                                        <a class="btn btn-primary" href="http://newss.com/update/{{$comment->id}}">
                                            Update
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $comments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
