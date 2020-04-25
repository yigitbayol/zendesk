<?php

Route::get('zendesk', function(){
	echo '<h2>Welcome to Zendesk Package</h2>';
});

Route::post('zendesk/user/create', 'Appricot\Zendesk\ZendeskController@createUser');
Route::get('zendesk/user/get', 'Appricot\Zendesk\ZendeskController@getAllUsers');
Route::post('zendesk/ticket/create', 'Appricot\Zendesk\ZendeskController@createTicket');
