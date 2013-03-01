<?php
echo "<html><head><title>Index</title></head><body>\n<ul>\n";
$cdir = scandir(".");
foreach ($cdir as $key => $file) {
        if ($file == "." || $file == ".git" || $file == ".gitattributes" || $file == "img" || $file == "index.php")
            continue;
        if (strstr($file, "inline"))
            $ext = "?id=SELECT+name+FROM+users";
        else if (strstr($file, "get_"))
            $ext = "?id=1";
        else
            $ext = "";
        echo "<li><a href=\"" . $file . $ext . "\">" . $file . $ext . "</a></li>\n";
    closedir($dh);
}
echo "</ul>\n</body></html>";
?>
