<?
    $icon_path = imagePath('icons');
    $rand1 = get('rand1');
    $rand2 = get('rand2');
    $rand3 = get('rand3');
    $rand4 = get('rand4');
    $rand5 = get('rand5');
    
    $id = get('id');
    if ($rand1) {//listusers
        $html = 
        //'<script type="text/javascript">adminbar();</script>'.
        '<table border="1" cellpadding="5" cellspacing="5" style="margin: auto;">'.
        '<tr><td></td><td></td><th>Username</th><th>First Name</th><th>Last Name</th><th>Group</th></tr>';
        $rs_users = $DB->query('SELECT * FROM sec_users WHERE !deleted');
        while ($users = $rs_users->next()) {
            $html .= '<tr>'.
            '<td><input type="checkbox" name="ids[]" id="ids[]" value="'. $users['id'] .'"></td>'.
            '<td><img src="'. $icon_path . ($users['disabled'] ? 'user_delete' : 'user') .'.png" alt="status" onclick="changestatus('. $users['id'] .')"/></td>'.
            '<td onclick="updateuser('. $users['id'] .')">'. $users['username'] .'</td>'.
            '<td>'. $users['first_name'] .'</td>'.
            '<td>'. $users['last_name'] .'</td>'.
            '<td>'. $DB->lookup('SELECT name FROM sec_groups WHERE id='. $users['group_id']) .'</td>'.
            '</tr>';
        }
        $html .= '</table>';
        echo $html;
    }
    
    if ($rand2) {//changestatus
        $status = $DB->lookup('SELECT disabled FROM sec_users WHERE id='. $id);
        $DB->query('UPDATE sec_users SET disabled='. ($status ? '0' : 'UNIX_TIMESTAMP()') .' WHERE id='. $id);
    }
    
    if ($rand3) {
        $ids = get('ids');
        foreach ($ids as $id) {
            $DB->query('UPDATE sec_users SET deleted=UNIX_TIMESTAMP() WHERE id='. $id .';');
        }
    }
    
    if ($rand4) {//updateuser
        $rs_user = $DB->query('SELECT * FROM sec_users WHERE id='.$id);
        while ($user = $rs_user->next()) {
            $html = '<table id="updateuser" border="1" cellpadding="5" cellspacing="5" style="margin:auto;">'.
            '<tr><th>Username:</th><td><input type="text" id="username" name="username" readonly="readonly" disabled="disabled" value="'. $user['username'] .'"></td></tr>'.
            '<tr><th>First Name:</th><td><input type="text" id="first_name" name="first_name" value="'. $user['first_name'] .'" /></td></tr>'.
            '<tr><th>Last Name:</th><td><input type="text" id="last_name" name="last_name" value="'. $user['last_name'] .'" /></td></tr>'.
            '<tr><th>Password:</th><td><input type="password" id="password1" name="password1" /></td></tr>'.
            '<tr><th>Confirm Password:</th><td><input type="password" id="password2" name="password2" /></td></tr>'.
            '</table>'.
            '<input type="button" value="Update User" onclick="uploaduser('. $user['id'] .')" />';
            
        }
        echo $html;
        
    }
    
    if ($rand5) {
        $first_name = get('first_name');
        $last_name = get('last_name');
        $password1 = get('password1');
        $password2 = get('password2');
        if (($password1 && $password2) && ($password1 == $password2)) {
            $DB->query('UPDATE sec_users SET password="'. md5($password1) .'" WHERE id='.$id);
            $html = '<h2>Password Updated</h2>';
        }
        
        $DB->query('UPDATE sec_users SET first_name="'. $first_name .'", last_name="'. $last_name .'" WHERE id='.$id);
        $html .= '<h2>User Updated</h2>';
        echo $html;
    }