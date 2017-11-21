<?php
class htmltable{
    public static function Atable($input){
       
        $table = htmltag:: tablestart();
        foreach ($input as $row =>$line){
            $table.= htmltag:: rowstart();
            foreach ($line as $inrow =>$value){
                $table.=htmltag::tablehead($inrow);
            }
            $table.=htmltag:: rowend();
            break 1;
        }
        foreach ($input as $row =>$line){
            $table.= htmltag:: rowstart();
            foreach ($line as $inrow =>$value){
                $table.=htmltag::tabledata($value);
            }
            $table.=htmltag:: rowend();
        }
        $table .= htmltag::tableend();
        return $table;   

    }

}


?>