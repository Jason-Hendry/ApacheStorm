<?php

// Kitty Hyperlink Setting - (((https?|ftp):\/\/)|www\.)(([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)|localhost|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(aero|asia|biz|cat|com|coop|info|int|jobs|mobi|museum|name|net|org|post|pro|tel|travel|xxx|edu|gov|mil|[a-zA-Z][a-zA-Z]))(:[0-9]+)?((\/|\?)[^ "]*[^ ,;\.:">)])?|phpstorm://[^ ]*

$in = fopen("php://stdin",'r');
$out = fopen("php://stdout",'w');

$colors = [
    'white' => '0;37',
    'grey' => '1;30'
];

function color($str, $color) {
    global $colors;
    return "\033[".$colors[$color]."m".$str."\033[0m";
}

while($line = fgets($in, 50000)) {
    // $lines = explode("\n", $buffer);
    $width = exec('tput cols');
    //foreach($lines as $line) {
    $line = trim($line);
    $line = preg_replace('/, referer:.*$/', '', $line);
        $line = preg_replace("/^(\[.*?\]) (\[.*?\]) (\[.*?\]) (\[.*?\]) /", '$2 $3',$line);
        $line = str_replace('#0',' - 0', $line);
        $line = preg_replace("/\\\\n#([1-9])/", "\n - $1", $line);

        $line = preg_replace('#/var/www/(.+)\(([0-9]+)\):\s*#','phpstorm:///w:/$1:$2 ', $line);

        $newLines = explode("\n", $line);
        foreach($newLines as $nline) {
            $color = 'white';
            if(strpos($nline, '/vendor') || strpos($nline, '/library/Zend')) {
                $color = 'grey';
            }
            if(strpos($nline,' - ') === 0) {
                $start = substr($nline,0,5);
                $parts = explode("\n", rtrim(chunk_split(substr($nline,5), $width - 5)));
                $nline = $start.implode("\n     ", $parts);
            }
            fwrite($out, color($nline,$color)."\n");
        }
        fwrite($out, "\n");
    //}
}
