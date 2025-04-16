<?php $page = 'edit-product'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Edit Product</h4>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li>
                        <div class="page-btn">
                            <a href="{{ url('product-list') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                                    class="me-2"></i>Kembali ke list produk</a>
                        </div>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                data-feather="chevron-up" class="feather-chevron-up"></i></a>
                    </li>
                </ul>

            </div>
            <!-- /add -->
            <form action="{{ url('/products/update', $product->id) }}" method="POST"enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="card">
                    <div class="card-body">
                        <div class="new-employee-field">
                            <div class="card-title-head">
                                <h6><span><i data-feather="info" class="feather-edit"></i></span>Perbaharui Product</h6>
                            </div>
                            <div class="profile-pic-upload">
                                <div class="profile-pic">
                                    @if ($product->image == null)
                                        <img src="{{ asset('build/img/users/user-01.jpg') }}" alt="Default Avatar" id="blah">
                                    @else
                                        <img src="{{ URL::asset('storage/' . $product->image) }}" alt="Default Avatar" id="blah">
                                    @endif
                                   
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
                                        <input type="text" class="form-control" value="{{ $product->name }}" id="name" name="name" >
                                    </div>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                              
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Harga</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control" id="price" name="price" min="1" value="{{$product->price}}" >
                                        </div>
    
                                    </div>
                                    @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Stok</label>
                                        <input type="number" class="form-control" id="stock" name="stock" min="1" value="{{$product->stock}}" readonly>
                                    </div>
                                    @error('stock')
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
                    <button type="submit" class="btn btn-submit">Edit</button>
                </div>

            </form>
            <!-- /add -->

        </div>
    </div>
@endsection
