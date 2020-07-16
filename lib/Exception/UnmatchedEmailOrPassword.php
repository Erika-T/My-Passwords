<?php

namespace MyApp\Exception;

class UnmatchedEmailOrPassword extends \Exception {
  protected $message = 'Email/Password do not match!';
}