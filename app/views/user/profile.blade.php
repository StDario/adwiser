@extends('layout')

@section('scripts')
{{ HTML::script('js/search-result.js') }}
@stop

@section('content')

	<div id="container-home" class="grid-100 grid-parent paragraphs-container" >
    
    	

    	<div class="grid-33 white profile-panel" >

	    	<div>

	    		<?php if(isset($user->facebookID)) { ?>
	    		<img src="http://graph.facebook.com/{{ $user->facebookID }}/picture?type=large" width="200" height="200" />
	    		<?php } else if(isset($user->googleID)) { ?>
	    		<img src="{{ $user->image_url }}" width="200" height="200">
	    		<?php } else if(isset($user->twitterID)) { ?>
	    		<img src="" width="200" height="200">
	    		<?php } else { ?>
	    		<img src="http://localhost:8000/images/{{$user->image_url}}"  width="250" height="200" />
	    		<?php } ?>

	    	</div><br/>

	    	<div class="profile-info">
	    		Username<br/>
	    		<label>{{ $user->username }}</label><br/>
	    		Full name<br/>
	    		<label>{{ $user->name }}</label>&nbsp<label>{{ $user->lastname }}</label><br/>
	    		Email<br/>
	    		<label>{{ $user->email }}</label><br/>
	    		Gender<br/>
	    		<label>{{ $user->gender }}</label><br/>
	    		Birthday<br/>
	    		<label>{{ $user->birthday }}</label>
	    	</div>

    	</div>


    	<div class="grid-66 white" id="profile-activity">
    		<h1>What you have been up to</h1>
 	           <div ng-controller="SearchController" id="search-results">
		<nav class="grid-100 mobile-grid-100 white" id="nav-profile">
			<ul id="menu-container" >
				<!--<li ng-class="questions_active"><a ng-click="redirect('questions')">Question</a></li>
				<li ng-class="reviews_active"><a ng-click="redirect('reviews')">Review</a></li> -->
				<li ng-class="questions_active"><a ng-click="questionsActive()">Questions</a></li>
				<li ng-class="reviews_active"><a ng-click="reviewsActive()">Reviews</a></li>
			</ul>

		</nav>
		<div ng-show="questions_active == 'active'">
			
	
	
				<?php $i = 0;
					foreach($questions as $question){
				?>
					<div>
						<a href="{{ URL::to('questions') }}/{{$question->_id}}"><h1>{{$question->title}}</h1></a><br/>
						
						<div>
							<?php if(!isset($question->user['facebook_id'])) { ?>
								<img src="/thumbnails/{{$question->user['image_url']}}" id="question-image" width="50" height="50" />
								<?php } else { ?>
								<img src="http://graph.facebook.com/{{ $question->user['facebook_id'] }}/picture?type=square" id="question-image" width="50" height="50" />
								<?php }
								?>
							<div  id="question-advice">
						
								<b>{{$question->user['username']}}</b><br/>
								{{$question->text}}<br/>
						
							</div>
						</div>
						
						<input type="hidden" name="user_id" value="{{$question->user['user_id']}}" />
						

						<div class="fb-share-button" data-href="http://localhost:8000/questions/{{$question->_id}}" data-type="button"></div>

						<a href="http://localhost:8000/questions/{{$question->_id}}" class="twitter-share-button" data-lang="en">Tweet</a>


						<div class="g-plus" data-action="share" data-annotation="none" data-href="http://localhost:8000/questions/{{$question->_id}}"></div>						

						<div class="profile-question">
						
							{{$question->created_at}}
							<div class="entry-tags">
								<?php foreach($question->tags as $tag){ ?>
								<div id="tag">
									<a href="{{ URL::to('search') }}?istag=true&tag={{$tag}}">{{$tag}}</a>
								</div>
								<?php } ?>
						
							</div>
						</div>
						<?php if(isset($question->advices)) { ?>
						<input type="button" class="btn btn-primary" value="Top adwises" ng-click="expandAdvice({{ $i }})">
						<?php } ?>
						<input type="hidden" id="show_{{$i}}" value="false" />
						<div id="advice_{{$i++}}" style="display: none;"> 
							<?php if(isset($question->advices)) { 
								foreach($question->advices as $advice){ ?>
							<div class="whitesmoke expand-advice">
								<b>{{$advice['user']['username']}}</b><br/>
								{{$advice['text']}}
							</div>
							<?php } }?>
						</div>
						<hr/>
						
				</div>
				<?php }?>
		</div>
		<div ng-show="reviews_active == 'active'">
			


			
				<?php  foreach($reviews as $review) {?>
				<div class="entry-container">
					
					<a href="{{ URL::to('reviews') }}/{{$review->_id}}"><h1>{{$review->title}}</h1></a><br/>
					
					<div>
						<?php if(!isset($review->user['facebook_id'])) { ?>
							<img src="http://localhost:8000/thumbnails/{{$review->user['image_url']}}" id="review-image"  width="50" height="50" />
							<?php } else { ?>
							<img src="http://graph.facebook.com/{{ $review->user['facebook_id'] }}/picture?type=square" id="review-image" width="50" height="50" />
							<?php }?>
						<div id="question-advice">
					
							<b>{{$review->user['username']}}</b><br/>
							{{$review->text}}<br/>
					
						</div>
					</div>
					
					

					<div class="fb-share-button" data-href="http://localhost:8000/reviews/{{$review->_id}}" data-type="button"></div>

					<a href="http://localhost:8000/reviews/{{$review->_id}}" class="twitter-share-button" data-lang="en">Tweet</a>
					
					<div class="g-plus" data-action="share" data-annotation="none" data-href="http://localhost:8000/reviews/{{$review->_id}}"></div>

					<!-- Place this tag after the last share tag. -->
					

					<input type="hidden" name="user_id" value="{{$review->user['user_id']}}" />
					
					<div class="profile-question">
					
						{{$review->created_at}}
						<div class="entry-tags">
						<?php foreach($review->tags as $tag) { ?>
							<div id="tag">
								<a href="{{ URL::to('search') }}?istag=true&tag={{$tag}}">{{$tag}}</a>
							</div>
						<?php } ?>
						</div>
					</div>
					<hr/>
				</div>
				<?php }?>
			</div>
		
	</div>
	
    	</div>
<script type="text/javascript">
		angular.bootstrap(document.getElementById('search-results'), ['searchResults']);
	</script>


	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=157980984393269";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					

	<script type="text/javascript">
	  (function() {
	    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	    po.src = 'https://apis.google.com/js/platform.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>	
@stop