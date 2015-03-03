@extends('layout-container')

@section('scripts')
	{{HTML::script('js/tags.js')}}
@stop

@section('content-container')

	<div>
		<h1>{{ $question->title }}</h1>
		<input type="hidden" id="id"  value="{{$question->_id}}" />
		<input type="hidden" id="user_id" value="{{$question->user['user_id']}}" />
		<br/><br/>
		<div>
		<?php if(!isset($question->user['facebook_id'])) { ?>
		<img src="/thumbnails/{{$question->user['image_url']}}" id="question-image" width="50" height="50" />
		<?php } else { ?>
		<img src="http://graph.facebook.com/{{ $question->user['facebook_id'] }}/picture?type=square" id="question-image" width="50" height="50" />
		<?php }
		?>
			<div id="question-advice">
				
				<b>{{ $question->user["username"]; }}</b>
				<br/>
				{{ $question->text }}<br/><br/>	
			</div>		
		</div>
		<span>{{ $question->created_at; }}</span>		
	</div>

	<div>
		
		{{ Form::open(array('url' => 'advices/store', 'method' => 'post', 'id' => 'form-create')) }}

			<label for="text">Advice</label><br/><br/>
			<textarea name="text" rows="10" style="resize: none;" class="form-control"></textarea>
			<input type="hidden" name="question_id" value="{{ $question->_id }}">
			<br/><br/>
			<input type="submit" value="Submit your adwise" class="btn btn-primary" id="button-submit" />


		{{ Form::close() }}

	</div>

@stop