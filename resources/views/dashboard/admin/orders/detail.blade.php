@extends('dashboard.main')
@section('dashboard')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-12 align-self-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb align-items-center">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none">
                                <i class="ti ti-home fs-5"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Penjualan</li>
                    </ol>
                </nav>
                <h2 class="mb-0 fw-bolder fs-8">Penjualan</h2>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('sale.store.detail') }}" method="POST">
                            @csrf
                            @method('POST')
                            @if (Session::get('error'))
                                <div class="alert alert-danger">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <table style="width: 100%;">
                                        <thead>
                                            <h2>Produk yang dipilih</h2>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total = [];
                                            @endphp
                                            @foreach ($shop as $item)
                                                <input type="hidden" name="shop[]" value="{{ $item }}" hidden>
                                                <tr>
                                                    <td>{{ explode(';', $item)[1] }} <br> <small>Rp.
                                                            {{ number_format(explode(';', $item)[2], '0', ',', '.') }} X
                                                            {{ explode(';', $item)[3] }}</small></td>
                                                    <td><b>Rp.
                                                            {{ number_format(explode(';', $item)[4], '0', ',', '.') }}</b>
                                                    </td>
                                                </tr>
                                                @php
                                                    array_push($total, explode(';', $item)[4]);
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td style="padding-top: 20px; font-size: 20px;"><b>Total</b></td>
                                                <td class="tex-end" style="padding-top: 20px; font-size: 20px;"><b>Rp.
                                                        {{ number_format(array_sum($total), '0', ',', '.') }}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <input type="text" name="total" id="total" value="{{ array_sum($total) }}"
                                        hidden>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="member" class="form-label">Member Status</label>
                                            <small class="text-danger">Dapat juga membuat member</small>
                                            <select name="member" id="member" class="form-select"
                                                onchange="memberDetect()">
                                                <option value="Bukan Member">Bukan Member</option>
                                                <option value="Member">
                                                    Member</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="member-wrap" class="d-none">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-12">No Telepon <small
                                                            class="text-danger">(daftar/gunakan member)</small></label>
                                                    <div class="col-md-12">
                                                        <input type="number" name="no_hp"
                                                            class="form-control form-control-line @error('no_hp') is-invalid @enderror"
                                                            onKeyPress="if(this.value.length==13) return false;">
                                                        @error('no_hp')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_pay" class="form-label">Total Bayar</label>
                                            <input type="text" name="total_pay" id="total_pay" class="form-control"
                                                oninput="formatRupiah(this); checkTotalPay()">
                                            <small id="error-message" class="text-danger d-none">Jumlah bayar
                                                kurang.</small>
                                        </div>
                                    </div>
                                    <div class="row text-end">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" id="submit-button" type="submit">Pesan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function memberDetect() {
            // Ambil elemen dropdown dan elemen member-wrap
            const memberSelect = document.getElementById('member');
            const memberWrap = document.getElementById('member-wrap');
            const noHpInput = document.getElementById('no_hp');

            // Cek nilai yang dipilih
            if (memberSelect.value === 'Member') {
                memberWrap.classList.remove('d-none'); // Tampilkan member-wrap
                noHpInput.setAttribute('required', 'required');
            } else {
                memberWrap.classList.add('d-none'); // Sembunyikan member-wrap
                noHpInput.removeAttribute('required');
            }
        }
    </script>
    <script>
        function formatRupiah(input) {
            // Menghapus karakter yang bukan angka
            let value = input.value.replace(/[^0-9]/g, '');

            // Memformat angka menjadi format Rupiah
            let formattedValue = '';
            if (value) {
                formattedValue = 'Rp. ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            // Mengupdate nilai input
            input.value = formattedValue;
        }

        function checkTotalPay() {
            const totalPayInput = document.getElementById('total_pay');
            const totalInput = document.getElementById('total');
            const submitButton = document.getElementById('submit-button');
            const errorMessage = document.getElementById('error-message');

            // Mengambil nilai numerik dari total_pay
            const totalPayValue = parseInt(totalPayInput.value.replace(/[^0-9]/g, ''), 10) || 0;
            // Mengambil nilai total dari input hidden
            const totalValue = parseInt(totalInput.value, 10);

            // Memeriksa apakah totalPayValue kurang dari totalValue
            if (totalPayValue < totalValue) {
                submitButton.disabled = true; // Nonaktifkan tombol submit
                errorMessage.classList.remove('d-none'); // Tampilkan pesan kesalahan
            } else {
                submitButton.disabled = false; // Aktifkan tombol submit
                errorMessage.classList.add('d-none'); // Sembunyikan pesan kesalahan
            }
        }
    </script>
@endpush
