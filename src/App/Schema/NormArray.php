<?php

namespace App\Schema;

class NormArray extends \Norm\Schema\Field {
    function prepare($value) {
        return explode("\r\n", $value);
    }
}