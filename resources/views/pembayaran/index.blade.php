@extends('layouts.app')

@push('css')
<!-- --------------------------------------------------- -->
<!-- Select2 -->
<!-- --------------------------------------------------- -->
<link rel="stylesheet" href="{{ asset('assets') }}/libs/select2/dist/css/select2.min.css">
<!-- --------------------------------------------------- -->
@endpush

@section('content')
<div class="container-fluid">
    <x-banner title="Pembayaran" description="Daftar Pembayaran Peserta Arisan."></x-banner>

    <div class="card mt-3">
        <div class="card-body row">
            <div class="col-md-12">
                <label for="exampleFormControlSelect1" class="mb-2">Pilih Peserta</label>
                <select class="form-control select2" id="peserta">
                    @foreach ($users as $user)
                        <option value="{{ json_encode($user) }}">{{ $user->user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mt-3">
                <table>
                    <tr>
                        <th>Alamat</th>
                        <td width="20%" class="text-center">:</td>
                        <td id="address">Malang</td>
                    </tr>
                    <tr>
                        <th>Nomor WA</th>
                        <td width="20%" class="text-center">:</td>
                        <td id="no_wa">083848020120</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td width="20%" class="text-center">:</td>
                        <td id="status">Individu</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6 mt-3">
                <table>
                    <tr>
                        <th>Bayar Berapa X</th>
                        <td width="20%" class="text-center">:</td>
                        <td id="jumlah_bayar">45x</td>
                    </tr>
                    <tr>
                        <th>Bayar Dapat</th>
                        <td width="20%" class="text-center">:</td>
                        <td id="jumlah_bayar_dapat">20x</td>
                    </tr>
                    <tr>
                        <th>Bayar per Minggu</th>
                        <td width="20%" class="text-center">:</td>
                        <td id="per_minggu">Rp.20.000</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="col-md-12 table-responsive">
                <table class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Pembayaran-Ke</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pembayaran-table">
                        
                       <tr>
                        <td class="text-center" colspan="5">-- Tidak ada data --</td>
                       </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>        


<!-- modal bayar  -->
<div
class="modal fade"
id="modal-bayar"
tabindex="-1"
aria-labelledby="mySmallModalLabel"
aria-hidden="true"
>
<div class="modal-dialog modal-sm">
<form action="" id="form-pembayaran">
  <div class="modal-content">
    <div
      class="modal-header d-flex align-items-center"
    >
      <h4 class="modal-title" id="myModalLabel">
        Pembayaran
      </h4>
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="modal"
        aria-label="Close"
      ></button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label class="mr-sm-2 mb-2" for="inlineFormCustomSelect">Metode Pembayaran</label>
            <select class="form-select mr-sm-2" id="metode-pembayaran">
              <option value="Cash">Cash</option>
              <option value="Transfer">Transfer</option>
              <option value="E-Wallet">E-Wallet</option>
              <option value="QRIS">QRIS</option>
            </select>
          </div>
    </div>
    <div class="modal-footer">
      <button
        type="button"
        class="btn btn-light-danger text-danger font-medium waves-effect"
        data-bs-dismiss="modal"
      >
        Tutup
      </button>
      <button
        type="submit"
        class="btn btn-primary font-medium waves-effect"
      >
        Submit
      </button>
    </div>
</form>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- end modal bayar  -->
@endsection

@push('js')
<script src="{{ asset('assets') }}/libs/select2/dist/js/select2.full.min.js"></script>
<script src="{{ asset('assets') }}/libs/select2/dist/js/select2.min.js"></script>

<script src="{{ asset('assets') }}/js/currency.js"></script>
<script src="{{ asset('assets') }}/js/date-helper.js"></script>

<script>
    $(document).ready(function() {

        let currentKe = 0;
        let currentUser = null;

        // For select 2
        //***********************************//
        $(".select2").select2({
            width: '100%'
        });

        init();

        $("#peserta").on('change', function() {
            init();
        });

        function init() {
            let tbody = '';
            const user = JSON.parse($("#peserta").val());
            console.log(user)

            $.ajax({
                url: "{{ '/admin/pembayaran?userId=:id' }}".replace(':id', user.id),
                method: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    userId: user.id
                },
                success: function(data) {
                    for (let i = 0; i < user.jumlah_bayar; i++) {
                        const is_paid = data.paid.includes(i + 1);
                        tbody += `<tr>
                                    <td>${is_paid ? `<s>minggu-${i + 1}</s>` : `minggu-${i + 1}`}</td>
                                    <td>${is_paid ? formatDate(data.pembayaran[i].created_at) : '-'}</td>
                                    <td>${is_paid ? formatCurrency(data.pembayaran[i].jumlah) : 'Rp. 0'}</td>
                                    <td>${is_paid ? data.pembayaran[i].metode : '-'}</td>
                                    <td>
                                        ${!is_paid ? `<a href="#" class="btn btn-sm btn-primary btn-bayar" data-ke='${i + 1}' data-user='${JSON.stringify(user)}'>Bayar</a>` : '-'}
                                    </td>
                                </tr>`;
                        
                    }

                    $('#pembayaran-table').html(tbody);

                    // set informasi user 
                    $('#address').html(user.user.address);
                    $('#status').html(user.status);
                    $('#no_wa').html(user.user.phone_number);
                    $('#jumlah_bayar').html(user.jumlah_bayar + "x");
                    $('#jumlah_bayar_dapat').html(data.paid.length + "x");
                    $('#per_minggu').html(formatCurrency(user.per_minggu));
                },
                error: function(data) {
                    showToast('Gagal mendapatkan data!', 'error');
                }
            });
        }

        $(document).on('click', '.btn-bayar', function(e) {
            e.preventDefault();
            const user = $(this).data('user')
            const ke = $(this).data('ke')
            currentKe = ke
            currentUser = user
            $('#modal-bayar').modal('show');
            $('#modal-bayar').find('form').attr('data-user', JSON.stringify(user)).attr('data-ke', ke)
        });

        $(document).on('submit', '#form-pembayaran', function(e) {
            e.preventDefault();
            // const user = $(this).data('user')
            // const ke = $(this).data('ke')
            const metodePembayaran = $('#metode-pembayaran').val();

            $.ajax({
                method: 'POST',
                url: '{{ route('pembayaran.bayar') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    arisan_user_id: currentUser.id,
                    pembayaran_ke: currentKe,
                    jumlah: currentUser.per_minggu,
                    metode: metodePembayaran
                },
                success: function(data) {
                    console.log(data)
                    if (data.success) {
                        showToast(data.message, 'success');
                    } else {
                        showToast(data.message, 'error');
                    }

                    init()
                }, 
                error: function(data) {
                    showToast(data.message, 'error');
                },
            }).always(function() {
                $('#modal-bayar').modal('hide');
            })
        });
    });
</script>
@endpush