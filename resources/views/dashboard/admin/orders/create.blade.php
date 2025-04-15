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
                        <section>
                            <div class="text-center container">
                                <div class="row" id="product-list">
                                    {{-- @foreach ($products as $item)
                                    <p hidden id="id-product">{{ $item->id }}</p>
                                    <div class="col-lg-3 col-md-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title mb-3">{{ $item->name }}</h5>
                                                <p>Stok {{ $item->stock }}</p>
                                                <h6 class="mb-3">Rp. {{ number_format($item->price,'0', ',', '.') }}</h6>
                                                <p id="price_{{ $item->id }}" hidden>{{ $item->price }}</p>
                                                <center>
                                                    <table>
                                                        <tr>
                                                            <td style="padding: 0px 10px 0px 10px; cursor: pointer;" id="minus"><b>-</b></td>
                                                            <td style="padding: 0px 10px 0px 10px;" class="num" id="quantity_{{ $item->id }}">0</td>
                                                            <td style="padding: 0px 10px 0px 10px; cursor: pointer;" id="plus"><b>+</b></td>
                                                        </tr>
                                                    </table>
                                                </center>
                                                <br>
                                                <p>Sub Total <b><span id="total">Rp. 0</span></b></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach --}}
                                    {{-- <div id="userList"></div> --}}
                                </div>
                            </div>
                        </section>

                    </div>
                    <div class="row fixed-bottom d-flex justify-content-end align-content-center"
                        style="margin-left: 18%; width: 83%; height: 70px; border-top: 3px solid #EEE4B1; background-color: white;">
                        <div class="col text-center" style="margin-right: 50px;">
                            <form action="{{ route('sale.store') }}" method="post">
                                @csrf
                                {{-- <input type="text" name="shop[]" id="shop"> --}}
                                <div id="shop"></div>
                                <button class="btn btn-primary">Selanjutnya</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            let products = @json($products);
            $.each(products, function(key, item) {
                $("#product-list").append(`
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light">
                        <img src="{{ asset('storage/product/`+item.img+`') }}" class="w-50" />
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mb-3">` + item.name + `</h5>
                        <p>Stok ` + item.stock + `</p>
                        <h6 class="mb-3">Rp. ` + formatRupiah(item.price) + `</h6>
                        <p id="price_` + item.id + `" hidden>` + item.price + `</p>
                        <center>
                            <table>
                                <tr>
                                    <td style="padding: 0px 10px 0px 10px; cursor: pointer;" id="minus_` + item.id + `"><b>-</b></td>
                                    <td style="padding: 0px 10px 0px 10px;" class="num" id="quantity_` + item.id + `">0</td>
                                    <td style="padding: 0px 10px 0px 10px; cursor: pointer;" id="plus_` + item.id + `"><b>+</b></td>
                                </tr>
                            </table>
                        </center>
                        <br>
                        <p>Sub Total <b><span id="total_` + item.id + `">Rp. 0</span></b></p>
                    </div>
                </div>
            </div>
        `);

                function formatRupiah(angka) {
                    let numberString = angka.toString();
                    let sisa = numberString.length % 3;
                    let rupiah = numberString.substr(0, sisa);
                    let ribuan = numberString.substr(sisa).match(/\d{3}/g);

                    if (ribuan) {
                        let separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }

                    return rupiah;
                }

                $('#plus_' + item.id).click(function(e) {
                    const elem = $(this).prev();
                    const getId = elem.attr("id").split("_")[1]; // To find the price id
                    const price = $("#price_" + getId).html(); // price amount
                    let qty = parseInt(elem.html()) + 1;

                    // Cek apakah qty melebihi stok
                    if (qty > item.stock) {
                        alert("Stok kurang!");
                        elem.html(item.stock); // Set qty ke stok maksimum
                        qty = item.stock; // Set qty ke stok maksimum
                    }

                    elem.html(qty);
                    let total = price * qty;
                    $("#total_" + item.id).html("Rp. " + formatRupiah(
                    total)); // set total, assume total is qty * price

                    if (qty > 0) {
                        let shop = `` + item.id + `;` + item.name + `;` + item.price + `;` + qty +
                            `;` + total + `;`;
                        $('#shop').append(`
                    <input name="shop[]" value="` + shop + ` " type="text" hidden />
                `);
                    }
                });

                $('#minus_' + item.id).click(function(e) {
                    const elem = $(this).next();
                    const getId = elem.attr("id").split("_")[1]; // To find the price id
                    const price = $("#price_" + getId).html(); // price amount
                    let qty = parseInt(elem.html());

                    if (qty > 0) {
                        qty--;
                    }
                    elem.html(qty);
                    let total = price * qty;
                    $("#total_" + item.id).html("Rp. " + formatRupiah(
                    total)); // set total, assume total is qty * price

                    if (qty > 0) {
                        let shop = `` + item.id + `;` + item.name + `;` + item.price + `;` + qty +
                            `;` + total + `;`;
                        $('#shop').append(`
                    <input name="shop[]" value="` + shop + ` " type="text" hidden />
                `);
                    }
                });
            });
        });
    </script>
@endpush
