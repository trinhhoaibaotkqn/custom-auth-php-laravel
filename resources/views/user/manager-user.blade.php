@extends('layouts.main')

@section('title', 'Manager users')

@section('content')
    <div class="profile-container mx-auto w-75">
        <div class="h3 text-center my-2">Quản lý người dùng</div>
        <!-- Button open modal add new user-->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addNewModal">
            Thêm mới người dùng
        </button>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Email</th>
                    <th scope="col">Quyền</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="align-middle">
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <button class="btn btn-primary btn-edit" data-bs-toggle="modal" data-bs-target="#updateModal"
                                data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                data-role="{{ $user->role }}">
                                Sửa
                            </button>
                            <button class="btn btn-success btn-edit-account" data-bs-toggle="modal"
                                data-bs-target="#updateAccountModal" data-id="{{ $user->id }}"
                                data-email="{{ $user->email }}">
                                <i class="bi bi-person-fill-lock" style="font-size: 24px"></i>
                            </button>
                            <button class="btn btn-danger btn-delete-account" data-bs-toggle="modal"
                                data-bs-target="#deleteModal" data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}">Xóa</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal add new user -->
        <div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" action="/user/add-new-user" id="form_add">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Thêm mới người dùng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Tên</label>
                                <input type="text" name="name" class="form-control" placeholder="Nhập tên"
                                    value="{{ old('name') }}">
                                <span class="error-message name-error text-danger "></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Nhập email"
                                    value="{{ old('email') }}">
                                <span class="error-message email-error text-danger "></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <input type="current-password" name="password" class="form-control"
                                    placeholder="Nhập mật khẩu" value="{{ old('password') }}">
                                <span class="error-message password-error text-danger "></span>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="addRadios2"
                                        value="USER" checked>
                                    <label class="form-check-label" for="addRadios2">
                                        Người dùng
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="addRadios1"
                                        value="ADMIN">
                                    <label class="form-check-label" for="addRadios1">
                                        Quản trị viên
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal update user's information -->
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" action="" id="form_update">
                        @method('patch')
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa thông tin người dùng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Tên</label>
                                <input type="text" name="name" class="form-control input-update"
                                    placeholder="Nhập tên" value="{{ old('name') }}">
                                <span class="error-message name-error text-danger "></span>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input input-role" type="radio" name="role"
                                        id="exampleRadios2" value="USER">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Người dùng
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input input-role" type="radio" name="role"
                                        id="exampleRadios1" value="ADMIN">
                                    <label class="form-check-label" for="exampleRadios1">
                                        Quản trị viên
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-edit btn btn-secondary"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Sửa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal update user's account -->
        <div class="modal fade" id="updateAccountModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" action="" id="form_update_account">
                        @method('patch')
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa tài khoản người dùng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email input-update" name="email" class="form-control input-update"
                                    placeholder="Nhập email" value="{{ old('email') }}">
                                <span class="error-message email-error text-danger "></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <input type="password" name="password" class="form-control input-update"
                                    placeholder="Nhập mật khẩu" value="{{ old('password') }}">
                                <span class="error-message password-error text-danger "></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nhập lại mật khẩu</label>
                                <input type="password" name="password_confirmation" class="form-control input-update"
                                    placeholder="Nhập lại mật khẩu" value="{{ old('password_confirmation') }}">
                                <span class="error-message password-error text-danger "></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-edit btn btn-secondary"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Sửa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal delete user's account -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-small">
                <div class="modal-content">
                    <form method="POST" action="" id="form_delete_account">
                        @method('delete')
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Xoá tài khoản người dùng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5 id="description-delete-user"></h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-edit btn btn-secondary"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(function() {
        $("#form_add").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                beforeSend: function() {
                    $(`span.error-message`).text('')
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, item) {
                            $(`span.${prefix}-error`).text(item[0])
                        })
                    } else {
                        if (data.status == 1) {
                            alert(data.message)
                        } else {
                            $(document).ajaxStop(function() {
                                window.location.reload();
                            });
                        }
                    }
                }
            })
        })
    })
</script>

<script>
    $(function() {
        $(".btn-edit").on('click', function(e) {

            $("#form_update").attr('action', `/user/update-user/${$(this).data('id')}`);
            let data = {
                'name': $(this).data('name'),
                'role': $(this).data('role')
            }
            $(":input.input-update").each(function() {
                $(this).val(data[$(this).attr('name')]);
            })
            $(":input.input-role").each(function() {
                if (data[$(this).attr('name')] == $(this).attr('value')) {
                    if ($(this).is(':checked') === false) {
                        $(this).prop('checked', true);
                    }
                }
            })
        })
        $("#form_update").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                beforeSend: function() {
                    $(`span.error-message`).text('')
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, item) {
                            $(`span.${prefix}-error`).text(item[0])
                        })
                    } else {
                        if (data.status == 1) {
                            alert(data.message)
                        } else {
                            $(document).ajaxStop(function() {
                                window.location.reload();
                            });
                        }
                    }
                }
            })
        })

    })
</script>

<script>
    $(function() {
        $(".btn-edit-account").on('click', function(e) {

            $("#form_update_account").attr('action', `/user/update-user-account/${$(this).data('id')}`);
            let data = {
                'email': $(this).data('email'),
            }
            $(":input.input-update").each(function() {
                $(this).val(data[$(this).attr('name')]);
            })
        })
        $("#form_update_account").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                beforeSend: function() {
                    $(`span.error-message`).text('')
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, item) {
                            $(`span.${prefix}-error`).text(item[0])
                        })
                    } else {
                        if (data.status == 1) {
                            alert(data.message)
                        } else {
                            $(document).ajaxStop(function() {
                                window.location.reload();
                            });
                        }
                    }
                }
            })
        })

    })
</script>

<script>
    $(function() {
        $(".btn-delete-account").on('click', function(e) {
            $("#form_delete_account").attr('action', `/user/delete-user-account/${$(this).data('id')}`);
            $("#description-delete-user").text(`Bạn chắc chắn xóa người dùng ${$(this).data('name')}`)
        })
    })
</script>
