@extends('layouts.master')
@section('contenu')
   <div class="col-12 p-4">
   		<div class="jumbotron col-12">
   			<h4 class="display-3">Bienvenu, <strong>{{userFullName()}}</strong></h4>
   			<p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling</p>
   			<hr class="my-4">
   			<a href="#" class="btn btn-primary btn-lg" role="button">Learn more</a>
   		</div>
   	</div>
@endsection
