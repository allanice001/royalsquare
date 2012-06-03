<?php
	echo 'var widget_image_path = "' . imagePath('widgets') . '";'
?>

function MultiSelector(name, image_path)
{

	this.entries = new Array();
	this.selected_id  = null;

	this.add = function(id, icon, caption, selected) {this.entries[this.entries.length] = {"id" : id, "icon" : icon, "caption" : caption, "selected" : selected ? selected : false}; this.output();}
	this.select = function(id) {this.selected_id = id; this.output();}
	this.changeSelected = function(selected) {if (this.selected_id != null) {document.getElementById(name + "_changed").value = 1; this.entries[this.selected_id]["selected"] = !this.entries[this.selected_id]["selected"]; this.selected_id = null; this.output();}}

	this.output = function()
	{

		var entries_available = new Array();
		var entries_selected  = new Array();
		for (id in this.entries) {if (this.entries[id].selected) {entries_selected[id] = id;} else {entries_available[id] = id;}}

		if (entries_available.length) {
			results = '<table border="0" cellspacing="0" cellpadding="1">';
			for (id in entries_available) {
				results +=
					'<tr onclick="' + name + '.select(\'' + id + '\');">' +
						'<td style="padding-right: 4px;">' + (this.entries[id]["icon"] ? '<img src="' + image_path + this.entries[id]["icon"] + '" alt="" />' : '&nbsp;') + '</td>' +
						'<td>' + (this.selected_id == id ? '<span style="background: #c5e9fb;">' + this.entries[id]["caption"] + '</span>' : this.entries[id]["caption"]) + '</td>' +
					'</tr>';
			}
			results += '</table>';
		} else {results = "";}
		document.getElementById(name + "_available").innerHTML = results;

		var count = 0;
		if (entries_selected.length) {
			results = '<table border="0" cellspacing="0" cellpadding="1">';
			for (id in entries_selected) {
				count++;
				results +=
					'<tr onclick="' + name + '.select(\'' + id + '\');">' +
						'<td style="padding-right: 4px;">' + (this.entries[id]["icon"] ? '<img src="' + image_path + this.entries[id]["icon"] + '" alt="" />' : '&nbsp;') + '</td>' +
						'<td>' + (this.selected_id == id ? '<span style="background: #c5e9fb;">' + this.entries[id]["caption"] + '</span>' : this.entries[id]["caption"]) + '<input type="hidden" name="' + name + '[]" value="' + this.entries[id]["id"] + '" />' + '</td>' +
					'</tr>';
			}
			results += '</table>';
		} else {results = "";}
		document.getElementById(name + "_selected_count").value = count;
		document.getElementById(name + "_selected").innerHTML = results;
	}

	/////////////////////////////////////////////////
	// STARTUP
	/////////////////////////////////////////////////

	document.write(
		'<input type="hidden" id="' + name + '_changed" name="' + name + '_changed" value="0" />' +
		'<input type="hidden" id="' + name + '_selected_count" value="0" />' +
		'<table style="margin: auto;" border="0" cellspacing="0" cellpadding="0">' +
			'<tr>' +
				'<td style="text-align: center;">Available</td>' +
				'<td>&nbsp;</td>' +
				'<td style="text-align: center;">Selected</td>' +
			'</tr>' +
			'<tr>' +
				'<td><div id="' + name + '_available" style="cursor: default; width: 200px; height: 70px; border: solid 1px #828790; overflow: auto; padding: 3px;"></div></td>' +
				'<td style="padding: 3px;"><input type="button" value="&lt;&nbsp;&gt;" onclick="' + name + '.changeSelected();" /></td>' +
				'<td><div id="' + name + '_selected" style="cursor: default; width: 200px; height: 70px; border: solid 1px #828790; overflow: auto; padding: 3px;"></div></td>' +
			'</tr>' +
		'</table>'
	);

}

