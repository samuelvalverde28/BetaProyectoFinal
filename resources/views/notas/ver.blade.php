@extends('plantilla')
@section('titulo')
: notas
@stop

@section('cuerpo')

	<h4>K ase cuerpo?</h4>

	<table class="table">
		<thead>
		  <tr>
			<th scope="col">idNot</th>
			<th scope="col">idtab</th>
			<th scope="col">texto</th>
			
		  </tr>
		</thead>
		<tbody>
			@foreach ($Nota as $notas)
			<tr>
				<th scope="row">{{$notas->idNot}}</th>
				<td>{{$notas->idTab}}</td>
				<td>{{$notas->texto}}</td>
				
			  </tr>

				
			@endforeach
		  
		  
		</tbody>
	  </table>


	


@stop

	