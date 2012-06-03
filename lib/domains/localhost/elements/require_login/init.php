<?php
    global $Session;
    
    $user_id = $Session->get('user_id', '');
    
    if (!$user_id) {
        redirect(url('login'));
    }
    