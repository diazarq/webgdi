@extends('layout.layout-page')
@section('title', $pageTitle)

@section('breadcrumb')
<h2>{{ @$detail->title ? @$detail->title : $pageTitle }}</h2>
@endsection

@section('pageGallery')
<!--Gallery Page Start-->
<section class="gallery-page">
    <div class="container">
        <div class="row">
            @if(@$files)
                @foreach($files as $val)
                    @php
                        $file = new SplFileInfo($val);
                        $val = 'images/gallery/'.$file->getFilename();
                    @endphp
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="gallery-page__single">
                            <div class="gallery-page__img">
                                <img src="{{ asset($val) }}" alt="" style="width: 100%; height: 300px; object-fit: cover">
                                <div class="gallery-page__icon">
                                    <a class="img-popup" href="{{ asset($val) }}"><span
                                            class="icon-plus-symbol"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('.news-sidebar__text').next().text();
    })
</script>
@endpush