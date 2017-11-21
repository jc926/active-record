<?php

class htmltag{
    public static function htmlstart(){
        return '<html>';
    }
    public static function htmlend(){
        return '</html>';
    }    

    public static function tablestart(){
        return '<table style = "width:100%" border = "1">';
    }
    public static function tableend(){
        return '</table><hr>';
    }
    public static function headstart(){
        return '<th>';
    }
    public static function headend(){
        return '</th>';
    }
        public static function rowstart(){
        return '<tr>';
    }
    public static function rowend(){
        return '</tr>';
    }
    public static function tabledata($data){
        return '<td>'.$data. '</td>';
    }    
    public static function bodystart(){
        return '<body>';
    }
    public static function bodyend(){
        return '</body>';
    }
}

?>