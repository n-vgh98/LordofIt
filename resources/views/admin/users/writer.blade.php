@extends('admin.layouts.master')
@section('sitetitle')
    لیست کاربران نویسنده
@endsection
@section('content')
@section('pagetitle')
    کاربران نویسنده
@endsection
<section class="text-center">
    <div class="btn-group btn-group-toggle">
        <a href="{{ route('admin.admin.users') }}" class="btn btn-primary">admin</a>
        <a href="{{ route('admin.writer.users') }}" class="btn btn-primary">writers</a>
        <a href="{{ route('admin.normal.users') }}" class="btn btn-primary">users</a>
        <a href="{{ route('admin.users') }}" class="btn btn-primary">all users</a>
    </div>
</section>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">تنظیمات</th>
            <th scope="col">تغیر سطوح دسترسی </th>
            <th scope="col">دسترسی ها</th>
            <th scope="col">ایمیل</th>
            <th scope="col">نام</th>
            <th scope="col">شماره</th>
        </tr>
    </thead>
    <tbody>
        {{-- make number for rows --}}
        @php
            $number = 1;
        @endphp
        @foreach ($users as $user)
            @if ($user->email !== 'mohamadaghakhani@gmail.com')

                {{-- getting roles --}}
                @php
                    $rolesname = [];
                @endphp
                {{-- putting roles name into $rolesname --}}
                @foreach ($user->roles as $role)
                    @php
                        array_push($rolesname, $role->name);
                    @endphp
                @endforeach
                {{-- check if writer is in rolesname or not (check mikone ke writer hast ya na) --}}
                @if (in_array('writer', $rolesname)))

                    <tr>
                        <td>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="post">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-danger">حذف کاربر</button>

                            </form>

                        </td>


                        {{-- section for changing roles --}}
                        <td>
                            <div class="btn-group"> <button type="button" class="btn btn-info dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">تغیر سطح <span
                                        class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    @if (in_array('admin', $rolesname))
                                        <li>
                                            <form action="{{ route('admin.demote', $user->id) }}" method="POST"
                                                style="margin-right:15px;">
                                                @csrf
                                                <button type="submit" class="btn">قطع دسترسی ادمین</button>
                                            </form>
                                        </li>
                                    @else
                                        <li>
                                            <form action="{{ route('admin.promote', $user->id) }}" method="POST"
                                                style="margin-right:15px;">
                                                @csrf
                                                <button type="submit" class="btn">دادن دسترسی ادمین</button>
                                            </form>
                                        </li>
                                    @endif

                                    @if (in_array('writer', $rolesname))
                                        <li>
                                            <form action="{{ route('writer.demote', $user->id) }}" method="POST"
                                                style="margin-right:15px;">
                                                @csrf
                                                <button type="submit" class="btn">قطع دسترسی نویسنده</button>
                                            </form>
                                        </li>
                                    @else
                                        <li>
                                            <form action="{{ route('writer.promote', $user->id) }}" method="POST"
                                                style="margin-right:15px;">
                                                @csrf
                                                <button type="submit" class="btn">دادن دسترسی
                                                    نویسنده</button>
                                            </form>
                                        </li>
                                    @endif
                                    @if (count($rolesname) > 0)
                                        <li>
                                            <form action="{{ route('admin.user.clear.roles', $user->id) }}"
                                                method="POST" style="margin-right:15px;">
                                                @csrf
                                                <button type="submit" class="btn">قطع تمامی دسترسی ها
                                                </button>
                                            </form>
                                        </li>
                                    @endif

                                </ul>
                            </div>
                        </td>

                        {{-- change $rolesname to string to show roles --}}
                        @if (count($rolesname) !== 0)
                            <td>
                                {{ implode(',', $rolesname) }}

                            </td>
                        @else
                            {{-- if $rolesname is null so its user --}}
                            <td>User</td>
                        @endif


                        {{-- check if user is male of femail --}}
                        @if ($user->gender == 0)
                            <td>{{ 'مرد' }}</td>
                        @else
                            <td>{{ 'زن' }}</td>
                        @endif
                        {{-- check if user is male of femail --}}
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <th scope="row">{{ $number }}</th>
                    </tr>



                    @php
                        $number++;
                    @endphp
                @endif
            @endif

        @endforeach
    </tbody>
</table>
{{-- button to make user --}}
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    ساخت کاربر جدید
</button>

{{-- modal for making new user --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ساخت کاربر جدید </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="name"
                            class="col-md-4 col-form-label text-md-right">{{ __('نام و نام خانوادگی') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email"
                            class="col-md-4 col-form-label text-md-right">{{ __('آدرس ایمیل') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password"
                            class="col-md-4 col-form-label text-md-right">{{ __('رمز عبور') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password-confirm"
                            class="col-md-4 col-form-label text-md-right">{{ __('تکرار رمز عبور') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                    <div style="margin-top:15px;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">منصرف
                            شدم</button>
                        <button type="submit" class="btn btn-primary">ارسال</button>
                    </div>
                    <input type="hidden" name="mode" value="1">
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
@endsection
