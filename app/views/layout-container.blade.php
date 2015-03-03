@extends('layout')

@section('scripts')
	{{HTML::script('js/home.js')}}
	{{HTML::script('js/angular-route.min.js')}}
	{{HTML::script('js/angular-ui-router.min.js')}}
	
    @yield('scripts')
@stop

@section('content')

	<div id="container-home" class="grid-100 grid-parent paragraphs-container" >
    	<div class="grid-66 white" id="content-container">
    		
            @yield('content-container')

    	</div>
    	<div class="grid-33" style="float: right;" >
    		{{HTML::script('js/quick-question.js')}}
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
                <script type="text/javascript">
                    angular.bootstrap(document.getElementById('quick-question'), ['quickquestion']);
                </script>
    		</div>
            
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

           
    	</div>
    </div>

@stop