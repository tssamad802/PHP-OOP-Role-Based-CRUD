<?php
class controller extends model
{
    public function is_empty_inputs($fields = [])
    {
        foreach ($fields as $field) {
            if (empty($field)) {
                return true;
            }
        }
        return false;
    }
}
?>