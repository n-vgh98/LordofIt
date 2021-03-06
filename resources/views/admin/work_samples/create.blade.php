@extends('admin.layouts.master')

@section('sitetitle')
    ایجاد نمونه کار برای {{ $category->title }}
@endsection


@section('pagetitle')
    ایجاد نمونه کار برای {{ $category->title }}
@endsection

@section('content')
    <section>

        <form action="{{ route('admin.work_samples.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- title of work sample --}}
            <div class="form-group row">
                <label for="title" class="col-md-1 col-form-label text-md-right">{{ __('عنوان نمونه کار') }}</label>

                <div class="col-md-11">
                    <input id="title" type="text" class="form-control" @error('title') is-invalid @enderror" name="title"
                        value="{{ old('title') }}" required autocomplete="title" autofocus>

                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            {{-- link of work sample --}}
            <div class="form-group row">
                <label for="link" class="col-md-1 col-form-label text-md-right">{{ __('لینک نمونه کار') }}</label>

                <div class="col-md-11">
                    <input id="title" type="text" class="form-control" @error('link') is-invalid @enderror" name="link"
                        value="{{ old('link') }}" autocomplete="link" autofocus>

                    @error('link')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            {{-- status of project --}}
            <div class="form-group row">
                <label for="status" class="col-md-1 col-form-label text-md-right">{{ __('وضعیت') }}</label>

                <div class="col-md-11">
                    <select name="status" class="custom-select">
                        <option value="1">تمام شده</option>
                        <option value="2">در حال پیشرفت</option>
                    </select>

                    @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            {{-- text of work_sample --}}
            <div class="form-group row">
                <label for="text" class="col-md-1 col-form-label text-md-right">{{ __('متن') }}</label>

                <div class="col-md-11">
                    <textarea id="body" type="text" class="form-control" @error('text') is-invalid @enderror" name="text"
                        value="{{ old('text') }}" cols="30" rows="" autocomplete="text" autofocus></textarea>

                    @error('text')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>


            {{-- path of photo --}}
            <div class="form-group row">
                <label for="path" class="col-md-1 col-form-label text-md-right">{{ __('عکس نمونه کار ') }}</label>

                <div class="col-md-11">
                    <input id="path" type="file" class="form-control" @error('path') is-invalid @enderror" name="path"
                        value="{{ old('path') }}" required autocomplete="path" autofocus>

                    @error('path')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            {{-- alt of photo --}}
            <div class="form-group row">
                <label for="alt" class="col-md-1 col-form-label text-md-right">{{ __('عکس alt') }}</label>

                <div class="col-md-11">
                    <input id="path" type="text" class="form-control" @error('alt') is-invalid @enderror" name="alt"
                        value="{{ old('alt') }}" required autocomplete="alt" autofocus>

                    @error('alt')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            {{-- name of photo --}}
            <div class="form-group row">
                <label for="img_name" class="col-md-1 col-form-label text-md-right">{{ __('عکس name') }}</label>

                <div class="col-md-11">
                    <input id="path" type="text" class="form-control" @error('img_name') is-invalid @enderror"
                        name="img_name" value="{{ old('img_name') }}" required autocomplete="img_name" autofocus>

                    @error('img_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <input name="category_id" type="hidden" value="{{ $category->id }}">

            <div style="margin-top:15px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">منصرف
                    شدم</button>
                <button type="submit" class="btn btn-primary">ارسال</button>
            </div>

        </form>

    </section>
@endsection
@section('script')

    <script src="{{ asset('adminpanel/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('body');
    </script>

@endsection
