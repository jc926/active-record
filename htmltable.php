<?php
class htmltable{
    public static function Atable($input){
        $table = htmltag:: tablestart();
        foreach ($input as $row =>$line){
            $table.= htmltag:: rowstart();
            foreach ($line as $inrow =>$value){
                $table.=htmltag::tabledata($value);
            }
            $table.=thmltag:: rowend();
        }
        $table = htmltag::tableend();
        return $table;   

    }

}

?>