@extends('layouts.main')

@section('content')
	<div class="row">
		<h3>Cart Item</h3>
		<!-- {{$cart = Cart::content()}}
		<pre>
		{{print_r($cart->toArray())}}
		</pre> -->
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Size</th>
					<th>Action</th>					
				</tr>
			</thead>
			<tbody>
			@foreach($cartItems as $cartItem)
				<tr>
					<td>{{$cartItem->name}}</td>
					<td>{{$cartItem->price}}</td>
					<td width="50px">
						
						{!! Form::open(['route'=>['cart.update',$cartItem->rowId],'method'=>'PUT']) !!}
							<input type="text" name="qty" value="{{$cartItem->qty}}">
							
					</td>
					<!-- <td>{{$cartItem->options->has('size')?$cartItem->options->size:'' }}</td> -->
					<td>
						<div>
							{!! Form::select('size',['small'=>'Small','medium'=>'Medium','large'=>'Large'],$cartItem->options->has('size')?$cartItem->options->size:'') !!}
						</div>
					</td>

					<td>
						<input type="submit" class="button success small" style="float:left" value="OK">
						{!! Form::close() !!}
						<!-- <a class="button" href="{{route('cart.destroy',$cartItem->rowId) }}">Delete</a> -->
						<form action="{{route('cart.destroy',$cartItem->rowId) }}" method="POST">  <!-- yo route bhaneko cart controller ko destroy ma jancha -->
							{{csrf_field()}}
							{{method_field('DELETE')}}
							<input class="button alert small" type="submit" value="Delete">
						</form>
					</td>
				</tr>
			@endforeach
			<tr>
				<td></td>	
				<td>
					Tax:${{Cart::tax()}} <br>            <!-- tax is implemented in vendor/gloudeman/shoppingcart/config/cart.php -->
					Sub Total:${{Cart::subtotal()}} <br>
					Grand Total:${{Cart::total()}}
				</td>	
				<td>Items:{{Cart::count()}}</td>
				<td></td>
				<td></td>		
			</tr>
			</tbody>
		</table>
		<a href="{{route('checkout.shipping')}}" class="button">Checkout</a>
	</div>
@endsection