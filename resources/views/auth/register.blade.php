@extends('layouts.main')

@section('title', 'Register')

@section('content')
    <div class="mx-5 my-5">
        <form class="mx-auto w-50" action="/register" method="POST">
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
            <div class="mb-3">
                <label class="form-label">Tên</label>
                <input type="name" name="name" class="form-control" placeholder="Nhập tên" value="{{ old('name') }}">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
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
            <div class="mb-3">
                <label class="form-label">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu"
                    value="{{ old('password_confirmation') }}">
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <button class="w-100 btn btn-primary">Register</button>
            </div>
        </form>
    </div>
@endsection
