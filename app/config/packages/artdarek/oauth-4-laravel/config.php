<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => '157980984393269',
            'client_secret' => 'e4b4706a6510387571916c9f58293cf5',
            'scope'         => array('email','read_friendlists','user_online_presence'),
        ),
        
        'Twitter' => array(
        	'client_id' => 'VDS2KCscKyzuch5rRxrkg',
        	'client_secret' => 'vEe439gewfchNw6WhjYIDPbvCnEzIeGgsCNJ6JRhI8',
        	'oauth_token' => '1225802222-leTFrhdr547rh9r1MU1N4gbss2jZZVv4c7ZUbnx',
        	'oauth_token_request' => 'GV2avhye7TyLYzDAP3YCWkxSiEcp0Vx69lmDD5hjv743s',
        ),		

        'Google' => array(
		    'client_id'     => '207544995246-q76gh52ieredo1j6keachrfdbg690eu4.apps.googleusercontent.com',
		    'client_secret' => 'MtM52yLcqKv1VT1wwMYopDDv',
		    'scope'         => array('userinfo_email', 'userinfo_profile'),
		    'callbackUrl' => 'http://localhost/'
		),  	

	)

);