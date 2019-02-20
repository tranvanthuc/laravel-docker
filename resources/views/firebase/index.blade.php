
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
        <button id="withFacebook">Log In with FaceBook</button>
        <button id="withGoogle">Log In with Google</button>
        <button id="withTwitter">Log In with Twitter</button>
        <button id="withGithub">Log In with Github</button>
    </div>
@endsection

@section('bottom.js')
    <script src="{{mix('js/firebase/auth.js')}}"></script>
@endsection

