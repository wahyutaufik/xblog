<?php
namespace App\Model;

class Entry extends \Norm\Model {
    public function get_tags() {
        return \Norm\Norm::factory('Tags')->findOne($this->attributes['tags']);
    }

    public function get_publisher() {
        return \Norm\Norm::factory('User')->findOne($this->attributes['$created_by']);
    }
}
