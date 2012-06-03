<?
    $image_path = imagePath('icons');
    $icon_path = imagePath('icons');
?>
<script type="text/javascript">
dump = function(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
};


$(document).ready(function()
{   
    $("#search").focus();
	$("#search").submit(function() {
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
    '<input type="button" value="Add Collections" onclick="uploadcollections(\''+ id +'\');" />';
    
    $('#loadreturn').html(data);

    $(function(){
        $('#date').live('click', function() {
            $(this).datepicker({showOn:'focus'}).focus();
        });
    });
};

uploadcollections = function(id) {
    $.post("<? echo urlRequest();?>",{
        id:             id,
        date:           $('#date').val(),
        c1_5kg:         $('#1_5kg').val(), 
        c2_5kg:         $('#2_5kg').val(), 
        c3_5kg:         $('#3_5kg').val(), 
        c4_5kg:         $('#4_5kg').val(), 
        c1_9kg:         $('#1_9kg').val(), 
        c2_9kg:         $('#2_9kg').val(), 
        c3_9kg:         $('#3_9kg').val(), 
        c4_9kg:         $('#4_9kg').val(), 
        c1_12kg:        $('#1_12kg').val(),
        c2_12kg:        $('#2_12kg').val(),
        c3_12kg:        $('#3_12kg').val(),
        c4_12kg:        $('#4_12kg').val(),
        c1_14kg:        $('#1_14kg').val(),
        c2_14kg:        $('#2_14kg').val(),
        c3_14kg:        $('#3_14kg').val(),
        c4_14kg:        $('#4_14kg').val(),
        c1_19kg:        $('#1_19kg').val(),
        c2_19kg:        $('#2_19kg').val(),
        c3_19kg:        $('#3_19kg').val(),
        c4_19kg:        $('#4_19kg').val(),
        c1_48kg:        $('#1_48kg').val(),
        c2_48kg:        $('#2_48kg').val(),
        c3_48kg:        $('#3_48kg').val(),
        c4_48kg:        $('#4_48kg').val(),
        c1_user_id :    $('#1_user_id').val(),
        c2_user_id :    $('#2_user_id').val(),
        c3_user_id :    $('#3_user_id').val(),
        c4_user_id :    $('#4_user_id').val(),
        rand10:Math.random()
    }, function(data) {
        lookupcollections(id);
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
