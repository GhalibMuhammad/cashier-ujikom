<?php $page = 'add-employee'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>New Employee</h4>
                        <h6>Create new Employee</h6>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li>
                        <div class="page-btn">
                            <a href="{{ url('users') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                                    class="me-2"></i>Kembali Ke list user</a>
                        </div>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                data-feather="chevron-up" class="feather-chevron-up"></i></a>
                    </li>
                </ul>
            </div>
            <!-- /product list -->
            <form action="{{ url('create-user') }}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('POST')

                <div class="card">
                    <div class="card-body">
                        <div class="new-employee-field">
                            <div class="card-title-head">
                                <h6><span><i data-feather="info" class="feather-edit"></i></span>Add Newest User</h6>
                            </div>
                           
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" value="" id="name" name="name" >
                                    </div>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="">
                                    </div>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <select name="role" id="role" class="form-select" >
                                            <option selected disabled hidden>Pilih Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="employee">employee</option>
                                        </select>
                                        @error('role')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        <div class="pass-info">
                                <div class="card-title-head">
                                    <h6><span><i data-feather="info" class="feather-edit"></i></span>Password</h6>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="input-blocks mb-md-0 mb-sm-3">
                                            <label>Password</label>
                                            <div class="pass-group">
                                                <input type="password" class="pass-input"  id="password" name="password" required>
                                                <span class="fas toggle-password fa-eye-slash"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>

                <!-- /product list -->

                <div class="text-end mb-3">
                <button type="button" class="btn btn-cancel me-2" onclick="window.location='{{ url('users') }}'">Batal</button>
                <button type="submit" class="btn btn-submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>
@endsection
