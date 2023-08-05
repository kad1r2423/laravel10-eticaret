@extends('frontend.layout.layout')
@section('content')
<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Shop</strong></div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">

        <div class="row mb-5">
            <div class="col-md-9 order-2">

                <div class="row">
                    <div class="col-md-12 mb-5">
                        <div class="float-md-left mb-4"><h2 class="text-black h5">Ürünler</h2></div>
                        <div class="d-flex">
                            <div class="dropdown mr-1 ml-md-auto">
                            </div>
                            <div class="btn-group">

                               <!-- Select sıralama seçenekleri -->
<select class="form-control" id="orderList">
    <option value="">Sıralama Seçiniz</option>
    <option value="id,asc" {{ request()->orderBy == 'id-asc' ? 'selected' : '' }}>A-Z'ye sırala</option>
    <option value="id,desc" {{ request()->orderBy == 'id-desc' ? 'selected' : '' }}>Z-A'ya sırala</option>
    <option value="price,asc" {{ request()->orderBy == 'price-asc' ? 'selected' : '' }}>Düşük Fiyata Göre Sırala</option>
    <option value="price,desc" {{ request()->orderBy == 'price-desc' ? 'selected' : '' }}>Yüksek Fiyata Göre Sırala</option>
</select>
<!-- Select sıralama seçenekleri -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                @if (session()->get('success'))
                <div class="alert alert-success">{{session()->get('success')}}</div>
                @endif
                </div>
                </div>
                <div class="row mb-5 productContent">

            @include('frontend.ajax.productList')

                </div>
                <div class="rowpaginateButtons" data-aos="fade-up">
                    {{$products->withQueryString()->links('vendor.pagination.custom')}}
                </div>
            </div>

            <div class="col-md-3 order-1 mb-5 mb-md-0">
                <div class="border p-4 rounded mb-4">
                    <h3 class="mb-3 h6 text-uppercase text-black d-block">Kategori</h3>
                    <ul class="list-unstyled mb-0">
                        @if (!empty($categories) && $categories->count() > 0)
                            @foreach ($categories->where('cat_ust',null) as $category)
                                <li class="mb-1"><a href="{{route($category->slug.'urunler')}}" class="d-flex"><span>{{$category->name}}</span> <span class="text-black ml-auto">({{$category->items_count}})</span></a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div class="border p-4 rounded mb-4">
                    <div class="mb-4">
                        <h3 class="mb-3 h6 text-uppercase text-black d-block">Fiyata Göre Sırala</h3>
                        <div id="slider-range" class="border-primary"></div>
                        <input type="text" name="text" id="amount" class="form-control border-0 pl-0 bg-white" disabled="" />



                        <input type="text" name="text" id="priceBetween" class="form-control" hidden/>


                        <input type="hidden" id="minPrice" value="{{ request()->min ?? 0 }}">
                        <input type="hidden" id="maxPrice" value="{{ request()->max ?? $maxprice }}">
                    </div>

                    <div class="mb-4">
                        <h3 class="mb-3 h6 text-uppercase text-black d-block">Boyut</h3>
                        @if (!empty($sizelists))
                            @foreach ($sizelists as $key => $size)
                                <label for="size{{$key}}" class="d-flex">
                                    <input type="checkbox" id="size{{$key}}" value="{{$size}}" {{isset(request()->size) && in_array($size,explode(',',request()->size)) ? 'checked' : '' }} class="mr-2 mt-1 sizeList">
                                    <span class="text-black">{{$size}}</span>
                                </label>
                            @endforeach
                        @endif
                    </div>
                    <div class="mb-4">
                        <h3 class="mb-3 h6 text-uppercase text-black d-block">Renk</h3>
                        @if (!empty($colors))
                            @foreach ($colors as $key => $color)
                                <label for="color{{$key}}" class="d-flex">
                                    <input type="checkbox" id="color{{$key}}" value="{{$color}}" {{isset(request()->color) && in_array($color,explode(',',request()->color)) ? 'checked' : '' }} class="mr-2 mt-1 colorList">
                                    <span class="text-black">{{$color}}</span>
                                </label>
                            @endforeach
                        @endif
                    </div>

                        <div class="mb-4">
                            <button class="btn btn-block btn-primary filterBtn">Filtrele</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="site-section site-blocks-2">
                    <div class="row justify-content-center text-center mb-5">
                        <div class="col-md-7 site-section-heading pt-4">
                            <h2>Kategoriler</h2>
                        </div>
                    </div>
                    <div class="row">
                        @if (!empty($categories))
                            @foreach ($categories->where('cat_ust',null) as $category)
                                <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                                    <a class="block-2-item" href="{{route($category->slug.'urunler')}}">
                                        <figure class="image">
                                            <img src={{asset($category->image)}} alt="" class="img-fluid">
                                        </figure>
                                        <div class="text">
                                            <span class="text-uppercase">Collections</span>
                                            <h3>{{$category->name}}</h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customjs')

<script>
    var maxprice = {{$maxprice}};
    var defaultminprice = {{request()->min ?? 0}};
    var defaultmaxprice = {{request()->max ?? $maxprice}};

    $(document).ready(function() {
        function filtrele() {
            // Seçili olan renk ve boyutları alın
            var colorList = $(".colorList:checked").map((_, chk) => chk.value).get();
            var sizeList = $(".sizeList:checked").map((_, chk) => chk.value).get();

            // URL'yi alın
            var url = new URL(window.location.href);

            // Fiyat aralığı parametrelerini alın
            var minPrice = parseInt($('#minPrice').val());
            var maxPrice = parseInt($('#maxPrice').val());

            // Geçerli fiyat aralığı değerleri ise URL'ye ekleyin
            if (minPrice >= 0 && minPrice < maxprice) {
                url.searchParams.set("min", minPrice);
            }

            if (maxPrice > minPrice && maxPrice <= maxprice) {
                url.searchParams.set("max", maxPrice);
            } else {
                url.searchParams.delete("max");
            }

            // Renk ve boyut parametrelerini sıfırlayın
            url.searchParams.delete('color');
            url.searchParams.delete('size');

            // Seçili renkleri URL'ye ekleyin
            if (colorList.length > 0) {
                url.searchParams.set("color", colorList.join(","));
            }

            // Seçili boyutları URL'ye ekleyin
            if (sizeList.length > 0) {
                url.searchParams.set("size", sizeList.join(","));
            }

            // Sıralama parametresini alın
            var order = $('#orderList').val();
            if (order !== "") {
                var orderby = order.split(',');
                url.searchParams.set("order", orderby[0]);
                url.searchParams.set("sort", orderby[1]);
            } else {
                url.searchParams.delete("order");
                url.searchParams.delete("sort");
            }

            // Yeni URL'yi kullanarak sayfayı yeniden yükleyin
            window.history.pushState({}, '', url.href);

            // AJAX isteği yap
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: url.href,
                success: function(response) {


                    $('.productContent').html(response.data);
                    $('.paginateButtons').html(response.paginate);
                }
            });
        }

        // Filtre butonuna tıkladığınızda
        $('.filterBtn').on('click', function(e) {
            e.preventDefault();
            filtrele();
        });

        // Sıralama seçeneği değiştirildiğinde
        $(document).on('change', '#orderList', function(e) {
            filtrele();
        });
    });
</script>

@endsection
