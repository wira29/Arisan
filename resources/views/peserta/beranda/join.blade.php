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
                          <img class="rounded img-fluid" src="{{ asset('storage/' . $produk->gambar) }}" alt="">
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
              <h6>Status</h6>
            </div>
            <div class="mb-3">
                <input type="radio" class="btn-check" name="status" value="individu" id="option1" autocomplete="off" checked="">
                <label class="btn btn-outline-primary rounded-pill font-medium me-2 mb-2" for="option1">Individu</label>

                <input type="radio" class="btn-check" name="status" value="group" id="option2" autocomplete="off">
                <label class="btn btn-outline-primary rounded-pill font-medium me-2 mb-2" for="option2">Grup</label>
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
                  <td colspan="2" class="text-bold"><strong>Jumlah bayar</strong></td>
                  <td colspan="2"><strong class="text-primary" id="jumlahBayar"></strong></td>
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
    let jumlahBayar = 45;
    let perMinggu = 0;
    let status = 'individu';

    // init 
    setJumlahBayar();

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
          jumlahBayar: jumlahBayar,
          status: status,
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
      let total = 0;
      items.forEach(function(item) {
        total += item.total;
      });
      $('#totalPrice').html(formatCurrency(total))
    }

    function setPerMinggu() {
      perMinggu = Math.ceil(totalPrice / jumlahBayar);
      $('#perMinggu').html(formatCurrency(perMinggu))
    }

    function setJumlahBayar() {
      $('#jumlahBayar').html(jumlahBayar + "x")
    }

    $('input[name="status"]').on('change', function() {
      status = $(this).val();
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

        let qtyHtml = $(document).find('#row-' + item.id).find('td:nth-child(2)').find('input');
        qtyHtml.val(item.qty);
        let totalHtml = $(document).find('#row-' + item.id).find('td:nth-child(3)');
        totalHtml.html(formatCurrency(item.total));
      } else {

        if (produk.is_meubel == 1) {
          jumlahBayar = 50;
          setJumlahBayar();
       }
        item = {
          id: produk.id,
          produk: produk,
          qty: 1,
          total: produk.harga_jual,
          is_meubel: produk.is_meubel,
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
                    <div class="d-flex align-items-center">
                      <i class="fas fa-minus minus-item text-danger" data-id="${item.id}"></i>
                      <input name="qty-item" type="text" class="mx-2 form-control" style="width: 100px" value="${item.qty}" data-id="${item.id}" />
                      <i class="fas fa-plus add-item text-success" data-id="${item.id}"></i>
                    </div>
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
      // totalPrice += item.produk.harga_jual;
      setTotalPrice()
      setPerMinggu()
    });

    $(document).on('click', '.add-item', function() {
      const itemId = $(this).data('id');
      const qty = parseInt($(this).siblings('input').val()) + 1;
      let item = items.find(item => item.id == itemId);
      item.qty = qty;
      item.total = qty * item.produk.harga_jual;

      // rubah Qty tampilan
      $(this).siblings('input').val(qty);

      // menambahkan price 
      $(this).parent().parent().parent().find('td:nth-child(3)').html(formatCurrency(item.total));
      
      // menambahkan total price 
      // totalPrice += item.produk.harga_jual;
      setTotalPrice()
      setPerMinggu()
    });

    $(document).on('change', 'input[name="qty-item"]', function() {
      const itemId = $(this).data('id');
      let qty = parseInt($(this).val());

      if (qty < 1) {
        $(this).val(1);
        qty = 1;
        // return;
      }

      let item = items.find(item => item.id == itemId);
      item.qty = qty;
      item.total = qty * item.produk.harga_jual;

      // rubah Qty tampilan
      $(this).val(qty);

      // mengurangi price 
      $(this).parent().parent().parent().find('td:nth-child(3)').html(formatCurrency(item.total));
      
      // menambahkan total price 
      // totalPrice += item.produk.harga_jual;
      setTotalPrice()
      setPerMinggu()
    });

    $(document).on('click', '.minus-item', function() {
      const itemId = $(this).data('id');
      const qty = parseInt($(this).siblings('input').val()) - 1;
      let item = items.find(item => item.id == itemId);
      
      if (qty <= 0) {
        removeItem(itemId);
        return;
      }

      item.qty = qty;
      item.total = qty * item.produk.harga_jual;

      // rubah Qty tampilan
      $(this).siblings('input').val(qty);

      // mengurangi price 
      $(this).parent().parent().parent().find('td:nth-child(3)').html(formatCurrency(item.total));
      
      // menambahkan total price 
      // totalPrice -= item.produk.harga_jual;
      setTotalPrice()
      setPerMinggu()
    });
      

    $(document).on('click', '.remove-item', function() {
      const itemId = $(this).data('id');
      
      removeItem(itemId);
    });

    function removeItem(itemId) {

      // set jumlah bayar 
      const item = items.find(item => item.id == itemId);
      if (item.is_meubel == 1) {
        jumlahBayar = 45;
        setJumlahBayar();
      }

      
      $(document).find('#row-' + itemId).remove();
      items = items.filter(item => item.id !== itemId);
      
      // totalPrice -= items.find(item => item.id == itemId).total;
      setTotalPrice()
      setPerMinggu()
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