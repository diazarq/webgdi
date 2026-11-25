@extends('layout.layout-page')
@section('title', $pageTitle)

@section('style')
<style>
    .project-details__tab-box-story p {
        margin-bottom: 50px;
        font-weight: 500;
    }
    .project-details__tab-box-story figure > img{
        width: 100%;
        margin-bottom: 40px;
    }
    .accrodion-content > .inner p{
        margin-bottom: 30px;
    }
    .accrodion-content > .inner figure > img{
        width: 100%;
        margin-bottom: 30px;
    }
</style>
@endsection

@section('breadcrumb')
<h2>{{ @$detail->title ? @$detail->title : $pageTitle }}</h2>
@endsection

@section('pageProgram')
@php
    $percentage = (@$detail->donasi / @$detail->target_nominal) * 100;
    $days = App\Helper::totalDays(@$detail->date_end);
@endphp
<!--Project Details Top Start-->
<section class="project-details-top">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-lg-4">
                <div class="project-details-top__left">
                    <div class="project-details-top__img">
                        <img src="{{ asset(@$detail->image_upload) }}" alt="">
                        <div class="project-details-top__icon">
                            <i class="far fa-heart"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8">
                <div class="project-details-top__right">
                    <div class="project-details-top__tag-address">
                        <div class="project-details-top__tag">
                            <p>{{ @$detail->category }}</p>
                        </div>
                        <!--
                        <div class="project-details-top__address">
                            <p><i class="fas fa-map-marker"></i>ShenZhen, China</p>
                        </div>
                        -->
                    </div>
                    <h3 class="project-details-top__title">{{ @$detail->title }}</h3>

                    @if(@$detail->program_type == 'donation')
                    @if($days < 0)
                    <div class="alert alert-warning" style="border-radius: 0px">Program sudah berakhir, namun Anda masih diperbolehkan untuk berdonasi melalui program ini dan donasi Anda akan dialokasikan untuk program sosial lain yang sedang berjalan</div>
                    @endif
                    <ul class="list-unstyled project-details-top__list">
                        <li>
                            <div class="project-details-top__list-content">
                                <h3>Rp. {{ number_format(@$detail->donasi) }}</h3>
                                <p>Terkumpul</p>
                            </div>
                        </li>
                        <li>
                            <div class="project-details-top__list-content">
                                <h3>{{ number_format(@$detail->donatur) }}</h3>
                                <p>Donatur</p>
                            </div>
                        </li>
                        <li>
                            <div class="project-details-top__list-content">
                                <h3>{{ $days < 0 ? '-' : number_format($days)}}</h3>
                                <p>{{ $days < 0 ? 'Program Berakhir' : 'Sisa Hari'}}</p>
                            </div>
                        </li>
                    </ul>
                    <div class="progress-levels">
                        <!--Skill Box-->
                        <div class="progress-box">
                            <div class="inner count-box">
                                <div class="text">Target</div>
                                <div class="bar">
                                    <div class="bar-innner">
                                        <div class="skill-percent">
                                            <span class="count-text" data-speed="3000" data-stop="{{ $percentage }}">0</span>
                                            <span class="percent">%</span>
                                        </div>
                                        <div class="bar-fill" data-percent="{{ $percentage }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="project-details-top__goal"><span>Target:</span> Rp. {{ number_format(@$detail->target_nominal) }}</p>
                    <p class="project-details-top__text">Donasi dapat diserahkan langsung ke kantor Yayasan Graha Dhuafa Indonesia atau dapat dilakukan melalui transfer bank.
                    </p>
                    @else
                    <div class="about-one__quote"><p>{{ @$detail->short_desc }}</p></div>
                    <br/>
                    <p class="project-details-top__text">Pembayaran dapat diserahkan langsung ke kantor Yayasan Graha Dhuafa Indonesia atau dapat dilakukan melalui transfer bank.
                    </p>
                    @endif
                    
                    <div class="project-details-top__quantity-btn-social">
                        <a href="project-01.html" class="thm-btn project-details-top__btn">{{ @$detail->program_type == 'donation' ? 'Donasi' : 'Tunaikan'}} Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Project Details Top End-->

