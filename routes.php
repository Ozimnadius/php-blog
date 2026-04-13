<?php

return (function(){
	$intGT0 = '[1-9]+\d*';

	return [
		[
			'test' => '/^$/',
			'controller' => 'category/all'
		],
    [
      'test' => "/^article\/($intGT0)\/?$/",
      'controller' => 'article/one',
      'params' => ['id' => 1]
    ],
		[
			'test' => '/^article\/add\/?$/',
			'controller' => 'article/add'
		],
    [
      'test' => "/^article\/edit\/($intGT0)\/?$/",
      'controller' => 'article/edit',
      'params' => ['id' => 1]
    ],
    [
      'test' => "/^article\/delete\/($intGT0)\/?$/",
      'controller' => 'article/delete',
      'params' => ['id' => 1]
    ],
    [
      'test' => "/^category\/($intGT0)\/?$/",
      'controller' => 'category/one',
      'params' => ['id' => 1]
    ],
    [
      'test' => '/^category\/add\/?$/',
      'controller' => 'category/add'
    ],
    [
      'test' => "/^category\/edit\/($intGT0)\/?$/",
      'controller' => 'category/edit',
      'params' => ['id' => 1]
    ],
    [
      'test' => "/^category\/delete\/($intGT0)\/?$/",
      'controller' => 'category/delete',
      'params' => ['id' => 1]
    ],
		[
			'test' => '/^contacts\/?$/',
			'controller' => 'contacts'
		],
    [
      'test' => '/^login\/?$/',
      'controller' => 'auth/login'
    ],
    [
      'test' => '/^register\/?$/',
      'controller' => 'auth/register'
    ],
    [
      'test' => '/^logout\/?$/',
      'controller' => 'auth/logout'
    ],
	];
})();