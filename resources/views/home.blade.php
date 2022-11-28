@extends('layouts.master')
@section('content')
    <section class="row p-5 d-flex justify-content-center">
        <div class="col-md-3 card m-4">
            <a class="link" href="{{ route('branch.index')}}">
                <img src="{{asset("assets/images/chain-store.jpg")}}" class="card-img-top card-image mt-3" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Chain Store Branches</h5>
                    <p class="card-text">Our store has many branches all over the country. You can see the list of branches here.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 card m-4">
            <a class="link" href="{{ route('user.index') }}">
                <img src="{{asset("assets/images/employee.jpg")}}" class="card-img-top card-image mt-3" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Employee</h5>
                    <p class="card-text">List of all chain store employee.</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 card m-4">
            <a class="link" href="{{route('news.index')}}">
                <img src="{{asset("assets/images/News.jpg")}}" class="card-img-top card-image mt-3" alt="...">
                <div class="card-body">
                    <h5 class="card-title">News</h5>
                    <p class="card-text">Click here to view the latest store news.</p>
                </div>
            </a>
        </div>
    </section>
@endsection