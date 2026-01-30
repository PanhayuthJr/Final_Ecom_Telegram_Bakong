<?php
$target = $_SERVER['DOCUMENT_ROOT'].'/../project_files/storage/app/public';
$link = $_SERVER['DOCUMENT_ROOT'].'/storage';

if(file_exists($link)) {
    echo "Link already exists.";
} else {
    // Attempt standard symlink
    if(symlink($target, $link)) {
        echo "Symlink created successfully: $link -> $target";
    } else {
        echo "Failed to create symlink. Ensure permissions are correct.";
    }
}
