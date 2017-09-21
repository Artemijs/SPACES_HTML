var username = "BOBO";
var page = 3;
var pages = ["logIn.html","add_property.html", "my_uploads.html", "home.html", "search_result.html"];
function onLoad(){
    //load html
    loadHTML();
/*
    $.get('php/test.php',"nothing", function(data){
        console.log(data); 
    });
*/
}

function processHTML(){
    $("#quick_srch_btn").click(quickSearch);
	$('#submit_new').click(add_new);
    $("#login").click(logIn);
    $("#my_uploads").click(function(){changePage(2);});
    $("#add_new").click(function(){changePage(1);});
    $("#page_0").hide();
    $("#page_1").hide();
    $("#page_2").hide();
    $("#page_4").hide();

    $("#nav").hide();
}
function quickSearch(){
    var type = $("#qs_type").val(); 
    var size = $("#qs_size").val();
    var addr = $("#qs_addr").val();
    console.log("type "+type+" size "+size);
    $.get("php/quick_search.php", {"type":type, "size":size, "address":addr}, function(data){
        console.log(data);
        changePage(4); 
        showSearchResults(JSON.parse(data));    
    });

}
function showImage(usn){
    $.get("php/get_image.php",{"name":usn }, function(data){
        var data = JSON.parse(data);
        console.log(data);
        $("#"+data[1]["name"]).append("<img src='"+data[0]["data"]+"'>");
    });            


}
function showSearchResults(data){
    
    console.log(data);
    var mainDiv = $("#search_results");
    mainDiv.empty();
    for(var i =0; i<data.length; i++){
        var usn = data[i]["id"]+data[i]["user"];
        var div = $("<div id = '"+usn+"'></div>");
        mainDiv.append(div);
        div.append("<p>"+data[i]["address"]+"</p>");
        div.append("<p>"+data[i]["type"]+"</p>");
        showImage(usn);
    }

}
function loadHTML(){
    this.getFile=function(index){
        $.get("php/load_html.php",{"file":pages[index]}, function(data){
            if(index >= pages.length){
                processHTML();
                return;
            }
            $("#main").append(data);
            index++;
            getFile(index);
        });
    }
    getFile(0);
}
function logIn(){
    username = $("#user").val();
    $("#nav").show();
    changePage(1);
}
function changePage(newPage){
    console.log("changing page");
    $("#page_"+page).hide();
    page = newPage;
    $("#page_"+page).show();
    if(page == 2) showMyProperty();
}
function showMyProperty(){
    $("#page_2").empty();
    var limit = 5;
    //get the data
    $.get("php/get_property_data.php",{"name": username}, function(data){
        var json = JSON.parse(data);
        for(var i=0; i<json.length; i++ ){
            var usn = json[i]["id"]+json[i]["user"];
            var div = $("<div id='"+usn+"'></div>");
            div.append("<p>"+json[i]["address"]+"</p>");
            div.append("<p>"+json[i]["type"]+"</p>");
 
            $("#page_2").append(div);
            //get the image
            console.log("usn "+usn);
            showImage(usn);
        }
    });
}
//display a thumbnail of the selected picture
function display(input) {
	if(input.files && input.files[0]) {
        this.displayOne=function(index){
            console.log(input.files);
            var reader = new FileReader();
            reader.readAsDataURL(input.files[index]);           
            var displayWidth = 300;
            reader.onload = function(e) {
                var img = $('<img src="'+e.target.result+'">');
                $('#upload_photos').append(img);
                var height, width;
                width = img.width();
                height= img.height();
                console.log("width "+width);
                console.log("height "+height);
                var ratio = height / width;
                var displayHeight = displayWidth * ratio;
                img.width(displayWidth);
                img.height(displayHeight);
            }
        }
        
        for(var i =0; i< input.files.length; i++){
            displayOne(i);
        }

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
		'address': $('#address').val(),
		'type': $('#type').val(),
		'size': $('#size').val(),
		'availability': $('#availability').val(),
		'rent_period': $('#rent_period').val(),
		'situation': $('#situation').val(),
		'a_electricity': this.is_checked($('#electr')),
		'a_wifi':  this.is_checked($('#wifi')),
		'a_bathrooms':  this.is_checked($('#toilet')),
		'a_24_7_access':  this.is_checked($('#access')),
		'a_heating':  this.is_checked($('#heat')),
		'a_furniture':  this.is_checked($('#furnit')),
		'a_sound_iso':  this.is_checked($('#sound')),
		'a_pub_transport':  this.is_checked($('#transp')),
		'a_parking':  this.is_checked($('#parking')),
		'details': $('#details').val(),
		'contact_name': $('#contact_name').val(),
		'contact_email': $('#contact_email').val(),
		'contact_number': $('#contact_number').val()
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
