<?php

namespace MyApp\Exception;

class DuplicatedEmail extends \Exception {
  protected $message = 'Duplicate Email!';
}