<?php
    date_default_timezone_set('Europe/Istanbul');
    session_start();
    ob_start();
    session_destroy();
    header("Refresh: 0; url=.");