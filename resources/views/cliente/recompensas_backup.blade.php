@extends('layouts.app')

@section('page-styles')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@endsection

@section('content')

<div class="container">
  <div class="row">
    <div class="col-12">
      <h1 class="center-text gold-title cinzel-font font-thick margin-sides">RECOMPENSAS <br> CLUB ESTRELLA</h1>
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
      <p class="choose-detail"> Elije lo que deseas y al terminar haz click aquí.</p>
    </div>
    <div class="col-12 col-sm-6">
      <form action="{{ route('checkout',App::getLocale()) }}" method="POST" class="cart-detail">
        @csrf
        <input type="hidden" name="items_check" id="items_check" value="@if (Cookie::get('products') !== NULL){{ Cookie::get('products') }}@endif">
        <button type="submit">Terminar Canje</button>
        <div class="row margin-cero purple-C">
          <div class="col-12 col-sm-6">
            <p>Disponible:</p>
          </div>
          <div class="col-12 col-sm-6">
          <p id="points" data="{{ Auth::user()->puntos->puntos_totales }}">{{ number_format(Auth::user()->puntos->puntos_totales) }} pts</p>
          </div>
          <div class="col-12 col-sm-6">
            <p>Cuenta:</p>
          </div>
          <div class="col-12 col-sm-6">
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
          <div class="col-12 col-sm-6">
            <p>Restante:</p>
          </div>
          <div class="col-12 col-sm-6">
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
        <label for="filters-search-input" class="filter-label">Búsqueda</label>
        <input class="textfield filter__search js-shuffle-search" type="search" id="filters-search-input" />
      </div>
    </div>
    <div class="col-12 col-md-6 filters-group-wrap">
      <div class="filters-group">
        <p class="filter-label">Filtros</p>
        <div class="btn-group filter-options">
          <button class="btn_reward btn--primary" data-group="">Todos</button>
          <button class="btn_reward btn--primary" data-group="eventos">Eventos</button>
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
      @endphp
      <figure class="col-12 col-sm-6 col-md-3 picture-item picture-item--overlay" data-groups='[@php
            if(count($tags) > 1){
              foreach ($tags as $tag) {
                echo'"'.$tag.'",';
              } 
            }else{
              foreach ($tags as $tag) {
                echo'"'.$tag.'"';
              } 
            }
        @endphp]' data-title="{{ $recompensa->nombre }}">
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
          <button class="item_btn" object_id="{{$recompensa->id}}" name_item = "{{ $recompensa->nombre }}" desc_item = "{{ $recompensa->descripcion }}" url_item = "{{ asset($img[0]) }}" pts_item="{{ $recompensa->puntos }}">Lo quiero</button>
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
        //console.log($("#points").attr('data'));
        swalWithBootstrapButtons.fire({
          title: $(this).attr('name_item'),
          text: "Deseas agregar este producto?",
          imageUrl: $(this).attr('url_item'),
          imageWidth: 200,
          imageHeight: 200,
          imageAlt: $(this).attr('name_item'),
          showCancelButton: true,
          confirmButtonText: 'Agregar!',
          cancelButtonText: 'Cancelar!',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            var disponible = parseInt($('#points').attr('data'));
            var minus = parseInt($('#minus-points').attr('data'));
            var product_points = parseInt($(this).attr('pts_item'));
            var total_minus = minus + product_points;
            var total = disponible - total_minus;
            $("#minus-points").attr('data',total_minus);
            $("#minus-points").html('');
            $("#minus-points").html(total_minus+' pts');
            $("#total-points").attr('data',total);
            $("#total-points").html('');
            $("#total-points").html(total+' pts');
            var product_list = [];
            var new_list = [];
            var apuntador = 0;
            var product = new Object();
            if(Cookies.get('products') != undefined){
              var product_prev = JSON.parse(Cookies.get('products'));
              /*console.log('Obtengo las cookies:');
              console.log(product_prev);
              console.log('---- Empieza foreach ----');*/
              product_prev.forEach(producto => {
                if(parseInt($(this).attr('object_id')) == producto.id) {
                   
                  /*console.log('tengo el mismo ID asi que muestro el objeto:');
                  console.log(producto);*/
                  producto.qty = producto.qty + 1;
                  /*console.log('Muestro el objeto actualizado:');
                  console.log(producto);
                  console.log('Muestro el array de las cookies que traje:');
                  console.log(product_prev);*/
                  apuntador = 1;
                }
                else{
                  //console.log('En caso de que el producto no este previamente agregado se crea uno:');
                  product.id = parseInt($(this).attr('object_id'));
                  product.qty = 1;
                  //console.log(product);
                  new_list.push(product);
                  /*console.log('Se muestra el array que queda despues del producto nuevo:');
                  console.log(new_list);*/
                }
                
              });
              /*console.log('---- Termina Foreach ----');
              console.log('Muestro el array que previo de las Cookies');
              console.log(product_prev);
              console.log('Muestro el nuevo array en caso de que hubiera un nuevo producto');
              console.log(new_list);
              console.log('Apuntador: '+apuntador);*/
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
              console.log('Muestro el JSON que se convertira en la nueva cookie:');
              console.log(response);
              Cookies.set('products',response);
              console.log('Muestro la nueva cookie formada:');
              console.log(JSON.parse(Cookies.get('products')));
              
            }else{

              product.id = parseInt($(this).attr('object_id'));
              product.qty = 1;
              product_list.push(product);
              console.log('No se que estoy haciendo aqui')
               var response = JSON.stringify(product_list);
              console.log('Produto response: '+response);
              Cookies.set('products',response);
            }

           
            Cookies.set('minus-points', total_minus);
            Cookies.set('total-points', total);

            $("#items_check").val(response);
            
            swalWithBootstrapButtons.fire(
              'Exito!',
              $(this).attr('name_item')+' se agregó sin problemas.',
              'success'
            )
          } 
        })

      });

    });
    
  </script>
@endsection
