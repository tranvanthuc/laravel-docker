
@extends('layouts.app')

<style>
    .hide {
        display: none;
    }
    
</style>

@section('content')
    <div class="container">
        <input type="email" id="txtEmail" placeholder="Enter email" /> <br/>
        <input type="password" id="txtPassword" placeholder="Enter password" /><br/>
        <button id="btnLogin" >Log in</button>
        <button id="btnSignUp" >Sign Up</button>
        <button id="btnLogOut" class="hide" >Log Out</button>
        <button id="withFB">Log In with FaceBook</button>
        <button id="withGithub">Log In with GitHub</button>
    </div>
@endsection

@section('bottom.js')
    <script src="{{mix('js/firebase/auth.js')}}"></script>
@endsection

