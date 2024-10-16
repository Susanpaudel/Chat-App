@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <a href="{{route('chat',base64_encode(auth()->user()->id))}}">Go to chat</a>

                    <br> 
                    <div class="upload-image mt-4 border p-3">
                        <h2>Update Profile Image</h2>
                        <form action="{{route('upload-image')}}" method="post" enctype="multipart/form-data">
                            @csrf
                           <input type="file" class="form-control" name="avatar">
                           @if(isset(auth()->user()->avatar))
                            @if(auth()->user()->avatar!="avatar.png")
                            <img src="{{asset('storage/user/'.auth()->user()->avatar)}}" style="height: 200px;width:auto;border:1px solid black;padding:5px;margin:10px 20px;">
                            @else
                            <img src="{{asset('storage/users-avatar/'.auth()->user()->avatar)}}" style="height: 200px;width:auto;border:1px solid black;padding:5px;margin:10px 0px;">
                            @endif
                           @endif
                           <br>
                           <button type="submit" class="btn btn-primary">Update</button> 
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
