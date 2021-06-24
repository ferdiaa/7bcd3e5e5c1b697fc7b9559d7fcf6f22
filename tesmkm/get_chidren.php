<?php

include "koneksi.php";
$query = mysqli_query($koneksi,"SELECT * FROM tesmkm");

function get_children($name, $parent) {
  foreach ($name as $index=>$one) {
    if ($one["parent"]==$parent) {
      echo "$one[name] is a child of ".$array[$parent]["name"].".<br />\n";
      get_children($array, $index);
    }
  }
}

get_children($array, 0);
?>