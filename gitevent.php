<?php
    // config
    $email = 'guy@barnahum.com'; //not required, but useful for debugging
    $repos = array( 'reactor'=>array( 'path'=>'~/barnahum.com/reactor' ));

    
    //get repo name from post payload or manual test
    if (!empty($_POST['payload'])) {
        $data = json_decode($_POST['payload']);
        $repo = $data->repository->name;
    }
    else if (!empty($_GET['repo'])) {
        $repo = $_GET['repo'];
    }
    else{
        $msg = 'no payload';
        if (!empty($email)) mail($email, 'new commit to unknown', $msg );
        die( $msg );
    }
    
    //sanitize repo name for security
    $repo = escapeshellcmd($repo);
    
    echo $repo . '<br>';
    
    //check that repo name is supported
    if (!array_key_exists($repo, $repos)){
        $msg = ' repo name "' . $name . '" not supported';
        if (!empty($email)) mail($email, 'new commit to ' . $repo, $msg . ' ' . $_POST['payload']);
        die( $msg );
    }
    
    //check that required paths are present in config
    if (empty($repos[$repo]['path']) || empty($repos[$repo]['deploy'])) die('repo path and repo deploy must both be set');
    
    //todo, scan list of deleted files in this commit and delete them
    
    //update git, deploy to directory
    $msg = 'attempting to git pull from ' . $repos[$repo]['path']    ;
    $msg .= exec('whoami;cd ' . $repos[$repo]['path'] . ';git pull' );
    
    //send email if configured
    if (!empty($email)) mail($email, 'new commit to ' . $repo, $msg . ' ' . $_POST['payload']);