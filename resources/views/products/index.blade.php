@extends('layout.master')

@section('content')
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<div id="carouselExampleIndicators" class="carousel slide col-md-12 mb-2" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="/Images/pcFixe.jpg" alt="First slide" style="height:520px;width:100%">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="/Images/pcPortable.jpg" alt="Second slide" style="height:520px;width:100%">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="/Images/PHOTO-PROMO.jpg" alt="Third slide" style="height:520px;width:100%">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

  @foreach ($products as $product)
    <div class="col-md-6">
      <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-success">
            @foreach ($product->categories as $category)
                {{ $category->name }}
            @endforeach
          </strong>
          <h5 class="mb-0">{{$product->title}}</h5>
          <p class="mb-auto">{{$product->subtitle}}</p>
          <strong class="mb-auto font-weight-normal text-secondary">{{$product->getPrice()}}</strong>
          <a href="{{ route('products.show', $product->slug)}} " class="btn btn-info btn-block">Afficher produit </a>
        </div>
        <div class="col-auto d-none d-lg-block">
          <img src="{{ asset('storage/' . $product->image) }}" class="">
        </div>
      </div>
    </div>
  @endforeach
  {{ $products->appends(request()->input())->links()}}
@endsection