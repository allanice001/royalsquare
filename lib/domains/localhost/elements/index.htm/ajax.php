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
        '<div id="toolbardiv" style="width: 650px;">'.
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
        echo '<p></p>'.
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
    
    if ($rand8) {//loadusers
        $rs_users = $DB->query('SELECT id, username FROM sec_users');
        while($users = $rs_users->next()) {
            echo '<option value="'. $users['id'] .'">'. $users['username'] .'</option>';
        }
    }
    
    if ($rand9) {//loadcollectioncustomers
        $html = '<tr><td></td><th>5Kg</th><th>9Kg</th><th>12Kg</th><th>14Kg</th><th>19Kg</th><th>48Kg</th><th>Reference</th></tr>';
        $rs_customers = $DB->query('SELECT * FROM customers');
        while($customers = $rs_customers->next()) {
            $html .=
            '<tr>'.
            '<th>'. $customers['name'] .'</th>'.
            '<td><input type="text" id="['. $customers['id'] .'][5kg]"  name="['. $customers['id'] .'][5kg]" size="4" /></td>'.
            '<td><input type="text" id="['. $customers['id'] .'][9kg]"  name="['. $customers['id'] .'][9kg]" size="4" /></td>'.
            '<td><input type="text" id="['. $customers['id'] .'][12kg]" name="['. $customers['id'] .'][12kg]" size="4" /></td>'.
            '<td><input type="text" id="['. $customers['id'] .'][14kg]" name="['. $customers['id'] .'][14kg]" size="4" /></td>'.
            '<td><input type="text" id="['. $customers['id'] .'][19kg]" name="['. $customers['id'] .'][19kg]" size="4" /></td>'.
            '<td><input type="text" id="['. $customers['id'] .'][48kg]" name="['. $customers['id'] .'][48kg]" size="4" /></td>'.
            '<td><select name="user_id" >';
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
    
    if ($rand10) {
        print_pre($_POST);
    }