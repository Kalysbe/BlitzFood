<?php


class Html {
    private $Buffer = "";

    public function Strong($text) {
        $this->Buffer.= "<strong>" . $text . "</strong>";
    }

    public function Div($text, $id = "", $class = "", $style = "") {
        $this->Buffer.= "<div";
        if ($id != "")
            $this->Buffer.= " id=\"" . $id . "\"";
        if ($class != "")
            $this->Buffer.= " class=\"" . $class . "\"";
        if ($style != "")
            $this->Buffer.= " style=\"" . $style . "\"";
        $this->Buffer.= ">" . $text . "</div>";
    }

    public function Label($text) {
        $this->Buffer = "<label>" . $text . "</label>";
    }

    public function getText() {
        return $this->Buffer;
    }
};