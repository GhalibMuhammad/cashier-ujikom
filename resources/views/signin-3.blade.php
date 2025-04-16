<?php $page = 'signin-3'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="account-content">
        <div class="login-wrapper login-new">
            <div class="container">
                 {{-- Pesan error/success --}}
  
                <div class="login-content user-login">
                    <div class="login-logo">
                        <img src="{{ URL::asset('/build/img/logo.png') }}" alt="img">
                        <a href="{{ url('index') }}" class="login-logo logo-white">
                            <img src="{{ URL::asset('/build/img/logo-white.png') }}" alt="">
                        </a>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                    @csrf
                        <div class="login-userset">
                            <div class="login-userheading">
                                <h3>Sign In</h3>
                                <h4>Access the KASIR panel using your email and passcode.</h4>
                            </div>
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="form-login">
                                <label class="form-label">Email Address</label>
                                <div class="form-addons">
                                    <input type="email" name="email" class="form-control">
                                    <img src="{{ URL::asset('/build/img/icons/mail.svg') }}" alt="img">
                                </div>
                            </div>
                            <div class="form-login">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input type="password" name="password" class="pass-input" required>
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                           
                            <div class="form-login">
                                <button class="btn btn-login" type="submit">Sign In</button>
                            </div>
                        
                            
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
