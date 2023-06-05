@extends('layouts.customer')

@section('title')
  Check Out
@endsection

@section('content')
  <div class="py-5">

  </div>
  <div class="container mt-3">
    <form action="{{ url('place-order') }}" method="POST">
      @csrf
      <div class="row">
        <div class="col-md-7">
          <div class="card border-0">
            <div class="card-body">
              <h5>Basic Detail</h5>
              <hr>
              <div class="row checkout-form">
                <div class="col-md-6 my-2">
                  <label for="firstname">Name</label>
                  <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}"
                    placeholder="First Name" required>
                </div>
                <div class="col-md-6  my-2">
                  <label for="email">Email</label>
                  <input type="text" name="email" class="form-control" value="{{ Auth::user()->email }}"
                    placeholder="email@example.com" required>
                </div>
                <div class="col-md-6  my-2">
                  <label for="email">Phone Number</label>
                  <input type="number" name="phone" class="form-control" value="{{ Auth::user()->phone }}"
                    placeholder="88 851 18 04" required>
                </div>
                <div class="col-md-6  my-2">
                  <label for="email">Address</label>
                  <input type="text" name="address" class="form-control" value="{{ Auth::user()->address }}"
                    placeholder="Enter Address" required>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="card border-0 ">
            <div class="card-body">
              <h5>Order Detail</h5>
              <hr>
              <table class="table table-stripped">
                <tbody>
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Quantity</th>
                      <th>Price</th>
                    </tr>
                  </thead>
                  @foreach ($cartitem as $item)
                    <tr>
                      <td>{{ $item->products->name }}</td>
                      <td>{{ $item->prod_qty }}</td>
                      <td>{{ $item->products->selling_price }}</td>
                      <td></td>
                    </tr>
                  @endforeach

                </tbody>
              </table>
              <hr>
              <button type="submit" class="btn btn-outline-primary float-end">Place Order</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection


@section('css')
  <style>
    .checkout-form input {

      font-size: 1rem;
      padding: 10px;
      font-weight: 400;
    }

    .checkout-form label {
      font-size: .9rem;
      font-weight: 700;
    }
  </style>
@endsection
