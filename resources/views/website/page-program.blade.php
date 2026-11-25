@extends('layout.layout-page')
@section('title', $pageTitle)

@section('breadcrumb')
<h2>{{ @$detail->title ? @$detail->title : $pageTitle }}</h2>
@endsection

@section('pageProgram')
<section class="project-page-one">
    <div class="container">
        @if(@$program)
            <div class="row">
            @foreach($program as $pg)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="project-one__single">
                        <div class="project-one__img-box">
                            <div class="project-one__img">
                                <img src="{{ asset($pg->image_upload) }}" alt="">
                            </div>
                            <div class="project-one__icon">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
                        <div class="project-one__content">
                            <div class="project-one__tag">
                                <p>{{ $pg->category }}</p>
                            </div>
                            <h3 class="project-one__title" style="height: 70px">{{ $pg->title }}</h3>
                            <!--<h3 class="project-one__title" style="height: 70px"><a href="/program/donasi/{{ $pg->slug }}">{{ $pg->title }}</a></h3>-->

                            <!--
                            
                            <div class="project-one__remaing">
                                <div class="icon">
                                    <i class="fa fa-clock"></i>
                                </div>
                                <div class="text">
                                    @php
                                        $percentage = ($pg->donasi / $pg->target_nominal) * 100;
                                        $days = App\Helper::totalDays($pg->date_end);
                                    @endphp
                                    <p>{{ $days >= 0 ? $days.' Hari Lagi' : 'Program Berakhir' }}</p>
                                </div>
                            </div>
                            <div class="progress-levels">
                                <div class="progress-box">
                                    <div class="inner count-box">
                                        <div class="text">Target</div>
                                        <div class="bar">
                                            <div class="bar-innner">
                                                <div class="skill-percent">
                                                    <span class="count-text" data-speed="3000"
                                                        data-stop="{{$percentage}}">0</span>
                                                    <span class="percent">%</span>
                                                </div>
                                                <div class="bar-fill" data-percent="{{$percentage}}"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="project-one__goals">
                                <p class="project-one__goals-one" style="text-align: left">Terkumpul:<br/><span>Rp. {{ number_format($pg->donasi) }}</span></p>
                                <p class="project-one__goals-one" style="text-align: right">Target Pencapaian:<br/><span>Rp. {{ number_format($pg->target_nominal) }}</span></p>
                            </div>
                            <br/>
                            <a href="/program/donasi/{{ $pg->slug }}" class="thm-btn">Donasi Sekarang</a>
                            -->
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        @endif
    </div>
</section>
@endsection