<!--Project Details Bottom Start-->
<section class="project-details-bottom">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="project-details__tab-box tabs-box">
                    <ul class="tab-buttons clearfix list-unstyled clearfix">
                        <li data-tab="#desc" class="tab-btn active-btn"><span>Deskripsi</span></li>

                        @if(@$detail->program_type == 'donation')
                            <li data-tab="#action" class="tab-btn"><span>Realisasi {{ @$programRealisasi ? '('.count($programRealisasi).')' : ''}}</span></li>
                        @endif
                    </ul>
                    <div class="tabs-content">
                        <!--tab-->
                        <div class="tab active-tab" id="desc">
                            <div class="project-details__tab-box-story">
                                {!! @$detail->description !!}
                            </div>
                        </div>
                        <!--tab-->
                        <div class="tab " id="action">
                            @if(@$programRealisasi)
                            <div class="project-details__faq">
                                <div class="accrodion-grp faq-one-accrodion"
                                    data-grp-name="faq-one-accrodion-1">
                                @foreach($programRealisasi as $key => $dt)
                                    <div class="accrodion {{ $key == 0 ? 'active' : ''}}">
                                        <div class="accrodion-title">
                                            <h4>{{ $dt->title }}</h4>
                                        </div>
                                        <div class="accrodion-content">
                                            <div class="inner">
                                                {!! $dt->description !!}
                                            </div><!-- /.inner -->
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                            @else
                                <div class="alert alert-warning" style="border-radius: 0px">Belum ada kegiatan realisasi</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="project-details__right">
                    @if(@$programService)
                        @foreach($programService as $dt)
                            <div class="project-details__rewards">
                                <h5 class="project-details__rewards-title">{{ $dt->title }}</h5>
                                <div class="project-details__rewards-img">
                                    <img src="{{ asset($dt->image_upload) }}" alt="">
                                </div>
                                <p class="project-details__rewards-text-1">{{ @$detail->short_desc }}</p>
                                <div class="project-details__rewards-btn-box">
                                    <a href="/program/{{ $dt->slug }}" class="thm-btn project-details__rewards-btn">Tunaikan Sekarang</a>
                                </div>
                            </div>
                            <br/>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!--Project Details Bottom End-->

<!--Similar Project Start-->
<section class="similar-project">
    <div class="container">
        <div class="section-title text-center">
            <span class="section-title__tagline">Program Donasi</span>
            <h2 class="section-title__title">Telusuri Program Donasi<br/>Lainnya</h2>
        </div>

        @if(@$programSuggest)
            <div class="row">
                @php 
                    $no = 1; 
                @endphp
                @foreach($programSuggest as $key=>$dt)
                    @php
                        $persen = (@$dt->donasi / @$dt->target_nominal) * 100;
                        $hari = App\Helper::totalDays(@$dt->date_end);
                    @endphp
                    <!--Project One Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="{{ $no++.'ms'}}">
                        <div class="project-one__single">
                            <div class="project-one__img-box">
                                <div class="project-one__img">
                                    <img src="{{ asset($dt->image_upload) }}" alt="">
                                </div>
                                <div class="project-one__icon">
                                    <i class="far fa-heart"></i>
                                </div>
                            </div>
                            <div class="project-one__content">
                                <div class="project-one__tag">
                                    <p>{{ $dt->category }}</p>
                                </div>
                                <h3 class="project-one__title" style="height: 70px"><a href="/program/donasi/{{ $dt->slug }}">{{ $dt->title }}</a></h3>
                                <div class="project-one__remaing">
                                    <div class="icon">
                                        <i class="fa fa-clock"></i>
                                    </div>
                                    <div class="text">
                                        <p>{{ $hari < 0 ? 'Program Berakhir' : number_format($hari).' Hari Lagi' }}</p>
                                    </div>
                                </div>
                                <div class="progress-levels">
                                    <!--Skill Box-->
                                    <div class="progress-box">
                                        <div class="inner count-box">
                                            <div class="text">Target</div>
                                            <div class="bar">
                                                <div class="bar-innner">
                                                    <div class="skill-percent">
                                                        <span class="count-text" data-speed="3000"
                                                            data-stop="{{ $persen }}">0</span>
                                                        <span class="percent">%</span>
                                                    </div>
                                                    <div class="bar-fill" data-percent="{{ $persen }}"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="project-one__goals">
                                    <p class="project-one__goals-one" style="text-align: left">Terkumpul:<br/><span>{{ 'Rp. '.number_format($dt->donasi) }}</span></p>
                                    <p class="project-one__goals-one" style="text-align: right">Target Pencapaian:<br/><span>{{ 'Rp. '.number_format($dt->target_nominal) }}</span></p>
                                </div>
                                <br/>
                                <a href="/program/donasi/{{ $dt->slug }}" class="thm-btn">Donasi Sekarang</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
<!--Similar Project End-->
@endsection