<?php

namespace Tnt\ExternalApi\Http;

class ValidationData
{
    public $fields = [];

    /**
    * @param string $field
    * @param string $error
    * @return $this
    */
    public function addError($field, $error) {
        if (!isset($this->fields[$field])) {
            $this->fields[$field] = [];
        }

        $this->fields[$field][] = $error;

        return $this;
    }

    public function toArray() {
        return $this->fields;
    }
}
