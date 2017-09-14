function onLoad(){
	$('#submit_new').click(add_new);
}
//display a thumbnail of the selected picture
function display(input) {
	if(input.files && input.files[0]) {
		var reader = new FileReader();
		//var displayWidth = 300;
		reader.onload = function(e) {
			$('#upload_photos').append('<img src="'+e.target.result+'">');
			/*var height, width;
			//var img = new Image();

			img.onload = function(){
				width = img.width;
				height= img.height;
				$('#thumbnail').prepend($('<img>',{id:'displayedImg'}));
				$('#displayedImg').attr("src", this.src);
				$('#displayedImg').show();
				var ratio = height / width;
				var displayHeight = displayWidth * ratio;
				$('#displayedImg').width(displayWidth);
				$('#displayedImg').height(displayHeight);

			}
			img.src = ;*/
		}

		reader.readAsDataURL(input.files[0]);
	}
}
//sending files might complicate things
function add_new(){
	this.is_checked=function(element){
		if (element.is(":checked"))
			return true;
		else
			return false;
	}
	var json = {
		'user':'BOBO',
		'address': $('#address_1').val()+$('#address_2').val(),
		'type': $('#type').val(),
		'size': $('#size').val(),
		'availability': $('#availability').val(),
		'rent_period': $('#rent_period').val(),
		'situation': $('#situation').val(),
		'a_electricity': this.is_checked($('#a_electricity')),
		'a_wifi':  this.is_checked($('#a_wifi')),
		'a_bathrooms':  this.is_checked($('#a_bathrooms')),
		'a_24_7_access':  this.is_checked($('#a_24_7_access')),
		'a_heating':  this.is_checked($('#a_heating')),
		'a_furniture':  this.is_checked($('#a_furniture')),
		'a_sound_iso':  this.is_checked($('#a_sound_iso')),
		'a_pub_transport':  this.is_checked($('#a_pub_transport')),
		'a_parking':  this.is_checked($('#a_parking')),
		'details': $('#details').val(),
		'contact_1': $('#contact_1').val(),
		'contact_2': $('#contact_2').val(),
	};
	console.log(json);
	$.post('php/add_new_data.php', json, function(data){
		console.log(data);
	});
}
