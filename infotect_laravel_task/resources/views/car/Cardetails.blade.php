@extends('layout')
@section('content')


<div class="card card-side bg-base-100 shadow-xl  gap-5 block lg:flex  p-6 w-100">
    <div class="lg:w-9/12">
    <figure><img src="{{$car->img_link}}" alt="Album"></figure>
     
    </div>
    <div class="lg:w-7/12 md:6/12">
        <h1 class="text-2xl py-4">
            {{$car->model}}
        </h1>
        <p>$-{{$car->price}}</p>
        <div class="my-12 py-6">
            <div class="flex justify-between m-4">
                <h1>Make</h1>
                <p>{{$car->make}}</p>
            </div>
            <div class="flex justify-between m-4">
                <h1>Model</h1>
                <p>{{$car->model}}</p>
            </div>
            <div class="flex justify-between m-4">
                <h1>Vin</h1>
                <p>{{$car->vin}}</p>
            </div>

        </div>
       
    </div>
  </div>
@endsection
@section("title")
Workspaceit | {{$car->model}} Detailes
@endsection