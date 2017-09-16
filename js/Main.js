var username;
var page = 0;

function onLoad(){
	$('#submit_new').click(add_new);
    $("#login").click(logIn);
    $("#my_uploads").click(function(){changePage(2);});
    $("#add_new").click(function(){changePage(1);});
    $("#page_1").hide();
    $("#page_2").hide();
    $("#nav").hide();

}
function logIn(){
    username = $("#user").val();
    $("#nav").show();
    changePage(1);
}
function changePage(newPage){
    $("#page_"+page).hide();
    page = newPage;
    $("#page_"+page).show();
    if(page == 2) showMyProperty();
}
function showMyProperty(){
    var limit = 5;
    //get the data
    $.get("php/get_property_data.php",{"name": username}, function(data){
        console.log(data); 
    });
    //get the first photo
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
		//returns folder name (username+propeerty id)
		uploadImages(data);
		
	});
}
function uploadImages(id){
    var all_img = $("#upload_photos").find("img");
    //this could use an interrupt
    this.uploadOne=function(index){
        if(index >= all_img.length) return;
        var src = $(all_img[index]).attr("src");

        var sd = {"name":id, "data":src};
		//console.log(sd);
		$.post('php/save_photo.php', sd, function(data){
            index++;
            uploadOne(index);
        });
    }
    uploadOne(0);
}
