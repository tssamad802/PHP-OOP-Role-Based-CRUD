<?php
require_once 'config.session.inc.php';
class view
{
    public function display_errors($key = 'errors')
    {
        if (isset($_SESSION[$key])) {
            $errors = $_SESSION[$key];
            echo "<br>";
            echo "<br>";
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>" . $error . "</div>";
            }
        }
        unset($_SESSION[$key]);
    }
}
?>