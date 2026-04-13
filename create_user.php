<?php
include_once('init.php');

$fields = [
  'email'         => 'test@test.com',
  'password_hash' => password_hash('Test1234', PASSWORD_DEFAULT),
];

addUser($fields);

echo "Пользователь создан!";