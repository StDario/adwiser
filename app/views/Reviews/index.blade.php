


<div>
	
	<div ng-repeat="review in reviews" class="animation entry-container">
		
		<a href="{{ URL::to('reviews') }}/{review._id}"><h1>{review.title}</h1></a><br/>
		
		<div>
			<img src="http://localhost:8000/thumbnails/{review.user.image_url}"  width="50 " height="50" 
				ng-show="review.user.hasOwnProperty('image_url')"	id="review-image" />
				<img src="http://graph.facebook.com/{ review.user.facebook_id}/picture?type=square" id="review-image" 
				width="50" height="50" ng-hide="review.user.hasOwnProperty('image_url')" 
			 />
			
			<div id="question-advice">
		
				<b>{review.user.username}</b><br/>
				{review.text}<br/>
		
			</div>
		</div>
		
		<input type="hidden" name="user_id" value="{review.user.user_id}" />
		
		<div id="fb-root"></div>

<div class="fb-share-button" data-href="http://localhost:8000/reviews/{review._id}" data-type="button"></div>

<a href="http://localhost:8000/reviews/{review._id}" class="twitter-share-button" data-lang="en">Tweet</a>

		
<div class="g-plus" data-action="share" data-annotation="none" data-href="http://localhost:8000/reviews/{review._id}"></div>



		<div>
		
			{review.created_at}
			<div class="entry-tags">
		
				<div ng-repeat="tag in review.tags" id="tag">
					<a href="{{ URL::to('search-tags') }}/{tag}">{tag}</a>
				</div>
			</div>
		</div>
		<hr/>
	</div>