function Toolbar(image_path)
{
	this.addButton = function(caption, icon, command)
	{
		if (command) {command = command.replace(/"/g, "'");}
		document.write(
			'<td class="back">' +
				'<table onclick="' + command + '" onmouseup="this.onmouseover();" onmousedown="this.className = \'clicked\';" onmouseover="this.className = \'highlight\';" onmouseout="this.className = \'normal\';" class="normal" border="0" cellspacing="0" cellpadding="0">' +
					'<tr>' +
						(caption && icon ? '<td style="padding-left: 3px;"><img src="' + (image_path + icon) + '" alt="" /></td><td style="padding: 0px 3px; white-space: nowrap;">' + caption + '</td>' :
							(icon ? '<td style="padding: 0px 3px;"><img src="' + (image_path + icon) + '" alt="" /></td>' :
								'<td style="padding: 0px 3px; white-space: nowrap;">' + caption + '</td>'
							)
						) +
					'</tr>' +
				'</table>' +
			'</td>'
		);
	}

	this.addDivider = function()
	{
		document.write('<td style="vertical-align: top;"><img src="' + widget_image_path + 'toolbar/div.gif" alt="" /></td>');
	}

	this.addCustom = function(content)
	{
		document.write('<td class="back" style="white-space: nowrap; vertical-align: middle;">' + content + '</td>');
	}

	this.end = function()
	{
		document.write(
						'<td class="back" style="width: 100%;">&nbsp;</td>' +
						'<td style="vertical-align: top;"><img src="' + widget_image_path + 'toolbar/end.gif" alt="" /></td>' +
					'</tr>' +
				'</table>' +
			'</div>'
		);
	}

	/////////////////////////////////////////////////
	// STARTUP
	/////////////////////////////////////////////////

	document.write(
		'<div class="Toolbar">' +
			'<table class="Toolbar" border="0" cellspacing="0" cellpadding="0">' +
				'<tr>' +
					'<td style="vertical-align: top;"><img src="' + widget_image_path + 'toolbar/start.gif" alt="" /></td>'
	);

}

function IconList(image_path, title)
{

	this.add = function(icon, text, link, tooltip)
	{
		document.write(
			'<div' + (tooltip ? ' title="' + tooltip + '"' : '') + ' onclick="window.open(\'' + link + '\', \'_self\');" onmouseover="this.style.backgroundPosition = \'-70px top\';" onmouseout="this.style.backgroundPosition = \'left top\';" class="icon">' +
				'<div class="image"><img src="' + image_path + icon + '" alt="" /></div>' +
				'<div class="text">' + (text ? text : '&nbsp;') + '</div>' +
			'</div>'
		);
	};

	this.end = function()
	{
		document.write(
					'</td>' +
				'</tr>' +
			'</table>'
		);
	};

	/////////////////////////////////////////////////
	// STARTUP
	/////////////////////////////////////////////////

	document.write(
		'<table class="IconList" border="0" cellspacing="0" cellpadding="0">' +
			(title ? '<tr><td class="header">' + title + '</td></tr>' : '') +
			'<tr>' +
				'<td class="iconarea">'
	);

}

function TabStrip(name)
{

	this.data = new Array();
	this.data["tabs"] = new Array();
	this.data["current_tab"] = null;
	this.data["elements"] = new Array();

	this.add = function(id, text, type, tooltip, element_array)
	{
		this.data["tabs"][id] = {
			"text"     : text,
			"type"     : type || "default",
			"tooltip"  : tooltip,
			"elements" : element_array
		};

		for (element in element_array) {
			this.data["elements"][element_array[element]] = element_array[element];
		}
	};

	this.select = function(tab_id)
	{
		if (!tab_id) {for (tab_id in this.data["tabs"]) {if (this.data["tabs"][tab_id].elements.length) {break;}}}
		if (this.data["current_tab"] && this.data["current_tab"] != tab_id) {
			document.getElementById(name + "_" + this.data["current_tab"]).className = this.data["tabs"][this.data["current_tab"]].type + ' ' + this.data["tabs"][this.data["current_tab"]].type + "_off";
		}
		document.getElementById(name + "_" + tab_id).className = this.data["tabs"][tab_id].type + ' ' + this.data["tabs"][tab_id].type + "_on";
		this.data["current_tab"] = tab_id;
		for (element in this.data["elements"]) {
			for (var i = 0, j = this.data["tabs"][tab_id]["elements"].length; i < j; i++) {
				if (this.data["tabs"][tab_id]["elements"][i] == element) {break;}
			}
			document.getElementById(element).style.display = (i >= j) ? "none" : "block";
		}

	};

	this.end = function()
	{
		var results = '';
		for (id in this.data["tabs"]) {
			var tab = this.data["tabs"][id];
			results += (
				(tab.elements.length ?
					'<div class="tab out" onmouseover="this.className = \'tab over\';" onmouseout="this.className = \'tab out\';" onclick="' + name + '.select(\'' + id + '\');" title="' + tab.tooltip + '">' :
					'<div class="tab out" title="' + tab.tooltip + '">'
				) +
					'<div id="' + name + '_' + id + '" class="' + tab.type + ' ' + tab.type + '_off">' +
						'<div class="left"></div>' +
						'<div class="center' + (tab.elements.length ? '' : ' disabled') + '">' + tab.text + '</div>' +
						'<div class="right"></div>' +
					'</div>' +
				'</div>'
			);
		}
		document.getElementById(name).innerHTML = results;
		this.select();
	};

	/////////////////////////////////////////////////
	// STARTUP
	/////////////////////////////////////////////////

	document.write(
		'<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">' +
			'<tr>' +
				'<td id="' + name + '" class="TabStrip">&nbsp;</td>' +
			'</tr>' +
		'</table>'
	);

}
