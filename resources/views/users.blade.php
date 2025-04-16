<?php $page = 'users'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('components.breadcrumb')
                @slot('title')
                    User List
                @endslot
                @slot('li_1')
                    Manage Your Users
                @endslot
                @slot('li_2')
                    Add New User
                @endslot
            @endcomponent

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>User Name</th>
                                    <th>email</th>
                                    <th>Role</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="userimgname">
                                            
                                            <div>
                                                <a href="javascript:void(0);">{{ $user->name }}</a>
                                            </div>

                                        </div>
                                    </td>
                                    <td>{{$user->email}}</td>
                                    <td>{{ $user->role }}</td>
                                    <td class="action-table-data">
                                        <div class="edit-delete-action">
                                       
                                            <a class="me-2 p-2" href="{{ url('edit-employee', $user->id)  }}">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a>
                                            
                                            </a>
                              
                                            <a href="javascript:void(0);" class=" p-2 text-danger"
                                            data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $user->id }}">
                                                <i data-feather="trash-2" class="feather-trash-2"></i>
                                            </a>


                                            <!-- Modal Konfirmasi -->
                                            <div class="modal fade" id="confirmDeleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this user?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                                                    <form id="delete-form-{{ $user->id }}" action="{{ route('user.delete', $user->id) }}" method="POST">
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
