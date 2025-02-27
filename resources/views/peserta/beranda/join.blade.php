@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <x-banner title="Join Arisan" description="Silakan memilih produk yang ingin anda bayar."></x-banner>

    <div class="row">
        <div class="col-8">
            <div class="accordion" id="accordionExample">
                @foreach ($categories as $category)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $category->id }}" aria-expanded="false" aria-controls="{{ $category->id }}">
                        {{ $category->nama }}
                      </button>
                    </h2>
                    <div id="{{ $category->id }}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                      <div class="accordion-body row gap-1">
                        @foreach ($category->produks as $produk)
                        <div class="card col-4">
                            <div class="card-body">
                                <img src="https://picsum.photos/seed/picsum/200" alt="">
                                <h4>{{ $produk->nama }}</h4>
                            </div>
                        </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection