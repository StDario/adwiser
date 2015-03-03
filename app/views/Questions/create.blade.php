@extends('layout-container')

@section('scripts')
	{{HTML::script('js/tags.js')}}
@stop

@section('content-container')

	<div id="question-tags" ng-controller="TagController">
		<h1>Enter a question</h1>

		{{ Form::open(array('url' => 'questions/store', 'method' => 'post', 'id' => 'form-create')) }}

			<label for="title">Title</label>
			<input type="text" name="title" class="form-control" /><br/><br/>
			<label for="text">Text</label><br/><br/>
			<textarea name="text" rows="10" style="resize: none;" class="form-control"></textarea>

			<input type="text" class="form-control tag-search-input"
					placeholder="Enter tags for this question" tags-complete/>
			<br/><br/>
			<div id="tag" ng-repeat="sTag in selectedTags">
    			<a href="{{ URL::to('search-tags') }}/{sTag}">{sTag}</a>
    		</div>
    		<input type="text" style="display: none;" name="sendTags" ng-model="sendTags" />
    		<br/>
			<input type="submit" value="Submit your question" class="btn btn-primary"/>


		{{ Form::close() }}

	</div>
	<script type="text/javascript">
		angular.bootstrap(document.getElementById('question-tags'), ['tags']);
	</script>

@stop