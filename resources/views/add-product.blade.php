<?php $page = 'add-product'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('components.breadcrumb')
                @slot('title')
                    Product Baru
                @endslot
                @slot('li_1')
                    Buat produk baru
                @endslot
                @slot('li_2')
                    product-list
                @endslot
                @slot('li_3')
                    Kembali ke list produk
                @endslot
            @endcomponent
            <!-- /add -->
            <form action="{{ route('create-product') }}"  enctype="multipart/form-data" method="POST">
                @csrf
                @method('POST')
   
                <div class="card">
                    <div class="card-body">
                        <div class="new-employee-field">
                            <div class="card-title-head">
                                <h6><span><i data-feather="info" class="feather-edit"></i></span>Tambahkan Product Terbaru</h6>
                            </div>
                            <div class="profile-pic-upload">
                                <div class="profile-pic">
                                    <img src="{{ asset('build/img/users/user-01.jpg') }}" alt="Default Avatar" id="blah">
                                </div>
                                <div class="input-blocks mb-0 ">
                                    <div class="image-upload mb-0">
                                        <input type="file" name="photo_product" id="imgInpProduct">
                                        <div class="image-uploads">
                                            <h4> + Gambar</h4>
                                        </div>
                                    </div>
                                    @error('photo_product')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name Product</label>
                                        <input type="text" class="form-control" value="" id="name" name="name" >
                                    </div>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                              
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Stok</label>
                                        <input type="number" class="form-control" id="stock" name="stock" min="1" value="1">
                                    </div>
                                    @error('stock')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Harga</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control" name="price" id="price" min="1" value="1" >
                                        </div>
    
                                    </div>
                                    @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                            
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /product list -->

                <div class="text-end mb-3">
                    <button type="button" class="btn btn-cancel me-2" onclick="window.location='{{ url('product-list') }}'">Batal</button>
                    <button type="submit" class="btn btn-submit">Tambah</button>
                </div>
            </form>
            <!-- /add -->

        </div>
    </div>
@endsection
