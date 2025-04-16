<?php $page = 'sales-list'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('components.breadcrumb')
                @slot('title')
                    Sales List
                @endslot
                @slot('li_1')
                    Manage Your Sales
                @endslot
        
            @endcomponent

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                 
                    <div class="table-responsive">
                        <table class="table  datanew">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Customer Name</th>
                                    <th>Date</th>
                                    <th>Grand Total</th>
                                    <th>Cretaed By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="sales-list">
                                @foreach ($saless as $sales)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $sales->customer->name ?? 'Non Mamber' }}</td>
                                        <td>{{ $sales->sale_date }}</td>
                                        <td>{{ 'Rp. ' . number_format($sales->total_price,'0', ',', '.') }}</td>
                                        <td>{{ $sales->user->name }}</td>
                                        <td class="text-center">
                                            <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#sales-modal-detail-{{ $sales->id }}"><i data-feather="eye"
                                                class="info-img"></i>Sale Detail</a>
                                                </li>
                                                
                                                <li>
                                                    <a href="{{ url('download').'/'.$sales->id }}" class="dropdown-item"><i
                                                        data-feather="download" class="info-img"></i>Download pdf</a>
                                                </li>
                                            
                                            </ul>
                                            <div class="modal fade" id="sales-modal-detail-{{ $sales->id }}">
                                                <div class="modal-dialog sales-details-modal">
                                                    <div class="modal-content">
                                                        <div class="page-wrapper details-blk">
                                                            <div class="content p-0">
                                                                <div class="page-header p-4 mb-0">
                                                                    <div class="add-item d-flex">
                                                                        <div class="page-title modal-datail">
                                                                            <h4>Sales Detail</h4>
                                                                        </div>
                                                        
                                                                    </div>
                                                    
                                                                </div>

                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <form action="sales-list">
                                                                            <div class="invoice-box table-height"
                                                                                style="max-width: 1600px;width:100%;overflow: auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">

                                                                                <div class="table-responsive">
                                                                                    <table class="table table-bordered">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Product</th>
                                                                                                <th>Qty</th>
                                                                                                <th>Product Price</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @foreach ($sales->detailSales as $detail)

                                                                                            <tr>
                                                                                                <td>
                                                                                                    <div class="productimgname">
                                                                                                        <a href="javascript:void(0);" class="product-img stock-img">
                                                                                                            @if ($detail->product->image == null)
                                                                                                                <img src="{{ URL::asset('/build/img/users/user-23.jpg') }}" alt="product" class="me-2" width="40">
                                                                                                            @else
                                                                                                                <img src="{{ URL::asset('storage/' . $detail->product->image) }}" alt="product" class="me-2" width="40">
                                                                                                            @endif
                                                                                                        </a>
                                                                                                        <a href="javascript:void(0);">{{ $detail->product->name}}</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                                <td>{{ $detail->amount }}</td>
                                                                                                <td>{{ 'Rp. ' . number_format($detail->product->price,'0', ',', '.') }}</td>
                                                                                               
                                                                                            </tr>

                                                                                            @endforeach
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="row">
                                                                                    <div class="col-lg-6 ms-auto">
                                                                                        <div class="total-order w-100 max-widthauto m-auto mb-4">
                                                                                            <ul>
                                                                                                <li>
                                                                                                    <h4>Paid</h4>
                                                                                                    <h5>{{ 'Rp. ' . number_format($sales->total_pay,'0', ',', '.') }}</h5>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <h4>Change</h4>
                                                                                                    <h5>{{ 'Rp. ' . number_format($sales->total_return,'0', ',', '.') }}</h5>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <h4>Grand Total</h4>
                                                                                                    <h5>{{ 'Rp. ' . number_format($sales->total_price,'0', ',', '.') }}</h5>
                                                                                                </li>
                                                                                            
                                                                                            </ul>
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
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                  

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>
    </div>
@endsection
