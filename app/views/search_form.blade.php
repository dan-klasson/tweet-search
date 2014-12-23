
{{ Form::open(array('class' => 'form-inline')) }}
<div class="row">
  <div class="col-sm-10">
	{{ Form::text('city', null, array('class' => 'form-control', 'placeholder' => 'City name')) }}
	{{ Form::button('SEARCH', array('class' => 'btn btn-primary', 'type' => 'submit')) }}
	{{ Form::button('HISTORY', array('class' => 'btn btn-primary', 'id' => 'history')) }}
  </div>
</div>
{{ Form::close() }}

