@extends('layouts.app')

@section('page-styles')
    <script src="{{ asset('js/datedropper.pro.min.js') }}"></script>
@endsection

@section('content')

<div class="container">
    <div class="header_checkout">
        <img src="{{ asset('img/premios/eventos_rewards.png') }}" alt="Eventos Rewards" class="center-item margin-end-50 margin-start-50">
    </div>
    <div class="row">
        @if(session('error'))
            <div class="col-12">
                <div class="alert alert-danger alertStyle" role="alert">
                    <p><i class="fas fa-exclamation-triangle margin-right-15"></i>{{ session('error') }}</p>
                </div>
            </div> 
        @endif
        @if (session('success'))
            <div class="col-12">
                <div class="alert alert-success alertStyle" role="alert">
                    <p><i class="fas fa-thumbs-up margin-right-15"></i>{{ session('success') }}</p>
                </div>
            </div> 
        @endif
        <div class="col-12 col-sm-8 offset-sm-2">
            <form action="{{ route('payment',App::getLocale()) }}" method="POST" id="checkoutConfirm">
                @csrf
                <div class="row">
                    <div class="col-8 col-sm-8">
                        <p class="th">@lang('checkout.reward')</p>
                    </div>
                    <div class="col-3 col-sm-2 center-text">
                        <p class="th">@lang('checkout.points')</p>
                    </div>
                    <div class="col-3 col-sm-2 center-text desktop">
                        <p class="th">@lang('checkout.qty')</p>
                    </div>
                </div>
                <div class="row white-T"> 
                    @empty($list_rewards)
                        <div class="col-12">
                            <p style="text-align: center;"><i class="fas fa-exclamation" style="margin-right: 15px;"></i>@lang('checkout.empty')</p>
                        </div>
                        
                    @else
                        @foreach ($list_rewards as $reward)
                            @php
                                $imgs = json_decode($reward->imgs);
                            @endphp
                            @foreach ($rewards as $item)
                                    
                                @if ($item->id == $reward->id)
                                    @if ($reward->id == 36) <!-- En caso de que sea una habitacion -->
                                        <div class="col-8 col-sm-8">
                                            <img src="{{ asset($imgs[0]) }}" alt="{{ $reward->nombre }}" class="img-product">
                                            <p>{{ $reward->nombre }}</p>
                                            <span> <small>@lang('checkout.romdesc')</small></span>
                                            <!-- datedropper-init class -->
                                            <div class="datesBox">
                                                @php
                                                    $cont = 0;
                                                    $now = now()->format('m-d-Y');
                                                @endphp
                                                        
                                                <div class="row">
                                                    <div class="col-12 col-sm-6">
                                                        <label for="startDate">@lang('checkout.startDate')</label>
                                                        <input class="datedropper-init" type="text" name="startDate[]" data-dd-format="d-m-Y" data-dd-min-date="{{ $now }}" placeholder="dd/mm/YY" required>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <label for="startDate">@lang('checkout.endDate')</label>
                                                        <input class="datedropper-init" type="text" name="endDate[]" data-dd-format="d-m-Y" data-dd-min-date="{{ $now }}" placeholder="dd/mm/YY" required>
                                                    </div> 
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-3 col-sm-2 center-text"> <p>{{ ($reward->puntos * $item->qty)}} pts</p> </div>
                                        <div class="col-3 col-sm-2 center-text desktop"><p>{{ $item->qty }}</p></div>
                                        
                                    @else
                                        <div class="col-8 col-sm-8">
                                            <img src="{{ asset($imgs[0]) }}" alt="{{ $reward->nombre }}" class="img-product">
                                            <p>{{ $reward->nombre }}</p>
                                        </div>
                                        <div class="col-3 col-sm-2 center-text"><p>{{ ($reward->puntos * $item->qty)}} pts</p> </div>
                                        <div class="col-2 col-sm-2 center-text desktop"><p>{{ $item->qty }}</p></div>
                                    @endif
                                    <input type="hidden" name="product[id][]" value="{{ $reward->id }}">
                                    <input type="hidden" name="product[qty][]" value="{{ $item->qty }}">
                                @endif
                                
                            @endforeach
                            
                        @endforeach
                        <div class="col-12">
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}" readonly>
                            <button type="submit" class="btn-edit">@lang('checkout.canje')</button>
                            <div class="spinner">
                                <div class="rect1 contact-s"></div>
                                <div class="rect2 contact-s"></div>
                                <div class="rect3 contact-s"></div>
                                <div class="rect4 contact-s"></div>
                                <div class="rect5 contact-s"></div>
                            </div>
                        </div>
                        
                    @endempty
                </div>
            </form>
        </div>

    </div>
</div>



@endsection

@section('page-scripts')
    
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2.2.1/src/js.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script type="text/javascript"> 
        $(document).ready(function(){
            $(".btn-edit").click(function(){
                $(".btn-edit").css('display','none');
                $(".btn-danger").css('display','none');
                $(".spinner").css('display','block');
            });    
        });
    </script>
@endsection
