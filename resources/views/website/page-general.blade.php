@extends('layout.layout-page', ['active' => $active])
@section('title', $pageTitle)
@section('style')
<link href="{{ asset('website/assets/css/page.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
<h2>{{ @$detail->title }} {!! @$detail->subtitle ? '<div class="subtitle">'.@$detail->subtitle.'</div>' : ''!!}</h2>

@endsection

@section('pageGeneral')
<section class="error-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                @if(@$detail->featured_img)
                    <img src="{{ asset(@$detail->featured_img) }}" style="width: 100%; height: 250px; object-fit: cover; margin-bottom: 10px"/>
                @endif
                {!! @$detail->content !!}
            </div>
        </div>
    </div>
</section>
@endsection