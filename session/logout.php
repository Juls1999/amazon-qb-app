<?php
    session_start();

    //destroying all sessions and redirect user to login page
    session_destroy();
    header("location:/amazon-q");

?>