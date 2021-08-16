@extends('layouts.app')

@section('page-styles')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@endsection

@section('content')

<div class="container">
  <div class="row">
    <div class="col-12">
      <h1 class="center-text gold-title cinzel-font font-thick margin-sides">@lang('reward.title_1') <br> @lang('reward.title_2')</h1>
    </div>
    <div class="col-12">
      <img src="{{ asset('img/premios/clubestrella_rewards.png') }}" alt="ClubEstrella Rewards" class="center-item img-fluid margin-end-50">
    </div>
  </div>
  @if($errors->any())
      <div class="alert alert-danger reward_errors" >
          <ul style="list-style: none;">
              @foreach($errors->all() as $error)
                  <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{$error}}</li>
              @endforeach
          </ul>
      </div>
  @endif
  <div class="row">
    <div class="col-12 col-sm-6">
      <p class="choose-detail"> @lang('reward.p1')</p>
    </div>
    <div class="col-12 col-sm-6">
      <form action="{{ route('checkout',App::getLocale()) }}" method="POST" class="cart-detail">
        @csrf
        <input type="hidden" name="items_check" id="items_check" value="@if (Cookie::get('products') !== NULL){{ Cookie::get('products') }}@endif">
        <button type="submit">@lang('reward.p2')</button>
        <div class="row margin-cero purple-C">
          <div class="col-6 col-sm-6">
            <p>@lang('reward.p3'):</p>
          </div>
          <div class="col-6 col-sm-6">
          <p id="points" data="{{ Auth::user()->puntos->puntos_totales }}">{{ number_format(Auth::user()->puntos->puntos_totales) }} pts</p>
          </div>
          <div class="col-6 col-sm-6">
            <p>@lang('reward.p4'):</p>
          </div>
          <div class="col-6 col-sm-6">
            <p id="minus-points" data="@if (Cookie::get('minus-points') !== NULL){{ Cookie::get('minus-points') }}@else 0 @endif">
              @if (Cookie::get('minus-points') !== NULL)
                {{ Cookie::get('minus-points') }} pts
              @else
                0 pts
              @endif 
            </p>
          </div>
          <div class="col-12 col-sm-12">
            <div class="line-bottom"></div>
          </div>
          <div class="col-6 col-sm-6">
            <p>@lang('reward.p5'):</p>
          </div>
          <div class="col-6 col-sm-6">
            <p id="total-points" data="@if (Cookie::get('total-points') !== NULL){{ Cookie::get('total-points') }}@else 0 @endif"> 
              @if (Cookie::get('total-points') !== NULL)
                {{ Cookie::get('total-points') }} pts
              @else
                0 pts
              @endif 
            </p>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="row margin-start-80">
    <div class="col-12 col-md-3">
      <div class="filters-group">
        <label for="filters-search-input" class="filter-label">@lang('reward.p6')</label>
        <input class="textfield filter__search js-shuffle-search" type="search" id="filters-search-input" />
      </div>
    </div>
    <div class="col-12 col-md-6 filters-group-wrap">
      <div class="filters-group">
        <p class="filter-label">@lang('reward.p7')</p>
        <div class="btn-group filter-options">
          <button class="btn_reward btn--primary" data-group="">@lang('reward.p8')</button>
          <button class="btn_reward btn--primary" data-group="eventos">@lang('reward.p9')</button>
          <button class="btn_reward btn--primary" data-group="adhara">Adhara</button>
          <button class="btn_reward btn--primary" data-group="clubestrella">ClubEstrella</button>
          <!--button class="btn btn--primary" data-group="city">City</button-->
        </div>
      </div>
    </div>
    <!--div class="col-12 col-md-6">
      <fieldset class="filters-group">
        <legend class="filter-label">Sort</legend>
        <div class="btn-group sort-options">
          <label class="btn_reward active">
            <input type="radio" name="sort-value" value="dom" checked /> Default
          </label>
          <label class="btn_reward">
            <input type="radio" name="sort-value" value="title" /> Título
          </label>
        </div>
      </fieldset>
    </div-->
  </div>
</div>

