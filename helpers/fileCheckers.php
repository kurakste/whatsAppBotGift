<?php 

// Check is file was loaded && it has allowed format (allawed array) 
// && size (50MB Viber's limit) 
function checkForFile() {
    if (!array_key_exists('payload', $_FILES)) return false;
    if ( $_FILES['payload']['size'] > (50 * 1024 * 1024) ) return false;
    return true;    
}

//Store file & cook up message for sending.
function packFileMessage() {
    $uploaddir = './uploads/';
    $uploadfiile = $uploaddir.$_FILES['payload']['name'];
    if (move_uploaded_file($_FILES['payload']['tmp_name'], $uploadfiile)) {
        $file = 'https://'.$_SERVER['HTTP_HOST'].'/examples/uploads/'.$_FILES['payload']['name'];
        echo $file;
        die;
        $size = $_FILES['payload']['size'];
        $message = (new \Viber\Api\Message\File())
            ->setMedia($file)
            ->setSize($size)
            ->setFileName($_FILES['payload']['name']);
        return $message;
    } else {
        throw new Exception('Error when we try to get file.');
    }
}