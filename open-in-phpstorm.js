// PhpStorm
var editor = '"c:\\Program Files (x86)\\JetBrains\\PhpStorm 7.1.3\\bin\\PhpStorm.exe" --line "%line%" "%file%"';

var url = WScript.Arguments(0);
var match = /^phpstorm:\/\/\/(.+):(\d+)$/.exec(url);
if (match) {
    var file = decodeURIComponent(match[1]).replace(/\+/g, ' ');
    var command = editor.replace(/%line%/g, match[2]).replace(/%file%/g, file);
    var shell = new ActiveXObject("WScript.Shell");
    shell.Exec(command.replace(/\\/g, '\\\\'));
}