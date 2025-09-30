@extends('ivrs.ivrslayout')


@section('style')
    <link href="{{ asset('assets/libs/bootstrap-4/css/signin.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                 @if(session()->has('error_msg'))
        <div class="alert alert-danger" role="alert">Incorrect Username or Password! Try again!</div>
        @endif
            </div>
            <div class="col"></div>
        </div>
    </div>

    <div class="container">
       
      <form class="form-signin" action="{{ url('/ivrs/signin') }}" method="post">
          {{ csrf_field() }}
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="username" class="sr-only">Email address</label>
        <input type="email" id="username" name="username" class="form-control" placeholder="Email address" value="{{old('username')}}" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" class="form-control" type="submit">Sign in</button>
      </form>

    </div>


@endsection


@section('script')
@endsection
