<?php

class Form {
    private $type;
    private $buffer = "";

    public function __construct($type, $action, $method) {
        switch ($type) {
            case "two_columns":
                $this->type = 1;
                break;
        };

        $this->buffer.= "<form action=\"" . $action . "\" method=\"" . $method . "\">";
    }

    private function inputField($type, $name, $value = "", $id = "", $class = "") {
        $this->buffer.= "<input type=\"" . $type . "\" name=\" . $name . \" value=\"" . $value . "\"";
        if ($id != "")
            $this->buffer.= " id=\"" . $id . "\"";
        if ($class != "")
            $this->buffer.= " class=\"" . $class . "\"";
        $this->buffer.= " />";
    }

    public function addText($label, $name, $value = "", $id = "", $class = "") {
        $this->inputField("text", $name, $value, $id, $class);
    }

    public function addHidden($label, $name, $value = "") {
        $this->inputField("hidden", $name, $value);
    }

    public function addButton($label, $name, $value = "", $id = "", $class = "") {
        $this->inputField("button", $name, $value, $id, $class);
    }

    public function addSubmit($label, $name, $value = "", $id = "", $class = "") {
        $this->inputField("submit", $name, $value, $id, $class);
    }

    public function addTextarea($label, $name, $value = "", $id = "", $class = "") {
        $this->buffer.= "<textarea name=\"" . $name . "\"";
        if ($id != "")
            $this->buffer.= " id=\"" . $id . "\"";
        if ($class != "")
            $this->buffer.= " class=\"" . $class . "\"";
        $this->buffer.= ">" . $value . "</textarea>";
    }

    public function getForm() {
        return $this->buffer . "</form>";
    }

};