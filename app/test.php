<?php

$rules = array(
    'email' => 'email|unique:users,email',
    'password' => 'min:6'
);