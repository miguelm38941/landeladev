$(document).ready(function(){
	
	$('.datepicker').pickadate({
		selectMonths: true, // Creates a dropdown to control month
		selectYears: 15, // Creates a dropdown of 15 years to control year
		formatSubmit: 'yyyy-mm-dd',
		format: 'yyyy-mm-dd'
	});	

	$("div.list-items").on('click','a.btn-del-list-item',function(){
		var d = $(this).closest('.list-item');
		if(d.prev('.list-item').length > 0 || d.next('.list-item').length > 0){
			d.remove();	
		}
	});
	$("a.btn-add-list-item").on('click',function(){
		var el = $(this);
		var d = el.prev().clone();
		el.before(d);
		d.find("input").val('');
	});

	$("#lgedit_search").on('keyup',function(e){
		var val = $(this).val();
		//var t = $("#lgedit_table table");
		var t = $(this).closest('form').next('table');
		if(val){
			val = val.toLowerCase();
			t.find("tr").each(function(){
				var r = $(this);
				var c = r.text().toLowerCase();
				if(c.search(val) == -1){
					r.hide();
				}else{
					r.show();
				}
			});
		}else{
			t.children().show();
		}
	});

	
	$("div.lgedit_table").on('dblclick','tr',function(e){
		e.stopPropagation();
		var l = $(this).data('dblclick');
		if(l){
			window.location=l;
		}	
	});

	
	$("div.lgedit_table").on('click','i.copy',function(e){
		e.stopPropagation();

		var el = $(this).closest('tr');
		var id = el.data('id');
		var table = el.closest('div.lgedit_table').data('table');
		if(id){
			$.post(window.base_url+'/lgedit/duplicate/'+table,{'id':id},function(data){
				Materialize.toast('Operation avenu avec success', 3000);
				window.location.reload();
			}).fail(function(){
				Materialize.toast('ERREUR', 3000);
			});
		}
	});
	
	$("div.lgedit_table").on('click','i.delete',function(e){
		e.stopPropagation();

		var res = confirm('voulez vous vraiment effacer le champ ?');

		if (!res) return;

		var el = $(this).closest('tr');
		var id = el.data('id');
		var table = el.closest('div.lgedit_table').data('table');
		if(id){
			$.post(window.base_url+'/lgedit/del/'+table,{'id':id},function(data){
				Materialize.toast('Operation avenu avec success', 3000);
				el.remove();	
			}).fail(function(){
				Materialize.toast('ERREUR', 3000);
			});
		}
	});

	$("div.lgedit_table").on('click','i.edit',function(e){
		var el = $(this).closest('tr');
		var id = el.data('id');
		var table = el.closest('div.lgedit_table').data('table');
		var url = window.base_url+'/lgedit/modPage/'+table+'/'+id;
		console.log(url);
		window.location=url;
	});

	$("#lgedit_form form").on('submit',function(e){
		e.stopPropagation();
		e.preventDefault();
		var f = $(this);
		var table = f.data('table');
		var datas = f.serialize();
		$.post(window.base_url+'/lgedit/add/'+table,datas,function(data){
			console.log(datas);
			Materialize.toast('Operation avenu avec success', 3000);
			if(window.lgedit_form_reset != false){
				f.get(0).reset();
			}
			window.formupdated=true;
			if(window.formredirect){
				window.location=window.formredirect;
			}
		}).fail(function(){
			Materialize.toast('ERREUR', 3000);
		});
	});
	
	$("div.lgedit_cards").on('click','a',function(e){
		var el = $(this);
		var id = el.data('id');
		var table = el.closest("div.lgedit_cards").data('table');
		if(el.hasClass('copy')){
			$.post(window.base_url+'/lgedit/duplicate/'+table,{'id':id},function(data){
				window.location.reload();
				//Materialize.toast('Operation avenu avec success', 3000);
			}).fail(function(){
				Materialize.toast('ERREUR', 3000);
			});
		}else if(el.hasClass('delete')){
			var res = confirm('voulez vous vraiment effacer le champ ?');
			if (!res) return;
			$.post(window.base_url+'/lgedit/del/'+table,{'id':id},function(data){
				window.location.reload();
				//Materialize.toast('Operation avenu avec success', 3000);
			}).fail(function(){
				Materialize.toast('ERREUR', 3000);
			});
		}
	});

	
});
