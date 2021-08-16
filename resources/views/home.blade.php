@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <img src="{{ asset('img/logos/clubestrella_gold.png') }}" class="center-item" id="goldLogo" alt="Club Estrella">
        </div>
    </div>
    <h1 class="center-text gold-title cinzel-font font-thick margin-sides">{{ Auth::user()->nombre }} </h1>
    <h2 class="center-text gold-title cinzel-font font-thick margin-sides">@lang('dashboard.welcome') <br> @lang('dashboard.club_h1') </h2>
    <div class="center-item margin-sides" id="textPrograma">
        <p class="center-text white-T cinzel-font">@lang('dashboard.p1_welcome')</p>
    </div>
</div>
@endsection
