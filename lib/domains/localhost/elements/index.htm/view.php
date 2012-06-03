<?
    $image_path = imagePath('icons');
    $icon_path = imagePath('icons');
?>
<script type="text/javascript">
$(document).ready(function()
{   
    $("#search").focus();
	$("#search").submit(function()
	{
		$.get("<? echo urlRequest(); ?>",{ q:$('#q').val(),rand1:Math.random() } ,function(data)
        {
            if(data) {
                $('#result').html(data);
            }		
        });
 		return false;
	});
     
	$("#q").keyup(function() {
	   $("#search").trigger('submit');
    });

    $("#search").trigger('submit');       
});

launch = function(id) {
    $.post("<? echo urlRequest();?>",{id:id, rand2:Math.random() }, function(id)
    {
        $('#return').html(id);
    });
};

changedistrib = function(id, name, address) {
    $('#distribtd').html('<input type="text" width="300px" id="distrib" value="'+ name +'" />');
    $('#addresstd').html('<textarea rows="5" id="address">'+ decodeURIComponent(address) +'</textarea>');
    $('#buttontd').html('<input type="button" value="Update Distributor ..." onclick="updatedistrib(\''+ id +'\')" />');
};

updatedistrib = function(id) {
    $.post("<? echo urlRequest();?>",{id:id, distrib:$('#distrib').val(), address:$('#address').val(), rand3:Math.random() }, function(data)
    {
        $("#search").trigger('submit');
        
    });
};

deletedistrib = function(id) {
    if (confirm('Are you sure you want to delete the selected Distributor?')) {$.post("<? echo urlRequest(); ?>", {id: id, rand4:Math.random()})}
    $("#search").trigger('submit');
};

createdistrib = function() {
    var html= '<form method="post" id="createdistribform">' +
    '<table border="0" cellpadding="5" cellspacing="5">' +
    '<tr><th>Distributor:</th><td><input type="text" width="300px" id="distrib" /></td></tr>'+
    '<tr><th>Address:</th><td><textarea rows="5" id="address"></textarea></td></tr>'+
    '<tr><td colspan="100%"><input type="button" value="Create Distributor ..." onclick="uploaddistrib()" /></td></tr>'+
    '</table>' +
    '</form>';
    $('#return').html(html);

};

uploaddistrib = function(id) {
    $.post("<? echo urlRequest();?>",{distrib:$('#distrib').val(), address:$('#address').val(), rand5:Math.random() }, function(data)
    {
        $("#search").trigger('submit');
        
    });
};
 
createnote = function() {
    var data = 
    '<div>'+
    'Note:<textarea id="note" rows="5" cols="50"></textarea><br />'+
    '<input type="button" value="Add Note" onclick="uploadnote();" />'+
    '</div>';
    $('#return').html(data);
};

uploadnote = function() {
    $.post("<? echo urlRequest();?>",{note:$('#note').val(), rand6:Math.random() }, function(data)
    {
        $("#search").trigger('submit');
        
    });
};

clientbar = function() {
    $clientbar = new Toolbar('<? echo $icon_path; ?>');
    $clientbar.addButton("", "", "");
    $clientbar.addDivider();
    $clientbar.end();
}

loadlegal = function(id) {
    $('#loadreturn').html('LEGAL: ' +id);
};

loadinvestgate = function(id) {
    $('#loadreturn').html('INVESTIGATE: ' +id);
};

loadcollections = function(id) {
    lookupcollections(id);
    loadcollectioncustomers();
    data = '<div id="lookupcollecionsreturn"></div>' +
    '<hr />'+
    '<h3>Add Collections</h3>'+
    '<form id="loadreturnform">' +    
    '<p>Date:<input type="text" id="date" name="date" id="date" /></p>' +
    '<table id="loadcollectioncustomers" border="1" cellpadding="5" cellspacing="5">' +
    '</table>' +
    '</form>' +
    '<input type="button" value="Add Collections" onclick="' + $("#loadreturnform").trigger('submit') +'" />';
    
    $('#loadreturn').html(data);

    $(function(){
        $('#date').live('click', function() {
            $(this).datepicker({showOn:'focus'}).focus();
        });
    });
    
    $("#loadreturnform").submit(function() {
        //$.post("<? echo urlRequest();?>",{date:$('#date').val(),reference:$('#reference').val(), rand10:Math.random() }, function(data)
        $.post("<? echo urlRequest();?>",{rand10:Math.random() }, function(data)
        {
            $('#loadreturn').html(data);   
        });
    });
};

loadcollectioncustomers = function() {
    $.post("<? echo urlRequest();?>",{rand9:Math.random() }, function(data)
    {
        $('#loadcollectioncustomers').html(data);
    });
};

lookupcollections = function(id) {
    $.post("<? echo urlRequest();?>",{id:id, rand7:Math.random() }, function(data)
    {
        $('#lookupcollecionsreturn').html(data);
    });
};

</script>
<div id="wrap">
<div id="ContentLeft">
<script>
    $toolbar = new Toolbar('<?php echo $icon_path ?>');
    $toolbar.addButton("Create New Distributor", "lorry_add.png", "createdistrib();");
    $toolbar.end();
</script>

<form id="search" method="post" autocomplete="off">
<b>Search Distributors:</b>
<input type="text" id="q" style="width: 180px;" />
</form>
<hr />
<div id="result"></div>
</div>
<div id="ContentRight">
<script type="text/javascript">
    $distribbar = new Toolbar('<? echo $icon_path; ?>');
    $distribbar.addButton("Create New Note", "note_add.png", "createnote();");
    $distribbar.end();
</script>
<form method="post" id="returnform">
<div id="return"></div>
</form>
</div>
<div id="Clear"></div>
</div>
