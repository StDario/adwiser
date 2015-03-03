@extends('layout')

@section('scripts')
	{{HTML::script('js/home.js')}}
    {{HTML::script('js/index.js')}}
    {{HTML::script('js/quick-question.js')}}
@stop

@section('content')

	<div id="container-home" class="grid-100 grid-parent paragraphs-container">
    	<div class="grid-66 white" ng-controller="UserController" id="home">
    		
    		<nav class="grid-100 mobile-grid-100 white">
				<ul id="menu-container" >
					<!--<li ng-class="questions_active"><a ng-click="redirect('questions')">Question</a></li>
					<li ng-class="reviews_active"><a ng-click="redirect('reviews')">Review</a></li> -->
					<li ng-class="questions_active"><a ui-sref="questions">Questions</a></li>
					<li ng-class="reviews_active"><a ui-sref="reviews">Reviews</a></li>
				</ul>

			</nav>
    		<div ui-view class="view-container">
    			
    		</div>
    	</div>
        <script type="text/javascript">
            angular.bootstrap(document.getElementById('home'), ['home']);
        </script>
    	<div class="grid-33" style="float: right;">
    		
    	@if(Auth::check())
    		<div class="white" id="quick-question" ng-controller="QuickQuestionController">
    			<form ng-submit="quickSubmit()" class="form-quick-submit">
                	<h3>Ask a quick question</h3>
    				<input type="text" class="form-control" placeholder="Title" ng-model="quick.title" name="quick-title" /><br/><br/>
    				<textarea class="form-control" placeholder="Question" ng-model="quick.question_text" 
                                name="quick-question-text" rows="3" style="resize: none;" ></textarea>
    				<input type="submit" class="btn btn-primary" value="Ask" />
    			</form>	
                <span ng-show="quickSuccess">Success!</span>
    		</div>
            <script type="text/javascript">
                angular.bootstrap(document.getElementById('quick-question'), ['quickquestion']);
            </script>
    	@endif


    		<div id="tags" ng-controller="TagCtrl" class="white tags-section">
            
                <h3>Popular tags</h3>
                <div class="tags-container">
                        <div id="tag" ng-repeat="tag in tags" >
                            <a href="{{ URL::to('search-tags') }}/{tag}">#{tag}</a>
                        </div>
                    
                </div>
            </div>
            <script type="text/javascript">
                angular.bootstrap(document.getElementById('tags'), ['index']);
            </script>
            <script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>



<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=157980984393269";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

    	</div>
    </div>

@stop