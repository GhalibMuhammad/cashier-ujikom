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
                    <div class="row justify-content-end mb-3">
                        <div class="col text-start">
                            <div class="row">
                                @if (Auth::user()->role == 'cashier')
                                    <div class="col-6">
                                        <a href="{{ route('sale.export') }}" class="btn btn-info">
                                            Export Penjualan (.xlsx)
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if (Auth::user()->role == 'cashier')
                            <div class="col text-end">
                                <a href="{{ route('sale.create') }}" class="btn btn-primary">
                                    Tambah Penjualan
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table id="salesTable" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Tanggal Penjualan</th>
                                    <th>Total Harga</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($sales as $sale)
                                    <tr>
                                        <th>{{ $i++ }}</th>
                                        <td>{{ $sale->customer ? $sale->customer->name : 'NON-MEMBER' }}</td>
                                        <td>{{ $sale->sale_date }}</td>
                                        <td>{{ 'Rp. ' . number_format($sale->total_price, 0, ',', '.') }}</td>
                                        <td>{{ $sale->user->name }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <!-- Lihat Detail -->
                                                <button class="btn btn-warning btn-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#lihat-{{ $sale->id }}">
                                                    <i class="ti ti-eye fs-5 me-1"></i> Lihat
                                                </button>
                                                <!-- Unduh Bukti -->
                                                <a href="{{ route('sale.print', $sale->id) }}" class="btn btn-info btn-sm d-flex align-items-center">
                                                    <i class="ti ti-download fs-5 me-1"></i> Bukti
                                                </a>
                                            </div>
                                        </td>

                                    </tr>

                                    <!-- Modal Lihat Detail Penjualan -->
                                    <div class="modal fade" id="lihat-{{ $sale->id }}" tabindex="-1" aria-labelledby="modalLihat" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLihat">Detail Penjualan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <small>
                                                                Member Status: {{ $sale->customer ? 'Member' : 'Bukan Member' }}<br>
                                                                No. HP: {{ $sale->customer ? $sale->customer->no_hp : '-' }}<br>
                                                                Poin Member: {{ $sale->customer ? $sale->customer->poin : '-' }}
                                                            </small>
                                                        </div>
                                                        <div class="col-6">
                                                            <small>
                                                                Bergabung Sejak:
                                                                {{ $sale->customer ? \Carbon\Carbon::parse($sale->customer->created_at)->format('d F Y') : '-' }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3 text-center mt-5">
                                                        <div class="col-3"><b>Nama Produk</b></div>
                                                        <div class="col-3"><b>Qty</b></div>
                                                        <div class="col-3"><b>Harga</b></div>
                                                        <div class="col-3"><b>Sub Total</b></div>
                                                    </div>
                                                    @foreach ($sale->detailSale as $item)
                                                        <div class="row mb-1">
                                                            <div class="col-3 text-center">{{ $item->product->name }}</div>
                                                            <div class="col-3 text-center">{{ $item->amount }}</div>
                                                            <div class="col-3 text-center">Rp. {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                                            <div class="col-3 text-center">Rp. {{ number_format($item->sub_total, 0, ',', '.') }}</div>
                                                        </div>
                                                    @endforeach
                                                    <div class="row text-center mt-3">
                                                        <div class="col-9 text-end"><b>Total</b></div>
                                                        <div class="col-3"><b>Rp. {{ number_format($sale->total_price, 0, ',', '.') }}</b></div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <center>
                                                            Dibuat pada: {{ $sale->created_at }}<br>
                                                            Oleh: {{ $sale->user->name }}
                                                        </center>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
