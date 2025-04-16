<?php $page = 'product-list'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('components.breadcrumb')
                @slot('title')
                    Product List
                @endslot
                @slot('li_1')
                    Manage your products
                @endslot
                @slot('li_2')
                    {{ url('add-product') }}
                @endslot
                @if (Auth::user()->role == 'admin')
                @slot('li_3')
                    Add New Product
                @endslot
                @endif
               
            @endcomponent

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                    <div class="table-responsive product-list">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Product</th>
                                  
                                    <th>Price</th>
                                    <th>Qty</th>
                                    @if (Auth::user()->role == 'admin')
                                        <th class="no-sort">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="productimgname">
                                                <a href="javascript:void(0);" class="product-img stock-img">
                                                @if ($product->image == null)
                                                    <img src="{{ URL::asset('/build/img/users/user-23.jpg') }}" alt="product">
                                                @else
                                                    <img src="{{ URL::asset('storage/' . $product->image) }}" alt="product">
                                                @endif
                                                </a>
                                            <a href="javascript:void(0);">{{$product->name}} </a>
                                        </div>
                                    </td>
                                   
                                    <td>Rp {{ $product->price }}</td>
                                    <td>{{$product->stock}}</td>
                                    @if (Auth::user()->role == 'admin')
                                    <td class="action-table-data">
                                        <div class="edit-delete-action">
                                            <a class="me-2 p-2" href="#" data-bs-toggle="modal"
                                                data-bs-target="#adjust-stock-{{ $product->id }}">
                                                <i data-feather="plus-circle" class="feather-edit"></i>
                                            </a>
                                            <a class="me-2 p-2" href="{{ url('edit-product', $product->id)  }}">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" class=" p-2 text-danger"
                                            data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $product->id }}">
                                                <i data-feather="trash-2" class="feather-trash-2"></i>
                                            </a>


                                            <!-- Modal Konfirmasi -->
                                            <div class="modal fade" id="confirmDeleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                 Are you sure you want to delete this product?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                                                    <form id="delete-form-{{ $product->id }}" action="{{ route('product.delete', $product->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                            </div>



                                        </div>
                                    </td>
                                    @endif
                                   
                                </tr>
                                 <!-- Modal -->
                                 <div class="modal fade" id="adjust-stock-{{ $product->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered stock-adjust-modal">
                                            <div class="modal-content">
                                                <form action="{{ url('uppdate-stock/'.$product->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-header border-0 custom-modal-header">
                                                        <h5 class="modal-title">Perbaharui Stok Produk</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body custom-modal-body">
                                                        <div class="d-flex align-items-center">
                                                            <!-- Gambar dan Name Produk -->
                                                            <div class="productimgname d-flex align-items-center me-4">
                                                            @if ($product->image == null)
                                                                <img src="{{ URL::asset('/build/img/users/user-23.jpg') }}" alt="product" class="me-2" width="40">
                                                            @else
                                                                <img src="{{ URL::asset('storage/' . $product->image) }}" alt="product" class="me-2" width="40">
                                                            @endif
                                                                <strong>{{ $product->name }}</strong>
                                                            </div>

                                                            <!-- Input Quantity -->
                                                            <div class="product-quantity d-flex align-items-center">
                                                                <span class="quantity-btn"><i data-feather="minus-circle" class="feather-search"></i></span>
																		<input type="text" class="quntity-input" value="{{ $product->stock }}">
																		<span class="quantity-btn">+<i data-feather="plus-circle" class="plus-circle"></i></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer modal-footer-btn">
                                                        <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-submit">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            </tbody>
                            @endforeach
                        </table>
                    </div>

                </div>
            </div>
            <!-- /product list -->
        </div>
    </div>

@endsection
