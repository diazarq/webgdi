@extends('layout.app', ['active' => $active])
@section('meta')
    <meta name="csrf_token" id="csrf_token" content="{{ csrf_token() }}" />
@endsection
@section('title', ($pageTitle ?? 'CMS'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
        <li class="breadcrumb-item"><a href="/admin/menu">Menu</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $mode }}</li>
    </ol>
@endsection

@section('content')
<div class="container">
    <h5>Form {{ $mode }} Menu</h5>
    <a href="/admin/menu" class="btn btn-primary"><i class="bi-arrow-left-square"></i> Kembali</a>
    <hr/>

    <div class="row">
        <div class="col-md-8">
            <form method="post" action="/admin/menu/add" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" value="{{ @$detail->id }}"/>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Nama Menu *</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" required name="title" value="{{ @$detail->title }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Keterangan Menu</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="subtitle" value="{{ @$detail->subtitle }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Menu Parent *</label>
                    <div class="col-sm-6">
                        <select class="form-select" name="parent_id" required>
                            <option value="0">No Parent</option>
                            @if(@$parent)
                                @foreach($parent as $dt)
                                <option value="{{ $dt->id }}" {{ @$detail->parent_id == $dt->id ? 'selected' : ''}}>{{ $dt->title }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Slug *</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" required name="slug" value="{{ @$detail->slug }}">
                    </div>
                </div>
                <hr/>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Tipe Menu *</label>
                    <div class="col-sm-3">
                        <select class="form-select" name="menu_type" required>
                            <option value="page" {{ @$detail->menu_type == 'page' ? 'selected' : '' }}>Page</option>
                            <option value="url" {{ @$detail->menu_type == 'url' ? 'selected' : '' }}>URL</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">URL</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="url" value="{{ @$detail->url }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Page Content</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="content" id="redactor" placeholder="Isi konten halaman menu di sini...">{{ @$detail->content }}</textarea>
                    </div>
                </div>
                <hr/>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Featured Image</label>
                    <div class="col-sm-10">
                        <div class="preview-slider-img">
                            @php
                                $imgUrl = @$detail->featured_img ? asset(@$detail->featured_img) : asset('admin/assets/img/setting/_img.jpg');
                            @endphp
                            <img id="featured_img" src="{{ $imgUrl }}"/>
                        </div>
                        <input type="file" name="featured_img" style="display: none" id="img"/>
                        <label class="btn btn-primary btn-upload" for="img"><i class="bi-upload"></i> Upload</label>
                    </div>
                </div>
                <hr/>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Tipe Halaman *</label>
                    <div class="col-sm-3">
                        <select class="form-select" name="page_type" required>
                            @if(@$pageType)
                                @foreach($pageType as $key=>$val)
                                <option value="{{ $key }}" {{ @$detail->page_type == $key ? 'selected' : '' }}>{{$val}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Display Footer *</label>
                    <div class="col-sm-3">
                        <select class="form-select" name="footer_display" required>
                            <option value="NA" {{ @$detail->footer_display == 'NA' ? 'selected' : '' }}>Non Aktif</option>
                            <option value="A" {{ @$detail->footer_display == 'A' ? 'selected' : '' }}>Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Status Publish *</label>
                    <div class="col-sm-3">
                        <select class="form-select" name="status_display" required>
                            <option value="draft" {{ @$detail->status_display == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="publish" {{ @$detail->status_display == 'publish' ? 'selected' : '' }}>Publish</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">&nbsp;</label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary"><i class="bi-save"></i> Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('input[name="featured_img"]').change(function(){
                readImageUrl(this, 'featured_img', function(response){
                    //$('input[name="picture"]').val(response);
                });
            });

            $(document).on('keyup', 'input[name="title"]', function(){
                const regex = /\s/ig;
                var text = $(this).val();
                var slug = text.replaceAll(regex, '-').toLowerCase();
                $('input[name="slug"]').val(slug);
            });

            $('select[name="menu_type"]').change(function(){
                var ch = $(this).val();

                if(ch == 'url'){
                    $('input[name="url"]').attr('placeholder', 'Isi link (URL) di sini').focus();
                }else{
                    $('input[name="url"]').removeAttr('placeholder');
                }
            })
        })
    </script>
@endpush
