<?php
/**
 * Created by EngrNaveed.
 * Date: 01-Jan-15
 * Time: 3:28 PM
 */
class File{
    public $path;

    function __construct($path){
        $this->path = $path;
    }

    function setContent($text){
        return file_put_contents($this->path, $text);
    }

    function append($text){
        $content = $this->getContent();
        $content .= $text;
        return $this->setContent($content);
    }

    function prepend($text){
        $content = $text;
        $content .= $this->getContent();
        return $this->setContent($content);
    }

    function getContent(){
        return file_get_contents($this->path);
    }

    function clearContent(){
        return $this->setContent("");
    }

    static function delete($path){
        return unlink($path);
    }

}
