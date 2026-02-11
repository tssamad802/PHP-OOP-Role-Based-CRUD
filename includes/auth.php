<?php
require_once 'config.session.inc.php';
class auth
{
    private $allowed_rules = [];

    public function __construct($roles)
    {
        $this->allowed_rules = $roles;
        $this->handle();
    }

    private function handle()
    {
        $allowed = false;
        foreach ($this->allowed_rules as $role) {
            if (isset($_SESSION[$role])) {
                $allowed = true;
                break;
            }
        }
        if (!$allowed) {
            header("Location: ./login");
            exit;
        }
    }

    public function show_name()
    {
        if (isset($_SESSION['name'])) {
            $show = $_SESSION['name'];
            return $show;
        }
    }

    public function get_id()
    {
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
            return $id;
        }
    }

    public function can_access($roles = [])
    {
        foreach ($roles as $role) {
            if (isset($_SESSION[$role])) {
                return true;
            }
        }
    }
}
?>