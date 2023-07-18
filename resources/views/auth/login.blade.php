@extends('layouts.main')

@section('title', 'Login')

@section('content')
    <div class="mx-5 my-5">
        <form class="mx-auto w-50" action="/login" method="POST">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Nhập email"
                    value="{{ old('email') }}">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu"
                    value="{{ old('password') }}">
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="">
                <label>Lưu đăng nhập</label>
            </div>
            <div class="mb-3">
                <button class="w-100 btn btn-primary">Login</button>
            </div>
        </form>
    </div>
@endsection
