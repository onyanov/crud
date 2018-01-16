<?php

class Decorator {

    public static function date($date, $template = 'word') {
        if (!$date || $date == '0000-00-00 00:00:00')
            return '';
        $res = '';
        if ($template == 'word' || $template == 'word_noyear') {
            $months = array("января", "февраля", "марта", "апреля", 
                "мая", "июня", "июля", "августа", 
                "сентября", "октября", "ноября", "декабря");
            $dt = strtotime($date);
            $m = $months[date('m', $dt) - 1];
            $y = $template == 'word_noyear' ? '' : ' ' . date('Y', $dt);
            $res = date('d', $dt) . " " . $m . $y . ', ' . date('H:i', $dt);
        } else
            $res = @date($template, @strtotime($date));
        return $res;
    }

}
