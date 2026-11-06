@extends('layout.app', ['active' => $active])
@section('meta')
    <meta name="csrf_token" id="csrf_token" content="{{ csrf_token() }}" />
@endsection
@section('title', ($pageTitle ?? 'CMS'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="bi-house"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Navigasi</a></li>
        <li class="breadcrumb-item"><a href="/admin/blog">Blog</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $mode }}</li>
    </ol>
@endsection

@section('content')
<div class="container">
    <h5>Form {{ $mode }} Blog</h5>
    <a href="/admin/blog" class="btn btn-primary"><i class="bi-arrow-left-square"></i> Kembali</a>
    <hr/>

    <div class="row">
        <div class="col-md-8">
            <form method="post" action="/admin/blog/add" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" value="{{ @$detail->id }}"/>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Judul Blog *</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" required name="title" value="{{ @$detail->title }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Slug *</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" required name="slug" value="{{ @$detail->slug }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Author *</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" required name="author" value="{{ @$detail->author }}">
                    </div>
                </div>
                <hr/>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Tipe Halaman *</label>
                    <div class="col-sm-3">
                        <select class="form-select" name="page_type" required>
                            <option value="page" {{ @$detail->page_type == 'page' ? 'selected' : '' }}>Page</option>
                            <option value="url" {{ @$detail->page_type == 'url' ? 'selected' : '' }}>URL</option>
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
                    <label class="col-sm-2 col-form-label">Blog Content</label>
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
                                $imgUrl = @$detail->featured_img ? asset(str_replace('public', 'storage', @$detail->featured_img)) : asset('admin/assets/img/setting/sample-logo-1.png');
                            @endphp
                            <img id="featured_img" src="{{ $imgUrl }}"/>
                        </div>
                        <input type="file" name="featured_img" style="display: none" id="img"/>
                        <label class="btn btn-primary btn-upload" for="img"><i class="bi-upload"></i> Upload</label>
                    </div>
                </div>
                <hr/>
                <div class="mb-3 row">
    <label class="col-sm-2 col-form-label">Jenis *</label>
    <div class="col-sm-3">
        <select class="form-select" name="jenis" required>   
            <option value="salam" {{ @$detail->jenis == 'salam' ? 'selected' : '' }}>Salam</option>
            <option value="kegiatan" {{ @$detail->jenis == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
            <option value="journey" {{ @$detail->jenis == 'journey' ? 'selected' : '' }}>Journey</option>
        </select>
    </div>
</div>
<div class="mb-3 row"></div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Kategori *</label>
                    <div class="col-sm-4">
                        <select class="form-select" name="kategori" required>
                            <option value="uncategorized">Uncategorized</option>
                            @if(@$category)
                                @foreach($category as $cat)
                                    <option value="{{ $cat->kategori }}" {{ @$detail->kategori == $cat->kategori ? 'selected' : '' }}>{{ $cat->kategori }}</option>
                                @endforeach
                            @endif
                            <option value="_newcat">Kategori baru...</option>
                        </select>
                    </div>
                    <div class="col-sm-6" id="newcat" style="display: none">
                        <input type="text" name="kategori_baru" class="form-control" placeholder="kategori baru"/>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Status Publish *</label>
                    <div class="col-sm-3">
                        <select class="form-select" name="status" required>
                            <option value="draft" {{ @$detail->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="publish" {{ @$detail->status == 'publish' ? 'selected' : '' }}>Publish</option>
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
            });

            $('select[name="kategori"]').change(function(){
                var cat = $(this).val();
                if(cat == '_newcat'){
                    $('#newcat').show();
                    $('#newcat').find('input').val("").focus();
                }else{
                    $('#newcat').hide();
                }
            });
        })
    </script>
@endpush
