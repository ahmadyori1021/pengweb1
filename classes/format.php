<?php

class format
{
    public function textShorten($text, $limit){
        $text = substr($text, 0, $limit);
        $text = substr($text, 0, strrpos($text, ' '));
        $text = $text."...";
        return $text;
    }

    public function dateFormat($date){
        $time = strtotime($date);
        $new_date = date("D-d-m-Y h:i:s a", $time);
        return $new_date;
    }

    public static function relative_Time($old_time){

        $timeDifference = time() - $old_time;
        $seconds = $timeDifference;
        $minutes = round($timeDifference / 60); // 60
        $hours   = round($timeDifference / 3600); // 60*60
        $days    = round($timeDifference / 86400); // 24*60*60
        $weeks   = round($timeDifference / 604800); // 7*24*60*60
        $months  = round($timeDifference / 2592000); // 30*24*60*60
        $years   = round($timeDifference / 31104000); // 12*30*24*60*60

        if ($seconds < 60){
            if ($seconds < 30){ echo "Just now";}
            else{ echo $seconds." seconds ago."; }
        }elseif ($minutes < 60){
            if ($minutes == 1){ echo "One minute ago."; }
            else{ echo $minutes." minutes ago."; }
        }elseif ($hours < 24){
            if ($hours == 1){ echo "One hour ago."; }
            else{ echo $hours." hours ago."; }
        }elseif ($days < 7){
            if ($days == 1){ echo "One day ago."; }
            else{ echo $days." days ago."; }
        }elseif ($weeks < 4){
            if ($weeks == 1){ echo "One week ago."; }
            else{ echo $weeks." weeks ago."; }
        }elseif ($months < 12){
            if ($months == 1){ echo "One month ago."; }
            else{ echo $months." months ago."; }
        }else{ echo $years." years ago."; }
    }

}