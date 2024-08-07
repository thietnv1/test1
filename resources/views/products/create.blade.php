@extends('products.master')
@section('title')
    Thêm mới sản phẩm
@endsection
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('orders.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <h2 class="mt-3 mb-3">Customer</h2>
                <div class="mt-3">
                    <label for="customer_name">Name</label>
                    <input type="text" name="customer[name]" id="customer_name" class="form-control">
                    @error('customer.name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="customer_address">Address</label>
                    <input type="text" name="customer[address]" id="customer_address" class="form-control">
                    @error('customer.address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="customer_phone">Phone</label>
                    <input type="tel" name="customer[phone]" id="customer_phone" class="form-control">
                    @error('customer.phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="customer_email">Email</label>
                    <input type="email" name="customer[email]" id="customer_email" class="form-control">
                    @error('customer.email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


            </div>
            <div class="col-md-6">
                <h2 class="mt-3 mb-3">Suppiler</h2>
                <div class="mt-3">
                    <label for="supplier_name">Name</label>
                    <input type="text" name="suppiler[name]" id="supplier_name" class="form-control">
                    @error('supplier.name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="supplier_address">Address</label>
                    <input type="text" name="suppiler[address]" id="supplier_address" class="form-control">
                    @error('supplier.address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="supplier_phone">Phone</label>
                    <input type="tel" name="suppiler[phone]" id="supplier_phone" class="form-control">
                    @error('supplier.phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="supplier_email">Email</label>
                    <input type="email" name="suppiler[email]" id="supplier_email" class="form-control">
                    @error('supplier.email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <h2 class="mt-3 mb-3">Danh sách sản phẩm</h2>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Stock Qty</th>
                            <th>Qty (số lượng bán)</th>
                        </tr>
                        @for ($i = 0; $i < 2; $i++)
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="products[{{ $i }}][name]"
                                        value="{{ old("products.$i.name") }}">
                                    @error("products.$i.name")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="file" class="form-control" name="products[{{ $i }}][image]">
                                    @error("products.$i.image")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                        name="products[{{ $i }}][description]">
                                    @error("products.$i.description")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="products[{{ $i }}][price]">
                                    @error("products.$i.price")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </td>
                                <td>
                                    <input type="number" class="form-control"
                                        name="products[{{ $i }}][quantity]">
                                        @error("products.$i.quantity")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>

                                <td>
                                    <input type="number" class="form-control"
                                        name="order_details[{{ $i }}][quantity]">
                                        @error("order_details.$i.quantity")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                        @endfor

                    </table>
                </div>
            </div>


            <button type="submit" class="mt-3 btn btn-primary">submit</button>


        </div>


    </form>
@endsection
