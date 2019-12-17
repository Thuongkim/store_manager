<?php

return array(
    'customer_not_found'    => 'The customer does not found.',
    'does_not_exist' => 'The customer does not exist.',
    'assoc_users'	 => 'This customer currently has :count items checked out to users. Please check in the accessories and and try again. ',

    'create' => array(
        'error'   => 'The customer was not created, please try again.',
        'success' => 'The customer was successfully created.'
    ),

    'update' => array(
        'error'   => 'The customer was not updated, please try again',
        'success' => 'The customer was updated successfully.'
    ),

    'delete' => array(
        'confirm'   => 'Are you sure you wish to delete this customer?',
        'error'   => 'There was an issue deleting the customer. Please try again.',
        'success' => 'The customer was deleted successfully.'
    ),

     'checkout' => array(
        'error'   		=> 'customer was not checked out, please try again',
        'success' 		=> 'customer checked out successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.'
    ),

    'checkin' => array(
        'error'   		=> 'customer was not checked in, please try again',
        'success' 		=> 'customer checked in successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.'
    )
);
