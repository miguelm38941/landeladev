$(document).ready(function() {

	$('select').on('change',function(){

		var datas={};
		$('select').each(function(){
			var el = $(this);
			var name = el.attr('name');
			var val = el.val();
	
			datas[name]=val;		
		});
		console.log(datas);

		updateNumbers(datas);

	});

	//$('textarea').characterCounter();	
	updateNumbers({});
});


function updateNumbers(datas){

	var url = window.base_url+"/sms/countContacts/";
	$.get(url,datas,function(data){
		console.log(data);
		$("#cnumbers").html(data);
	});

}
