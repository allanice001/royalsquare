<?php
    $icon_path = imagePath('icons');
    $image_path = imagePath('elements/' . $System['element']['name']);
    $rand1 = get('rand1');
    $rand2 = get('rand2');
    $rand3 = get('rand3');
    $rand4 = get('rand4');
    $rand5 = get('rand5');
    $rand6 = get('rand6');
    $rand7 = get('rand7');
    $rand8 = get('rand8');
    $rand9 = get('rand9');
    $rand10 = get('rand10');
    
    $legrand1 = get('legrand1');
    $legrand2 = get('legrand2');
    $legrand3 = get('legrand3');
    
    $q = get('q');
    $id = get('id', 0);
    
    if ($rand1) {//searchdistrib
        if ($q) {
            $rs_query = $DB->query('SELECT * FROM distributors WHERE !disabled AND !deleted AND ' . $DB->whereLike($q, array('name', 'address')) .' ORDER BY name');
        } else {
            $rs_query = $DB->query('SELECT * FROM distributors WHERE !disabled AND !deleted ORDER BY name');
        }
        $html = 
        '<ul class="MenuBarVertical">';
        while ($query = $rs_query->next()) {
            $html .= '<div class="liclass"><li><span onclick="launch('. $query['id'] .')">'. $query['name'] .'</span><div class="delclass"><img src="'. $icon_path .'delete.png" onclick="deletedistrib('. $query['id'] .')"/></div></li></div>';
        }
        $html .= '</ul>';
        echo $html;
    }
    
    if ($rand2) { //showdistrib
        $name = $DB->lookup('SELECT name FROM distributors WHERE id='. $id);
        $address = $DB->lookup('SELECT address FROM distributors WHERE id='. $id);
        $name = str_replace(array("\r", "\n"), '', $name);
        $address = urlencode($address);
        echo 
        '<table border="0" cellpadding="5" cellspacing="5" id="distribtable">'.
        '<tr>'.
            '<th>Distributor:</th><td id="distribtd">'. $name .'</td>'.
        '</tr>'.
        '<tr>'.
            '<th>Address:</th><td id="addresstd">'. urldecode($address) .'</td>'.
        '</tr>'.
        '<tr><td colspan=100%" id="buttontd"><input type="button" onclick="changedistrib(\''. $id .'\', \''. $name .'\', \''. $address .'\')" value="Change Distriburor ..." /></td></tr>'.
        '</table>'.
        '<hr />'.
        '<div id="toolbardiv">'.
        '<ul id="menu">
            <li><span onclick="loadcollections(\''. $id .'\')">Collections</span></li>
            <li><span onclick="loadinvestgate(\''. $id .'\')">Investigations</span></li>
            <li><span onclick="loadlegal(\''. $id .'\')">Legal</span></li>
        </ul>'.
        '</div>'.
        '<div id="loadreturn">'.
        '</div>';
    }
    
    if ($rand3) { //updatedistrib
        $distrib = get('distrib');
        $address = get('address');
        $DB->query('UPDATE distributors SET name="'. $distrib .'", address="'. $address .'" WHERE id='.$id);
        
    }

    if ($rand4) { //deletedistrib
        $DB->query('UPDATE distributors SET deleted=UNIX_TIMESTAMP() where id='. $id);
    }
    
    if ($rand5) {//uploaddistrib
        $distrib = get('distrib');
        $address = get('address');
        $DB->query('INSERT INTO distributors (name, address) VALUES ("'. $distrib .'", "'. $address .'")');
    }
    
    if ($rand6) {//uploadnote
        $note = get('note');
        $DB->query('INSERT INTO notes (note) VALUE ("'. $note .'")');
    }
    
    if ($rand7) {//lookupcollections
        echo '<p><hr /></p>'.
        '<p><strong>Historic Data</strong></p>'.
        '<table border="2" cellspacing="5" cellpadding="5" style="margin:auto;">'.
        '<tr><th>Customer Name</th><th>5Kg</th><th>9Kg</th><th>12Kg</th><th>14Kg</th><th>19Kg</th><th>48Kg</th><th>Collected</th><th>Reference</th></tr>';
        $rs_query = $DB->query('SELECT * FROM collections WHERE distid='. $id);
        while ($query = $rs_query->next()) {
            echo '<tr>'.
            '<th>'. $DB->lookup('SELECT name FROM customers WHERE id='. $query['custid']) .'</th>'.
            '<td>'. $query['5kg'] .'</td>'.
            '<td>'. $query['9kg'] .'</td>'.
            '<td>'. $query['12kg'] .'</td>'.
            '<td>'. $query['14kg'] .'</td>'.
            '<td>'. $query['19kg'] .'</td>'.
            '<td>'. $query['48kg'] .'</td>'.
            '<td>'. date('d M Y', $query['dts']) .'</td>'.
            '<td>'. $DB->lookup('SELECT username FROM sec_users WHERE id='. $query['user_id']) .'</td>'.
            '</tr>';
        }
        echo '</table>'.
        '<input type="button" onclick="" value="Add Collections Data"';
    }
    
    if ($rand8) {//uploadcollectionnotes
        $date = get('date');
        $task = get('task');
        $collectionnotes = get('collectionnotes');
        if ($date) {
            $date = explode('/',$date);
            $date = mktime(0,0,0,$date['0'], $date['1'], $date['2']);
        } else {
            $date = mktime();
        }
    
        $DB->query('INSERT INTO collectionnotes (dist_id, task, dts, note) VALUES ('. $id .', '. ($task ? $date : '0') .', '. $date .', "'. $collectionnotes .'")');
    }
    
    if ($rand9) {//loadcollectioncustomers
        $html = '<tr><td></td><th>5Kg</th><th>9Kg</th><th>12Kg</th><th>14Kg</th><th>19Kg</th><th>48Kg</th><th>Reference</th></tr>';        
        $rs_customers = $DB->query('SELECT * FROM customers');
        while($customers = $rs_customers->next()) {
            $html .=
            '<tr>'.
            '<th>'. $customers['name'] .'</th>'.
            '<td><input type="text" id="'. $customers['id'] .'_5kg"  name="'. $customers['id'] .'_5kg"  value="0" size="4" /></td>'.
            '<td><input type="text" id="'. $customers['id'] .'_9kg"  name="'. $customers['id'] .'_9kg"  value="0" size="4" /></td>'.
            '<td><input type="text" id="'. $customers['id'] .'_12kg" name="'. $customers['id'] .'_12kg" value="0" size="4" /></td>'.
            '<td><input type="text" id="'. $customers['id'] .'_14kg" name="'. $customers['id'] .'_14kg" value="0" size="4" /></td>'.
            '<td><input type="text" id="'. $customers['id'] .'_19kg" name="'. $customers['id'] .'_19kg" value="0" size="4" /></td>'.
            '<td><input type="text" id="'. $customers['id'] .'_48kg" name="'. $customers['id'] .'_48kg" value="0" size="4" /></td>'.
            '<td><select name="'. $customers['id'] .'_user_id" id="'. $customers['id'] .'_user_id" >';
            $rs_users = $DB->query('SELECT id, username FROM sec_users');
            while($users = $rs_users->next()) {
                $html .= '<option value="'. $users['id'] .'">'. $users['username'] .'</option>';
            }
            $html .=
            '</select></td>'.
            '</tr>';
        }
        echo $html;
    }
    
    if ($rand10) {//uploadcollections
        //print_pre($_POST);
        $date = get('date');
        $c1_5kg = get('c1_5kg');
        $c2_5kg = get('c2_5kg'); 
        $c3_5kg = get('c3_5kg'); 
        $c4_5kg = get('c4_5kg'); 
        $c1_9kg = get('c1_9kg'); 
        $c2_9kg = get('c2_9kg'); 
        $c3_9kg = get('c3_9kg'); 
        $c4_9kg = get('c4_9kg'); 
        $c1_12kg = get('c1_12kg');
        $c2_12kg = get('c2_12kg');
        $c3_12kg = get('c3_12kg');
        $c4_12kg = get('c4_12kg');
        $c1_14kg = get('c1_14kg');
        $c2_14kg = get('c2_14kg');
        $c3_14kg = get('c3_14kg');
        $c4_14kg = get('c4_14kg');
        $c1_19kg = get('c1_19kg');
        $c2_19kg = get('c2_19kg');
        $c3_19kg = get('c3_19kg');
        $c4_19kg = get('c4_19kg');
        $c1_48kg = get('c1_48kg');
        $c2_48kg = get('c2_48kg');
        $c3_48kg = get('c3_48kg');
        $c4_48kg = get('c4_48kg');
        $c1_user_id = get('c1_user_id');
        $c2_user_id = get('c2_user_id');
        $c3_user_id = get('c3_user_id');
        $c4_user_id = get('c4_user_id');
        if ($date) {
            $date = explode('/',$date);
            $date = mktime(0,0,0,$date['0'], $date['1'], $date['2']);
        } else {
            $date = mktime();
        }
        if ($c1_5kg || $c1_9kg || $c1_12kg || $c1_14kg || $c1_19kg || $c1_48kg) {//Afrox
            $DB->query('INSERT INTO collections (custid, 5kg, 9kg, 12kg, 14kg, 19kg, 48kg,  dts, distid, user_id) VALUES (1, '. $c1_5kg .', '. $c1_9kg .', '. $c1_12kg .', '. $c1_14kg .', '. $c1_19kg .', '. $c1_48kg .', '. $date .', '. $id .', '. $c1_user_id .')');
        }
        
        if ($c2_5kg || $c2_9kg || $c2_12kg || $c2_14kg || $c2_19kg || $c2_48kg) {
            $DB->query('INSERT INTO collections (custid, 5kg, 9kg, 12kg, 14kg, 19kg, 48kg,  dts, distid, user_id) VALUES (2, '. $c2_5kg .', '. $c2_9kg .', '. $c2_12kg .', '. $c2_14kg .', '. $c2_19kg .', '. $c2_48kg .', '. $date .', '. $id .', '. $c2_user_id .')');
        }
        
        if ($c3_5kg || $c3_9kg || $c3_12kg || $c3_14kg || $c3_19kg || $c3_48kg) {
            $DB->query('INSERT INTO collections (custid, 5kg, 9kg, 12kg, 14kg, 19kg, 48kg,  dts, distid, user_id) VALUES (3, '. $c3_5kg .', '. $c3_9kg .', '. $c3_12kg .', '. $c3_14kg .', '. $c3_19kg .', '. $c3_48kg .', '. $date .', '. $id .', '. $c3_user_id .')');
        }
        
        if ($c4_5kg || $c4_9kg || $c4_12kg || $c4_14kg || $c4_19kg || $c4_48kg) {
            $DB->query('INSERT INTO collections (custid, 5kg, 9kg, 12kg, 14kg, 19kg, 48kg,  dts, distid, user_id) VALUES (4, '. $c4_5kg .', '. $c4_9kg .', '. $c4_12kg .', '. $c4_14kg .', '. $c4_19kg .', '. $c4_48kg .', '. $date .', '. $id .', '. $c4_user_id .')');
        }
    }
    
    if ($legrand1) {//lookuplegal
        //print_pre($_POST);
        $html = '<table border="1" cellpadding="5" cellspacing="5" style="margin:auto;">'.
        '<tr><th>Customer</th><th>Attached File</th><th>Date</th></tr>';
        $rs_notes = $DB->query('SELECT * FROM legalnotes WHERE dist_id='.$id);
        while ($notes = $rs_notes->next()) {
            $html .= '<tr>'.
            '<td onclick="loadlegalnote('. $notes['id'] .')">'. $DB->lookup('SELECT name FROM customers WHERE id='. $notes['cust_id']) .'</td>'.
            '<td>'. ($notes['file_id']? $DB->lookup('SELECT uploadname FROM legalfiles where id='. $notes['file_id']) : 'No') .'</td>'.
            '<td>'. date('d M Y', $notes['dts']) .'</td>'.
            '</tr>';
        }
        $html .= '</table>';
        echo $html;
        
    }
    
    if ($legrand2) {//loadlegalnote
        $html = '<table border="1" cellpadding="5" cellspacing="5" style="margin:auto;">';
        $rs_notes = $DB->query('SELECT * FROM legalnotes WHERE id='.$id);
        while ($notes = $rs_notes->next()) {
            $html .= '<tr><th>Customer: </th><td><select id="cust_id">';
            $rs_customers = $DB->query('SELECT * FROM customers');
            while ($customers = $rs_customers->next()) {
                $html .= '<option value="'. $customers['id'] .'" '. ($customers['id'] == $notes['cust_id'] ? ' selected="selected"' : '') .' >'. $customers['name'] .'</option>';
            }
            $html .= '</select></td></tr>'.
                '<tr><th>Notes: </th><td><textarea id="notes" name="notes" rows="10" cols="60">'. $notes['notes'] .'</textarea></td></tr>';
        }
        $html .= '<tr><th>File: </th><td><input type="file" id="file" name="file"</td></tr>'.
        '</table>'.
        '<input type="button" value="Update Note" onclick="uploadlegal('. $notes['id'] .')" />';
        echo $html;
    }
    
    if ($legrandrand3) {//uploadlegal
        
    }