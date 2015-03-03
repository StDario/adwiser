<div>
	
	

	<div class="animation entry-container" ng-repeat="question in questions">
		<a href="{{ URL::to('questions') }}/{question._id}"><h1>{question.title}</h1></a><br/>
		
		<div>
			<img src="http://localhost:8000/thumbnails/{question.user.image_url}"  width="50 " height="50" 
					ng-show="question.user.hasOwnProperty('image_url')"
					id="question-image" />
			<img src="http://graph.facebook.com/{ question.user.facebook_id}/picture?type=square" id="question-image" 
				width="50" height="50" ng-hide="question.user.hasOwnProperty('image_url')" 
			 />

			<div id="question-advice">
		
				<b>{question.user.username}</b><br/>
				{question.text}<br/>
		
			</div>
		</div>
		
		<input type="hidden" name="user_id" value="{question.user.user_id}" />
		
		<div>
		
			{question.created_at}
			<div class="entry-tags">
		
				<div ng-repeat="tag in question.tags" id="tag">
					<a href="{{ URL::to('search-tags') }}/{tag}">{tag}</a>
				</div>
		
			</div>
		</div>
		<br/>
			
		<div id="fb-root"></div>


<div class="fb-share-button" data-href="http://localhost:8000/questions/{question._id}" data-type="button"></div>

<a href="http://localhost:8000/questions/{question._id}" class="twitter-share-button" data-lang="en">Tweet</a>


<div style="margin-left: 10px;" class="g-plus" data-action="share" data-annotation="none" data-href="http://localhost:8000/questions/{question._id}"></div>

<!-- Place this tag after the last share tag. -->

<br/>
		<input type="button" class="btn btn-primary" value="Top adwises" ng-click="expandAdvice(question._id)" ng-show="question.advices.length > 0">
		<input type="hidden" id="show_{question._id}" value="false" />
		<div id="advice_{question._id}" style="display: none;"> 
			<div  ng-repeat="advice in question.advices" 
					class="whitesmoke expand-advice">
			
				<b>{advice.user.username}</b><br/>
				{advice.text}

			</div>
		</div>
		<hr/>
</div>

</div>
