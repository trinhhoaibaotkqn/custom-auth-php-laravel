@extends('layouts.main')

@section('title', 'Profile')

@section('content')
    <div class="profile-container mx-auto w-75">
        <div class="h4 text-center my-2">Tài khoản của bạn</div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="/user/change-name">
            @csrf
            <div class="mb-3 mx-auto w-50">
                <label><strong>Tên</strong></label>
                <input type="text" name="name" class="form-control"
                    value="{{ old('name', session()->get('user.name')) }}">
                {{-- <input type="text" name="name" class="form-control" value="{{ session()->get('user.name') }}"> --}}
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 mx-auto w-50">
                <button class="w-100 btn btn-primary">Thay đổi</button>
            </div>
        </form>
    </div>
@endsection
