@extends('layout')

@section('content')

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">ID</th>
      <th scope="col">Code</th>
      <th class="scope="col">Rate</th>
    </tr>
  </thead>
  <tbody>
    

  @foreach($rates as $rate)

    <tr>
      <td>{{ $rate->date }}</td>
      <td>{{ $rate->id }}</td>
      <td>{{ $rate->code }}</td>
      <td align='right'>{{ $rate->rate }}</td>
    </tr>
    
  @endforeach

  </tbody>
</table>
@endsection
