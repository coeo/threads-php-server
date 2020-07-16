<?php

class HtmlView extends ApiView {
    public function render($content) {
        header('Content-Type: text/html; charset=utf-8');
        echo $content;
        return true;
    }
}
