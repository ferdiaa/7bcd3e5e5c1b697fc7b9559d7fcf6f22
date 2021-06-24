<?php 
 
include "koneksi.php";
$query = mysqli_query($koneksi,"SELECT * FROM tesmkm");

/*function get_tree($name= "root", $data, $parent_id, $depth){
    if ($depth > 1000) return '';
    $tree = str_pad(' ',$depth);
    for($i=0, $ni=count($data); $i < $ni; $i++) {
        if($data[$i]['parent_id'] == $parent_id){
            $tree .= '<ul>'.PHP_EOL;
            $tree .= str_pad(' ',$depth+2);
            $tree .= '<li>';
            $tree .= '<span>' . $data[$i]['name'] . '</span>';
            $tree .= '</li>'.PHP_EOL;
            $tree .= get_tree($data, $data[$i]['id'], $depth+1);
            $tree .= '</ul>'.PHP_EOL;
        }
    }
    $tree .= str_pad(' ',$depth);
    return $tree;
} */

function get_tree($name = 'noot', $clean_path = '', $title = '')
{
    $tree = array();
    $ignore = array('config.json', 'cgi-bin', '.', '..');
    $dh = @opendir($path);
    $index = 0;
    // Build array of paths
    $paths = array();
    while (false !== ($file = readdir($dh))) {
        $paths[$file] = $file;
    }
    // Close the directory handle
    closedir($dh);
    // Sort paths
    sort($paths);
    // Loop through the paths
    // while(false !== ($file = readdir($dh))){
    foreach ($paths as $file) {
        // Check that this file is not to be ignored
        if (!in_array($file, $ignore)) {
            $full_path = "{$path}/{$file}";
            $clean_sort = clean_sort($file);
            $url = $clean_path . '/' . $clean_sort;
            $clean_name = clean_name($clean_sort);
            // Title
            if (empty($title)) {
                $full_title = $clean_name;
            } else {
                $full_title = $title . ': ' . $clean_name;
            }
            if (is_dir("{$path}/{$file}")) {
                // Directory
                $tree[$clean_sort] = array('type' => 'folder', 'name' => $clean_name, 'title' => $full_title, 'path' => $full_path, 'clean' => $clean_sort, 'url' => $url, 'tree' => get_tree($full_path, $url, $full_title));
            } else {
                // File
                $tree[$clean_sort] = array('type' => 'file', 'name' => $clean_name, 'title' => $full_title, 'path' => $full_path, 'clean' => $clean_sort, 'url' => $url);
            }
        }
        $index++;
    }
    return $tree;
}

?>