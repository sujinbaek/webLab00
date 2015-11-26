<?php
$SONGS_FILE = "songs.txt";
//$SONGS_FILE = "songs_shuffled.txt";

if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "GET") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - This service accepts only GET requests.");
}

$top = "";

if (isset($_REQUEST["top"])) {
	$top = preg_replace("/[^0-9]*/", "", $_REQUEST["top"]);
}

if (!file_exists($SONGS_FILE)) {
	header("HTTP/1.1 500 Server Error");
	die("ERROR 500: Server error - Unable to read input file: $SONGS_FILE");
}

header("Content-type: application/xml");

print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
print "<songs>\n";


$lines = file($SONGS_FILE);
for($i=1; $i<=$top; $i++){
	for ($j=0; $j<count($lines); $j++) {
		list($title, $artist, $rank, $genre, $time) = explode("|", trim($lines[$j]));
		if ($rank == $i) {
			print "\t<song rank=\"$rank\">\n";
			print "\t\t<title>$title</title>\n";
			print "\t\t<artist>$artist</artist>\n";
			print "\t\t<genre>$genre</genre>\n";
			print "\t\t<time>$time</time>\n";
			print "\t</song>\n";		
		}
	}
}
print "</songs>";

?>
