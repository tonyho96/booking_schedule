<?php
// Config your Caspio Data here
return [
  //old_account
  // 'config' => [
  //   'TokenEndpointURL' => 'https://c0acj698.caspio.com/oauth/token',
  //   'ResourceEndpointURL'  => 'https://c0acj698.caspio.com/rest/v1',
  //   'ClientID' => 'a94068ab303b49a5f5876487d359003dd96d047bd91e245298',
  //   'ClientSecrect' => '1ddb7b64aa574a88ad15be9e535ebed4e599c495b9d618887f'
  // ],
  //
  //new_account
//  'config' => [
//    'TokenEndpointURL' => 'https://c5eib672.caspio.com/oauth/token',//change
//    'ResourceEndpointURL'  => 'https://c5eib672.caspio.com/rest/v1', //only change https://c0acj699.caspio.com
//    'ClientID' => '263707b5d4554445fb086a65167dac322e1684e94b6bea58da', //change
//    'ClientSecrect' => '6a185dbe179f47d5bed8b9f7d554ae3ba1dc0454e9e91e25f0'//change
//  ],

    //db test BS-46
	//glorucodeBS46@mailinator.com Abc123654
    'config' => [
        'TokenEndpointURL' => 'https://c0aca704.caspio.com/oauth/token',//change
        'ResourceEndpointURL'  => 'https://c0aca704.caspio.com/rest/v1', //only change https://c0acj699.caspio.com
        'ClientID' => 'd47b1dcf1ce94615abe866c1a148e6ae303ec4ecb936011698', //change
        'ClientSecrect' => '5db4c5a3a4054e5dbae3a4b00721439ee755340ac9776be4bc'//change
    ],

  'table' =>[
    'schedules' =>'schedules',
    'bookings' => 'bookings',
    'projects' => 'projects',
    'resources' => 'resources',
    'status' => 'status',
    'booking_resources' => 'booking_resources',
	'Staff' => 'Staff',
  ]
];
