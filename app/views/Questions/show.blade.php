@extends('layout-container')

@section('scripts')
	{{HTML::script('js/question.js')}}
	{{HTML::script('js/advice.js')}}
@stop

@section('content-container')

<div ng-app="question" ng-controller="QuestionController">
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
	<div class="entry-tags">
		<?php foreach($question->tags as $tag) { ?>
		<div id="tag">
			<a href="{{ URL::to('search-tags') }}/{{$tag}}">{{$tag}}</a>
		</div>
		<?php } ?>
	</div>
	<br/><br/>

	


<div class="fb-share-button" data-href="http://localhost:8000/questions/{{ $question->_id }}" data-type="button"></div>

<a href="http://localhost:8000/questions/{{ $question->_id }}" class="twitter-share-button" data-lang="en">Tweet</a>

<div class="g-plus" data-action="share" data-annotation="none" data-href="http://localhost:8000/questions/{{ $question->_id }}"></div>

<!-- Place this tag after the last share tag. -->

	
	<br/><br/>
	@if(Auth::check() && Auth::user()->_id != $question->user['user_id'])
	<input type="button" class="btn btn-primary" value="Adwise" onclick="location.href='/advices/create/{{ $question->_id }}'">
	@endif
	<input type="hidden" id="rating" value="{{ $rating_enable }}" /> 
	<div class="rating">
	<a ng-click="ups(question.id)" class="rate-btn">
		<img src="/images/app/iconUp.png" width="25" height="25">
	</a>
	<span ng-init="question.ups = {{$question->ups}}">{ question.ups }</span>
	

	<a ng-click="downs()" class="rate-btn down">
		<img src="/images/app/iconDown.png" width="25" height="25">
	</a>
	<span ng-init="question.downs = {{$question->downs}}">{ question.downs }</span>
	</div>


	<hr/>
	<h2>Adwises</h2><ve/><br/>
	<?php 
		if(isset($question->advices)){
			foreach($question->advices as $advice){
	?>
			<div ng-controller="AdviceController">
				<div>
					<input type="hidden" id="advice_id" ng-init="advice.id = {{ $advice['_id'] }}" />
					
					<?php if(!isset($advice['user']['facebook_id'])) { ?>
					<img src="/thumbnails/{{$advice['user']['image_url']}}"  width="50" height="50" id="advice-image" />
					<?php } else { ?>
					<img src="http://graph.facebook.com/{{ $advice['user']['facebook_id'] }}/picture?type=square" id="advice-image" width="50" height="50" />
					<?php } ?>

					<div id="question-advice">
						<b>{{ $advice['user']['username']; }}</b><br/>
						<input type="hidden" ng-init="rating_enable_advice = <?php if(Auth::check() && Auth::user()->_id != $advice['user']['user_id']) echo 1; else echo 0;?>" /> 
						
						{{ $advice['text'] }}<br/><br/>
						<?php if($advice['approved']) {
						?>
							<img src="/images/app/iconSolved.png" class="solved" width="35px;" height="35px;" />
						<?php 
							}
						?>
					</div>
					
					<span>{{ $advice['created_at']; }}</span>
					<br/><br/>
					@if(Auth::check() && Auth::user()->_id == $question->user["user_id"] && $advice['approved'] == false)
						<input type="button" class="btn btn-primary" value="Approve" onclick="location.href='/advices/approve/{{ $question->_id }}/{{ $advice['_id'] }}'">
						
					@endif
					<div class="rating">
						<a ng-click="adviceUps(advice.id)" class="rate-btn">
							<img src="/images/app/iconUp.png" width="25" height="25">
						</a>
						<span ng-init="advice.ups = {{$advice['ups']}}">{ advice.ups }</span>
						

						<a ng-click="adviceDowns()" class="rate-btn down">
							<img src="/images/app/iconDown.png" width="25" height="25">
						</a>
						<span ng-init="advice.downs = {{$advice['downs']}}">{ advice.downs }</span>
					</div>
				</div>
			</div>
			<hr/>

	<?php 
			}
		}
	?>
</div>

<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>



@stop