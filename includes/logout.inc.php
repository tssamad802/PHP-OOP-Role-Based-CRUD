<?php
require_once 'config.session.inc.php';
session_destroy();
session_unset();
header(header: "Location: ./login");
?>