<div class="container">
  <div id="grid" class="row my-shuffle-container">
    @foreach ($recompensas as $recompensa)
      @php
          $tags = json_decode($recompensa->tag);
          $cont = 1;
      @endphp
      <figure class="col-12 col-sm-6 col-md-3 picture-item picture-item--overlay" data-groups='[@php
      if(count($tags) > 1){
        foreach ($tags as $tag) {
          if ($cont < count($tags)) {
            echo'"'.$tag.'",';
          }else if($cont == count($tags)){
            echo'"'.$tag.'"';
          }
          $cont++;
        } 
      }else{
        foreach ($tags as $tag) {
          echo'"'.$tag.'"';
        } 
      }@endphp]' data-title="{{ $recompensa->nombre }}">
        <div class="controls-item d-flex justify-content-center" id="control-{{ $recompensa->id }}" pts_control="{{ $recompensa->puntos }}">
          @if (Cookie::get('products') !== NULL)
            @foreach (json_decode(Cookie::get('products')) as $item)
              @if ($item->id == $recompensa->id)  
                <button class="btn_minus" data_id="{{ $item->id }}" data_qty="{{ $item->qty }}"><i class="fas fa-minus"></i></button>
                <span class="badge badge-light align-self-center" id="count-{{ $item->id }}">{{ $item->qty }}</span>
                <button class="btn_add" data_id="{{ $item->id }}" data_qty="{{ $item->qty }}" pts_control="{{ $recompensa->puntos }}"><i class="fas fa-plus"></i></button>
              @endif
            @endforeach
          @endif
        </div>
        <p class="picture-item__title">{{ Str::upper($recompensa->nombre) }}</p>
        <div class="picture-item__inner">
          @php
              $img = json_decode($recompensa->imgs);
          @endphp
          <img src="{{ asset($img[0]) }}" alt="{{ $recompensa->nombre }}" class="img-fluid" />
          <div class="picture-item__details">
            <figcaption class="picture-description"><a href="#" target="_blank" rel="noopener">{{ $recompensa->descripcion }}</a></figcaption>
            <p class="item_points">{{ number_format($recompensa->puntos) }} puntos</p>
            <!--p class="picture-item__tags hidden@xs"> Tag: {{ $tags[0] ?? 'none' }}</p-->
          <button class="item_btn" object_id="{{$recompensa->id}}" name_item = "{{ $recompensa->nombre }}" desc_item = "{{ $recompensa->descripcion }}" url_item = "{{ asset($img[0]) }}" pts_item="{{ $recompensa->puntos }}">@lang('reward.p10')</button>
          </div>
        </div>
      </figure>
    @endforeach
  </div>
</div>
<!-- Scroll to Top button selector -->
<a href="#" class="scroll-to-top"> <i class="fas fa-arrow-up"></i> <span class="sr-only">Ir arriba</span></a>

@endsection

