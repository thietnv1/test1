@extends('products.master')
@section('title')
    Thêm mới sản phẩm
@endsection
@section('content')

  @if (session()->has('error'))
  <div class="alert alert-danger">
        {{session()->get('error')}}
  </div>
      
  @endif
  @if (session()->has('success'))
  <div class="alert alert-danger">
        {{session()->get('success')}}
  </div>
      
  @endif
  
    <a href="{{route('orders.create')}}" class="btn btn-danger mb-3">Thêm mới </a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer info</th>
                <th>Total Amout</th>
                <th>Order Detail</th>
                <th>Create at</th>
                <th>Update at</th>
                <th>Action</th>
              
                
            </tr>
        </thead>
        <tbody>
            @foreach($data as $order)
            <tr>
                <td>{{ $order->id }}</td>

                <td>
                    <ul>
                        <li>{{$order->customer->name}}</li>
                        <li>{{$order->customer->email}}</li>
                        <li>{{$order->customer->address}}</li>
                        <li>{{$order->customer->phone}}</li>
                    </ul>
                </td>
                <td>{{ number_format($order->total_amount)}}</td>
                <td>
                    @foreach ($order->products as $product)
                    <h6>Sản  Phẩm: {{$product->name}}</h6>
                    <ul>
                     <li> Giá:{{number_format($product->pivot->price)}}</li>
                     <li>Số lượng {{ $product->pivot->quntity}}</li>
                     @if ($product->image && \Storage::exists($product->image))
                     <li>
                         <img width="100px" src="{{\Storage($product->image)}}" alt="">
                     </li>
                     @endif
                    
                    </ul>
                        
                    @endforeach
                </td>
                <td>{{$order->created_at}}</td>
                <td>{{$order->updated_at}}</td>
                 <td>
                    <a href="{{route('orders.edit',$order)}}" class="btn btn-warning mb-3">Sửa</a>   
                    <a href="{{route('orders.show',$order)}}" class="btn btn-warning mb-3">Show</a>   
                    
                    <form action="{{route('orders.destroy',$order)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-info" onclick="return confirm('Chắc chắn chưa!!! ')"> Xoá </button>   
                    </form>
                 </td>
            </tr>
            @endforeach
        </tbody>
    </table>

 
@endsection
