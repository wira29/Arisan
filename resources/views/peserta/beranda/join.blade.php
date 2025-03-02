@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <x-banner title="Join Arisan" description="Silakan memilih produk yang ingin anda bayar."></x-banner>

    <div class="row">
        <div class="col-md-7 mb-3">
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
        <div class="col-md-5">
          <div class="table-responsive rounded-2 mb-4">
            <div>
              <h6>Pembayaran</h6>
            </div>
            <div class="mb-3">
                <input type="radio" class="btn-check" name="jumlahBayar" value="40" id="option1" autocomplete="off" checked="">
                <label class="btn btn-outline-primary rounded-pill font-medium me-2 mb-2" for="option1">40x</label>

                <input type="radio" class="btn-check" name="jumlahBayar" value="50" id="option2" autocomplete="off">
                <label class="btn btn-outline-primary rounded-pill font-medium me-2 mb-2" for="option2">50x</label>
            </div>
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
                <tr>
                  <td colspan="2" class="text-bold"><strong>Pembayaran/minggu</strong></td>
                  <td colspan="2"><strong class="text-primary" id="perMinggu"></strong></td>
                </tr>
              </tbody>
            </table>
            <div class="d-grid gap-2 mt-3">
              <button class="btn btn-primary" id="btn-join" type="button">Join</button>
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
    let jumlahBayar = 40;
    let perMinggu = 0;

    // join arisan 
    $('#btn-join').on('click', function() {
      $('#btn-join').prop('disabled', true);
      Swal.fire({
          title: "Apakah kamu yakin?",
          text: "Tindakan ini tidak dapat dibatalkan!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Ya, lanjutkan!",
          cancelButtonText: "Tidak, batal!",
          reverseButtons: true
      }).then((result) => {
          if (result.isConfirmed) {
              joinArisan();
          } else {
              Swal.fire("Dibatalkan", "Tindakan telah dibatalkan.", "error");
              $('#btn-join').prop('disabled', false);
          }
      });
    });

    function joinArisan() {
      $.ajax({
        url: '{{ route('joinAction') }}',
        method: 'POST',
        data: {
          produks: items,
          jumlahBayar: jumlahBayar == 40 ? 0 : 1,
          perMinggu: perMinggu,
          totalBayar: totalPrice,
          _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        success: function(data) {
          showToast("Berhasil bergabung arisan!", 'success');
          window.location.href = "/beranda";
        },
        error: function(data) {
          showToast("Gagal bergabung arisan!", 'error');
          window.location.href = "/beranda";
        }
      });
    }

    function setTotalPrice() {
      $('#totalPrice').html(formatCurrency(totalPrice))
    }

    function setPerMinggu() {
      perMinggu = Math.ceil(totalPrice / jumlahBayar);
      $('#perMinggu').html(formatCurrency(perMinggu))
    }

    $('input[name="jumlahBayar"]').on('change', function() {
      jumlahBayar = parseInt($(this).val());
      setPerMinggu();
    });

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

        let qtyHtml = $(document).find('#row-' + item.id).find('td:nth-child(2)').find('strong');
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
                  <td >
                    <i class="fas fa-minus minus-item text-danger" data-id="${item.id}"></i>
                    <strong class="mx-2">${item.qty}</strong>
                    <i class="fas fa-plus add-item text-success" data-id="${item.id}"></i>
                  </td>
                  <td>
                  ${formatCurrency(item.total)}
                  </td>
                  <td class="">
                      
                      <i class="fas fa-trash-alt text-danger remove-item" data-id="${item.id}"></i>
                    </td>
                </tr>`;
      
        $('#orders-table').prepend(order);
      }

      // menambahkan total price 
      totalPrice += item.produk.harga_jual;
      setTotalPrice()
      setPerMinggu()
    });

    $(document).on('click', '.add-item', function() {
      const itemId = $(this).data('id');
      const qty = parseInt($(this).siblings('strong').text()) + 1;
      let item = items.find(item => item.id == itemId);
      item.qty = qty;
      item.total = qty * item.produk.harga_jual;

      // rubah Qty tampilan
      $(this).siblings('strong').text(qty);

      // menambahkan price 
      $(this).parent().parent().find('td:nth-child(3)').html(formatCurrency(item.total));
      
      // menambahkan total price 
      totalPrice += item.produk.harga_jual;
      setTotalPrice()
      setPerMinggu()
    });

    $(document).on('click', '.minus-item', function() {
      const itemId = $(this).data('id');
      const qty = parseInt($(this).siblings('strong').text()) - 1;
      let item = items.find(item => item.id == itemId);
      
      if (qty <= 0) {
        removeItem(itemId);
        return;
      }

      item.qty = qty;
      item.total = qty * item.produk.harga_jual;

      // rubah Qty tampilan
      $(this).siblings('strong').text(qty);

      // mengurangi price 
      $(this).parent().parent().find('td:nth-child(3)').html(formatCurrency(item.total));
      
      // menambahkan total price 
      totalPrice -= item.produk.harga_jual;
      setTotalPrice()
      setPerMinggu()
    });
      

    $(document).on('click', '.remove-item', function() {
      const itemId = $(this).data('id');
      
      removeItem(itemId);
    });

    function removeItem(itemId) {
      totalPrice -= items.find(item => item.id == itemId).total;
      setTotalPrice()
      setPerMinggu()

      $(document).find('#row-' + itemId).remove();
      items = items.filter(item => item.id !== itemId);
      
      if (items.length === 0) {
        $('#empty-order').show();
      }
    }

    function findItem(id) {
      return items.find(function (item) {
        return id === item.id;
      });
    }
  });
</script>
@endpush