<?php
class ControllerClass {
    private $Text;
    private $Variables = array();
    public $Content = array();

    public function __construct() {


    }

    public function setText($value) {
        $this->Text = $value;
    }

    public function getText() {
        return $this->Text;
    }

    public function appendVariable($key, $value) {
        $this->Variables[$key] = $value;
    }

    public function getVariable($key) {
        return $this->Variables[$key];
    }

    public function getVariables() {
        return array_merge($this->Variables, $this->Content);
    }
};
?>
