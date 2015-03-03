@extends('layout-container')

@section('scripts')
	{{HTML::script('js/review.js')}}
@stop

@section('content-container')


<div id="review-app" ng-controller="ReviewController">
	<h1>{{ $review->title }}</h1>
	<input type="hidden" id="id"  value="{{$review->_id}}" />
	<input type="hidden" id="user_id" value="{{$review->user['user_id']}}" />
	<br/><br/>

	<div>

		<?php if(!isset($review->user['facebook_id'])) { ?>
		<img src="http://localhost:8000/thumbnails/{{$review->user['image_url']}}" id="review-image"  width="50" height="50" />
		<?php } else { ?>
		<img src="http://graph.facebook.com/{{ $review->user['facebook_id'] }}/picture?type=square" id="review-image" width="50" height="50" />
		<?php }?>
		<div class="question-advice">
			
			<b>{{ $review->user["username"]; }}</b>
			<br/>
			{{ $review->text }}<br/><br/>	
		</div>		
	</div>

	<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=157980984393269";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-share-button" data-href="http://localhost:8000/reviews/{{$review->_id}}" data-type="button"></div>


<a href="http://localhost:8000/reviews/{{$review->_id}}" class="twitter-share-button" data-lang="en">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


<div class="g-plus" data-action="share" data-annotation="none" data-href="http://localhost:8000/reviews/{{$review->_id}}"></div>

<!-- Place this tag after the last share tag. -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
	<input type="hidden" id="rating" value="{{ $rating_enable }}" /> 


	<div class="review-date">
		
		{{$review->created_at}}
		<div class="entry-tags">
		<?php foreach($review->tags as $tag) { ?>
			<div id="tag">
				<a href="{{ URL::to('search-tags') }}/{{$tag}}">{{$tag}}</a>
			</div>
		<?php } ?>
		</div>
	</div>
	<br/><br/>

	<div class="rating">
		<a ng-click="ups(review.id)" class="rate-btn" style="margin-right: 5px;">
			<img src="http://localhost:8000/images/app/iconUp.png" width="25" height="25">
		</a>
		<span ng-init="review.ups = {{$review->ups}}">{ review.ups }</span>
		

		<a ng-click="downs()" class="rate-btn down">
			<img src="http://localhost:8000/images/app/iconDown.png" width="25" height="25">
		</a>
		<span ng-init="review.downs = {{$review->downs}}">{ review.downs }</span>
	</div>
</div>
<script type="text/javascript">
	angular.bootstrap(document.getElementById('review-app'), ['review']);
</script>

@stop