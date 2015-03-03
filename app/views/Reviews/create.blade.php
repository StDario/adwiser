@extends('layout-container')

@section('scripts')
	{{HTML::script('js/tags.js')}}
@stop

@section('content-container')

	<div ng-app="tags" ng-controller="TagController">
		<h1 style="font-size: 20px;">Enter a review</h1>

		{{ Form::open(array('url' => 'reviews/store', 'method' => 'post', 'id' => 'form-create')) }}

			<label for="title">Title</label>
			<input type="text" name="title" class="form-control" /><br/><br/>
			<label for="text">Text</label><br/><br/>
			<textarea name="text" rows="10" style="resize: none;" class="form-control"></textarea>

			<input type="text" class="form-control tag-search-input" id="search-tags" placeholder="Enter tags for this review" tags-complete/>
			<br/><br/>
			<div id="tag" ng-repeat="sTag in selectedTags">
    			<a href="{{ URL::to('search-tags') }}/{sTag}">{sTag}</a>
    		</div>
    		<input type="text" style="display: none;" name="sendTags" ng-model="sendTags" />
    		<br/>
			<input type="submit" value="Submit your review" class="btn btn-primary" />


		{{ Form::close() }}

	</div>

@stop