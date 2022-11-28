@extends(backpack_view('blank'))

@section('after_styles')
    <style media="screen">
        .backpack-profile-form .required::after {
            content: ' *';
            color: red;
        }
    </style>
@endsection

@php
  $breadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      trans('backpack::base.my_account') => false,
  ];
@endphp

@section('header')
    <section class="content-header">
        <div class="container-fluid mb-3">
            <h1>{{ trans('backpack::base.my_account') }}</h1>
        </div>
    </section>
@endsection

@section('content')
    @if (session('success'))
        <div class="col-lg-8">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if ($errors->count())
        <div class="col-lg-8">
            <div class="alert alert-danger">
                <ul class="mb-1">
                    @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <section class="" style="background-color: #f4f5f7;">
        <div class="container py-5 h-100">
        <div class="row h-100">
            <div class="col col-md-6 mb-4 mb-lg-0">
            <div class="card mb-3" style="border-radius: .5rem;">
                <div class="row g-0">
                <div class="col-md-4 gradient-custom text-center text-white"
                    style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                    <img src="{{ userAvatar()}}" 
                    alt="Avatar" class="img-fluid my-5" style="width: 80px; height: 80px;border-radius: 50%" />
                    <i class="far fa-edit mb-5"></i>
                </div>
                <div class="col-md-8">
                    <div class="card-body p-4">
                    <h6>Information</h6>
                    <hr class="mt-0 mb-4">
                    <div class="row pt-1">
                        <span class="col-12 d-flex mb-3">
                            <p>User Name : </p>
                            <p class="text-muted"> {{ backpack_auth()->user()->username }}</p>
                        </span>
                        <span class="col-12 d-flex mb-3">
                            <p>Job Title : </p>
                            <p class="text-muted"> {{ backpack_auth()->user()->job_title }}</p>
                        </span>
                        <span class="col-12 d-flex mb-3">
                            <p>First Name : </p>
                            <p class="text-muted"> {{  backpack_auth()->user()->first_name }}</p>
                        </span>
                        <span class="col-12 d-flex mb-3">
                            <p>Last Name : </p>
                            <p class="text-muted"> {{backpack_auth()->user()->last_name}}</p>
                        </span>

                        <span class="col-12 d-flex mb-3">
                            <p>Branch : </p>
                            <p class="text-muted"> {{backpack_auth()->user()->branch ? backpack_auth()->user()->branch->name : ' Not set'}}</p>
                        </span>
                     
                    </div>
                  
                </div>
                
                <div class="card-footer d-flex justify-content-center">
                    <form class="form" action="{{ route('backpack.account.password') }}" method="post">

                        {!! csrf_field() !!}
        
                        
                            
                            <div class="row">
                                <div class="col-12 form-group">
                                    @php
                                        $label = trans('backpack::base.old_password');
                                        $field = 'old_password';
                                    @endphp
                                    <label class="required">{{ $label }}</label>
                                    <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                                </div>
    
                                <div class="col-12 form-group">
                                    @php
                                        $label = trans('backpack::base.new_password');
                                        $field = 'new_password';
                                    @endphp
                                    <label class="required">{{ $label }}</label>
                                    <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                                </div>
    
                                <div class="col-12 form-group">
                                    @php
                                        $label = trans('backpack::base.confirm_password');
                                        $field = 'confirm_password';
                                    @endphp
                                    <label class="required">{{ $label }}</label>
                                    <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                                </div>
                            </div>
                        
    
                        
                        <button type="submit" class="btn btn-success"><i class="la la-save"></i> {{ trans('backpack::base.change_password') }}</button>
                        <a href="{{ backpack_url() }}" class="btn">{{ trans('backpack::base.cancel') }}</a>
        
        
        
                    </form>
                
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>



@endsection
