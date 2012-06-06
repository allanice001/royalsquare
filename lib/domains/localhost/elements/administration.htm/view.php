<?
    $icon_path = imagePath('icons');
?>
<script type="text/javascript">
    listusers = function() {
        $.post("<? echo urlRequest();?>",{rand1:Math.random() }, function(data) {
            $('#return').html(data);
        });    
    };
    changestatus = function(id) {
        $.post("<? echo urlRequest();?>",{id: id, rand2:Math.random() }, function(data) {
            listusers();
        });    
    };
    createuser = function() {
        
    };
    deleteusers = function(ids) {
        $.post("<? echo urlRequest();?>",{ids : ids , rand3:Math.random() }, function(data) {
            listusers();
        });
    };
    
    updateuser = function(id) {
        $.post("<? echo urlRequest();?>",{id : id , rand4:Math.random() }, function(data) {
            $('#return').html(data);
        });
    };
    
    uploaduser = function(id) {
        $.post("<? echo urlRequest();?>",{id: id, first_name: $('#first_name').val(), last_name: $('#last_name').val(), password1:$('#password1').val(), password2:$('#password2').val(), rand5:Math.random() }, function(data) {
            $('#return').html(data);
        });
    };
    
    adminbar = function() {
        $toolbar = new Toolbar('<?php echo $icon_path ?>');
        $toolbar.addButton("Create New User", "user_add.png", "createuser();");
        $toolbar.addDivider();
        $toolbar.addButton("Delete Selected", "user_delete.png", "if (confirm(\"are you sure?\")){ids = new Array;$(\"input:checked\").each(function(id) {myVar = $(\"input:checked\").get(id); ids.push(myVar.value);}); deleteusers(ids);}");
        $toolbar.end();
    }
    listusers();
</script>
<div id="return">
<script type="text/javascript">
    adminbar();
</script>
</div>