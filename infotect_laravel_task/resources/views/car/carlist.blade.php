@extends("layout")
@section('content')
<div class="text-center text-2xl py-7">
    <h1>INVENTORY</h1>
</div>
<div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-4  my-10 justify-items-center">
    @foreach($cars as $item)
    <div class="card w-96 bg-base-100 shadow-xl">
        <figure class="px-10 pt-10">
          <img src="{{$item->img_link}}" alt="Shoes" class="w-full" style="height:200px" />
        </figure>
        <div class="card-body ">
            <div class="flex justify-between">
                <div>
                    <h2 class="card-title m-2">{{$item->model}}</h2>
                    <p class="text-sm m-2">VIN- {{$item->vin}}</p>
                </div>
              <div class="m-2">
                $-{{$item->price}}
              </div>
            </div>
        
            <div class="card-actions">
                <a href="/cardetailes/{{$item->id}}"><button class="btn btn-primary mx-auto my-4">Details</button></a>
              </div>
        </div>
       
      </div>
    @endforeach
    
</div>
@endsection
@section("title")
Workspaceit | Car List
@endsection