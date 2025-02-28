@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <x-banner title="Join Arisan" description="Silakan memilih produk yang ingin anda bayar."></x-banner>

    <div class="row">
        <div class="col-md-8">
            <div class="accordion" id="accordionExample">
                @foreach ($categories as $category)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $category->id }}" aria-expanded="false" aria-controls="{{ $category->id }}">
                        {{ $category->nama }}
                      </button>
                    </h2>
                    <div id="{{ $category->id }}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                      <div class="accordion-body row row-cols-4 gap-2">
                        @foreach ($category->produks as $produk)
                        <div class="col border border-dark-subtle rounded p-2 text-center item" data-produk="{{ $produk }}">
                          <img class="rounded img-fluid" src="https://picsum.photos/seed/picsum/400" alt="">
                          <h5>{{ $produk->nama }}</h5>
                          <h6>{{ \App\Helpers\CurrencyFormat::formatRupiah($produk->harga_jual) }}</h6>
                      </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-4">
          <div class="table-responsive rounded-2 mb-4">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
              <thead class="text-dark fs-4">
                <tr>
                  <th><h6 class="fs-4 fw-semibold mb-0">Produk</h6></th>
                  <th><h6 class="fs-4 fw-semibold mb-0">Qty</h6></th>
                  <th><h6 class="fs-4 fw-semibold mb-0">Total</h6></th>
                  <th><h6 class="fs-4 fw-semibold mb-0">#</h6></th>
                </tr>
              </thead>
              <tbody id="orders-table">
                
                <tr id="empty-order">
                  <td colspan="4">Belum ada produk.</td>
                </tr>
                <tr>
                  <td colspan="2" class="text-bold"><strong>Total</strong></td>
                  <td colspan="2"><strong class="text-primary" id="totalPrice"></strong></td>
                </tr>
              </tbody>
            </table>
            <div class="d-grid gap-2 mt-3">
              <button class="btn btn-primary" type="button">Join</button>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets') }}/js/currency.js"></script>
<script>
  $(document).ready(function () {
    let items = [];
    let orders = '';
    let totalPrice = 0;

    function setTotalPrice() {
      $('#totalPrice').html(formatCurrency(totalPrice))
    }

    $(document).on('click', '.item', function () {
      var produk = $(this).data('produk');

      // kosongkan table 
      $('#empty-order').hide();

      // find item 
      let item = findItem(produk.id);
      // add qty to item
      if (item) {
        item.qty++;
        item.total = item.qty * produk.harga_jual;

        let qtyHtml = $(document).find('#row-' + item.id).find('td:nth-child(2)');
        qtyHtml.html(item.qty);
        let totalHtml = $(document).find('#row-' + item.id).find('td:nth-child(3)');
        totalHtml.html(formatCurrency(item.total));
      } else {
        item = {
          id: produk.id,
          produk: produk,
          qty: 1,
          total: produk.harga_jual,
        };
        items.push(item);

        order = `<tr id="row-${item.id}">
                  <td>
                    <div>
                      <p class="mb-1 fw-bold"><strong>${item.produk.nama}</strong></p>
                      <p class="text-secondary">${formatCurrency(item.produk.harga_jual)}</p>
                    </div>
                  </td>
                  <td>
                  ${item.qty}
                  </td>
                  <td>
                  ${formatCurrency(item.total)}
                  </td>
                  <td class="remove-item" data-id="${item.id}">
                      <i class="fas fa-trash-alt text-danger"></i>
                    </td>
                </tr>`;
      
        $('#orders-table').prepend(order);
      }

      // menambahkan total price 
      totalPrice += item.produk.harga_jual;
      setTotalPrice()
    });

    $(document).on('click', '.remove-item', function() {
      const itemId = $(this).data('id');
      
      totalPrice -= items.find(item => item.id == itemId).total;
      setTotalPrice()

      $(document).find('#row-' + itemId).remove();
      items = items.filter(item => item.id !== itemId);
      
      if (items.length === 0) {
        $('#empty-order').show();
      }
    });

    function findItem(id) {
      return items.find(function (item) {
        return id === item.id;
      });
    }
  });
</script>
@endpush