@section('page-scripts')
  <script src="{{ asset('js/shuffle/shuffle.js') }}"></script>
  <script src="{{ asset('js/recompensas.js') }}"></script>
  <script src="{{ asset('js/jquery.toTop.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/js-cookie@2.2.1/src/js.cookie.min.js"></script>
  <script type="text/javascript">
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success custom-btn-reward',
        cancelButton: 'btn btn-danger custom-btn-reward'
      },
      buttonsStyling: false
    })

    
    
    $(document).ready(function(){

      var lang = "{{ App::getLocale() }}";
      var no_points = "no se agregó porque no cuenta con los puntos suficientes.";
      var question = "Deseas agregar estre producto?";
      var add_item = "se agregó sin problemas.";
      var action = "No cuentas con los puntos suficientes para hacer esa acción.";
      var add_button = "Agregar!";
      var cancel_button = 'Cancelar!';
      var succes_text = "Exito!";
      var add = "Deseas agregar este producto?";
      if(lang == "en"){
        add = "Do you wish to add this product?"
        no_points = " didnt add because you dont have enought points.";
        add_item = 'added with no problems';
        action = "You dont have enought points to do that.";
        add_button = "Add";
        cancel_button = 'Cancel';
        succes_text = "Success!";
      }

      $(window).scroll(function(){
        if ( $(this).scrollTop() > 100 ) {
          $('.scroll-to-top').fadeIn();
        } else {
          $('.scroll-to-top').fadeOut();
        }
      });
      // al hacer click, animar el scroll hacia arriba
      $('.scroll-to-top').click( function( e ) {
        e.preventDefault();
        $('html, body').animate( {scrollTop : 0}, 800 );
      });


      $('.item_btn').click(function(){
        swalWithBootstrapButtons.fire({
          title: $(this).attr('name_item'),
          text: add,
          imageUrl: $(this).attr('url_item'),
          imageWidth: 200,
          imageHeight: 200,
          imageAlt: $(this).attr('name_item'),
          showCancelButton: true,
          confirmButtonText: add_button,
          cancelButtonText: cancel_button,
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            var disponible = parseInt($('#points').attr('data'));
            var minus = parseInt($('#minus-points').attr('data'));
            var product_points = parseInt($(this).attr('pts_item'));
            var id = parseInt($(this).attr('object_id'));
            var total_minus = minus + product_points;
            var total = disponible - total_minus;
            if (total_minus > disponible) {
              swalWithBootstrapButtons.fire(
                'Opps!',
                $(this).attr('name_item')+' '+no_points,
                'error'
              )
            } else {
              
              $("#minus-points").attr('data',total_minus);
              $("#minus-points").html('');
              $("#minus-points").html(total_minus+' pts');
              $("#total-points").attr('data',total);
              $("#total-points").html('');
              $("#total-points").html(total+' pts');
              var product_list = [];
              var new_list = [];
              var apuntador = 0;
              var sum_item = 0;
              var product = new Object();
              if(Cookies.get('products') != undefined){
                var product_prev = JSON.parse(Cookies.get('products'));
                product_prev.forEach(producto => {
                  if(id == producto.id) {
                    producto.qty = producto.qty + 1;
                    apuntador = 1;
                    sum_item = 1;
                  }
                  else{
                    product.id = id;
                    product.qty = 1;
                    sum_item = 1;
                    new_list.push(product);
                  }
                });

                if(apuntador == 0){
                  if(new_list.length > 1){
                    var arr_item = [];

                    arr_item.push(new_list[0]);
                    product_list = $.merge(product_prev,arr_item);
                  }else{
                    product_list = $.merge(product_prev,new_list);
                  }
                }else{
                  product_list = product_prev;
                }
                var response = JSON.stringify(product_list);
                Cookies.set('products',response);
                var qty = 0;
                if($("#count-"+id).html() == undefined){
                  qty = 1;
                }else{

                  qty = parseInt($("#count-"+id).html()) + sum_item;
                }

                $("#control-"+id).html('');
                $("#control-"+id).append('<button class="btn_minus" data_id="'+id+'" data_qty="'+qty+'"><i class="fas fa-minus"></i></button><span class="badge badge-light align-self-center" id="count-'+id+'">'+qty+'</span><button class="btn_add" data_id="'+id+'" data_qty="'+qty+'" pts_control="'+product_points+'"><i class="fas fa-plus"></i></button>');
                
              }else{

                product.id = id;
                product.qty = 1;
                product_list.push(product);
                var response = JSON.stringify(product_list);
                Cookies.set('products',response);
                var qty = 1;
                $("#control-"+id).html('');
                $("#control-"+id).append('<button class="btn_minus" data_id="'+id+'" data_qty="'+qty+'"><i class="fas fa-minus"></i></button><span class="badge badge-light align-self-center" id="count-'+id+'">'+qty+'</span><button class="btn_add" data_id="'+id+'" data_qty="'+qty+'" pts_control="'+product_points+'"><i class="fas fa-plus"></i></button>');
              }

            
              Cookies.set('minus-points', total_minus);
              Cookies.set('total-points', total);
              $("#items_check").val(response);
              
              swalWithBootstrapButtons.fire(
                succes_text,
                $(this).attr('name_item')+' '+add_item,
                'success'
              )
            }
          } 
        })

      });

      $('.controls-item').on('click','button.btn_minus',function(){
        var id = $(this).attr('data_id');
        if(Cookies.get('products') != undefined){
          var productos = JSON.parse(Cookies.get('products'));
          productos.forEach(producto => {

            if(id == producto.id){
              if(producto.qty > 1){
                producto.qty = producto.qty -1;
                var disponible = parseInt($('#points').attr('data'));
                var pts = $("#control-"+id).attr("pts_control");
                var minus = parseInt($('#minus-points').attr('data'));
                var total_minus = minus - pts;
                var total = disponible - total_minus;
                $("#minus-points").attr('data',total_minus);
                $("#minus-points").html('');
                $("#minus-points").html(total_minus+' pts');
                $("#total-points").attr('data',total);
                $("#total-points").html('');
                $("#total-points").html(total+' pts');
                Cookies.set('minus-points', total_minus);
                Cookies.set('total-points', total);
                

                $("#control-"+id).html('');
                $("#control-"+id).append('<button class="btn_minus" data_id="'+id+'" data_qty="'+producto.qty+'"><i class="fas fa-minus"></i></button><span class="badge badge-light align-self-center" id="count-'+id+'">'+producto.qty+'</span><button class="btn_add" data_id="'+id+'" data_qty="'+producto.qty+'" pts_control="'+pts+'"><i class="fas fa-plus"></i></button>');
              }else
              {
                productos.splice($.inArray(producto, productos),1);
                var disponible = parseInt($('#points').attr('data'));
                var pts = $("#control-"+id).attr("pts_control");
                var minus = parseInt($('#minus-points').attr('data'));
                var total_minus = minus - pts;
                var total = disponible - total_minus;
                $("#minus-points").attr('data',total_minus);
                $("#minus-points").html('');
                $("#minus-points").html(total_minus+' pts');
                $("#total-points").attr('data',total);
                $("#total-points").html('');
                $("#total-points").html(total+' pts');
                Cookies.set('minus-points', total_minus);
                Cookies.set('total-points', total);

                $("#control-"+id).html("");
                return false;
              }
            }
          });
          if(productos.length == 0){
            Cookies.remove('products');
            Cookies.remove('minus-points');
            Cookies.remove('total-points');
          }else{
            var response = JSON.stringify(productos);
            $("#items_check").val(response);
            Cookies.set('products',response);
          }
        }
      });


      $('.controls-item').on('click','button.btn_add',function(){
        var disponible = parseInt($('#points').attr('data'));
        var minus = parseInt($('#minus-points').attr('data'));
        var product_points = parseInt($(this).attr('pts_control'));
        var id = parseInt($(this).attr('data_id'));
        var total_minus = minus + product_points;
        var total = disponible - total_minus;
        if (total_minus > disponible) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: action,
            //footer: '<a href>Why do I have this issue?</a>'
          })
        }else{

          $("#minus-points").attr('data',total_minus);
          $("#minus-points").html('');
          $("#minus-points").html(total_minus+' pts');
          $("#total-points").attr('data',total);
          $("#total-points").html('');
          $("#total-points").html(total+' pts');
          var product_list = [];
          var new_list = [];
          var apuntador = 0;
          var sum_item = 0;
          var product = new Object();
          if(Cookies.get('products') != undefined){
            var product_prev = JSON.parse(Cookies.get('products'));
            product_prev.forEach(producto => {
              if(id == producto.id) {
                producto.qty = producto.qty + 1;
                apuntador = 1;
                sum_item = 1;
              }
              else{
                product.id = id;
                product.qty = 1;
                sum_item = 1;
                new_list.push(product);
              }
            });

            if(apuntador == 0){
              if(new_list.length > 1){
                var arr_item = [];

                arr_item.push(new_list[0]);
                product_list = $.merge(product_prev,arr_item);
              }else{
                product_list = $.merge(product_prev,new_list);
              }
            }else{
              product_list = product_prev;
            }
            var response = JSON.stringify(product_list);
            Cookies.set('products',response);
            var qty = 0;
            if($("#count-"+id).html() == undefined){
              qty = 1;
            }else{

              qty = parseInt($("#count-"+id).html()) + sum_item;
            }

            $("#control-"+id).html('');
            $("#control-"+id).append('<button class="btn_minus" data_id="'+id+'" data_qty="'+qty+'"><i class="fas fa-minus"></i></button><span class="badge badge-light align-self-center" id="count-'+id+'">'+qty+'</span><button class="btn_add" data_id="'+id+'" data_qty="'+qty+'" pts_control="'+product_points+'"><i class="fas fa-plus"></i></button>');
            
          }else{

            product.id = id;
            product.qty = 1;
            product_list.push(product);
            var response = JSON.stringify(product_list);
            Cookies.set('products',response);
            var qty = 1;
            $("#control-"+id).html('');
            $("#control-"+id).append('<button class="btn_minus" data_id="'+id+'" data_qty="'+qty+'"><i class="fas fa-minus"></i></button><span class="badge badge-light align-self-center" id="count-'+id+'">'+qty+'</span><button class="btn_add" data_id="'+id+'" data_qty="'+qty+'" pts_control="'+product_points+'"><i class="fas fa-plus"></i></button>');
          }

          
          Cookies.set('minus-points', total_minus);
          Cookies.set('total-points', total);
          $("#items_check").val(response);
        }
      });

    });
    
  </script>
@endsection
