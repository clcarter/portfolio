// JavaScript Document

		$('.flexme').flexigrid({
			height : 'auto',
		});
		$(".flexme3").flexigrid({
			url : 'ajax/post-json.php',
			dataType : 'json',
			colModel : [  
				{display: 'ID', name : 'row_id', width : 60, sortable : true, align: 'center'},
				{display: 'Date', name : 'date', width : 80, sortable : true, align: 'left'},
				{display: 'Description of Purchase', name : 'purchase', width : 180, sortable : true, align: 'left'},
				{display: 'Organization/Person', name : 'entity', width : 180, sortable : true, align: 'left'},
				{display: 'Category', name : 'category', width : 130, sortable : true, align: 'left', hide: true},
				{display: 'Account', name : 'account', width : 130, sortable : true, align: 'left'},
				{display: 'Amount', name : 'amount', width : 130, sortable : true, align: 'right'}
			 ],
			buttons : [ 
				{	name : 'Add',	bclass : 'add', onpress : onSelectedAction	}, 
				{	separator : true },
				{	name : 'Delete', bclass : 'delete', onpress : onSelectedAction },
				{	separator : true}
			 ],
			searchitems : [ { display : 'Date', name : 'date' },
				{ display : 'Description of Purchase',	name : 'purchase', isdefault : true },
				{ display : 'Organization/Person', name : 'entity' },
				{ display : 'Category', name : 'category' },
				{ display : 'Account', name : 'account' }
			 ],
			sortname : "date",
			sortorder : "desc",
			usepager : true,
			title : 'Transaction Record',
			useRp : true,
			rp : 15,
			showTableToggleBtn : true,
			width : 'auto',
			height : 350,
			
		});

		function onSelectedAction(com, grid) {
				
			if (com == 'Delete') {
				var row = $('.trSelected div').html();
				//alert(row);
				if(row == null){
					alert("Please select a row to delete.");	
				}
				else{
					if(confirm('Delete row ' + row + '?')){
						$.post('ajax/re-post-json.php', { delrow: row }, function(data){
							response = jQuery.parseJSON(data);
							$('.CollapsiblePanelContent').html("Response: " + response['delrow']);
							$('.flexme3').flexReload();	
						});
					}
				}
				
				
			} else if (com == 'Add') {
								
				var currentTime = new Date();
				var month = currentTime.getMonth() + 1;
				var day = currentTime.getDate();
				var year = currentTime.getFullYear();
				$.post('ajax/re-post-json.php', { j_form:[ { date_new : year+'/'+month+'/'+day} ] }, function(data){
					response = jQuery.parseJSON(data);
						$('.CollapsiblePanelContent').html("Response: " + response['change']);	
						//$(this_id).toggleClass('trSelected');
						
						$.post('ajax/post-json.php', { add : true }, function(data){
							$('.flexme3').flexAddData(data);
							$('.CollapsiblePanelContent').append("Response: " + data);	
						});
				});
			}
		}
		
	$(document).ready(function() {
		$('.flexme3').click( function (e) {
			
			$('tr, this').removeClass('trSelected');
     		target = $(e.target);

      	while(target.get(0).tagName != "TR"){
				//if(target.get(0).tagName =="INPUT") onSelectedAction('Edit', $('.flexigrid'));
      	  target = target.parent();
      	}

      	var content_of_first_cell = {'inj_id': target.get(0).id.substr(3)}
			//alert($(content_of_first_cell).attr('class'));
			$(target).addClass('trSelected');
			$(this).flexToggleCol('4',true);
				$('.a', this).attr('disabled','');
				$('.trSelected .a', this).removeAttr('disabled');
			onSelectedAction('Edit', target);
	});
	
	});
	
	
	function edit_form(this_id){

	jQuery.validator.addClassRules('amount',{
   	 required: true,
    		number: true
});
		var a = $("#form_wrap").validate().element(this_id);
			
			if(a){
				var value = $(this_id).attr('value');
				var key = $(this_id).attr('name');
				var id = $(this_id).attr('id');
				var j_form = {};
				var dat;
				j_form[key] = value;
				varid = id.split('_');
				//alert(varid[0]);
				if(varid[0] == 'account'){
					dat = {	j_form: [ j_form ],
								updateAcc : true,
							};
				}
				else if(varid[0] == 'amount'){
					dat = {	j_form: [ j_form ],
								updateAmt : true,
							};
				}
				else{
					dat = {
								j_form: [ j_form ]
							};
				}
						
				//alert();
				$.post($("#form_wrap").attr('action'),	dat, function(data){
						rehtml = '';
						response = jQuery.parseJSON(data);
						jQuery.each(response, function(i,val){
							if(i.indexOf('_') !== -1){
								front = i.split('_')[0];
								acc = i.split('_')[1];
								accId = '#'+acc+' div';
								if(acc.indexOf('Acc') !== -1){
									front == 'new' ? $(accId).html(val).addClass('new') : $(accId).html(val).addClass('prev');
									setTimeout(function(){
										//alert(front);
										front == 'new' ? $(accId).removeClass('new') : $(accId).removeClass('prev');
									},4000);
								}
							}
							else{
								rehtml += val + ' ';
							}
							//alert(i+','+val);
						});
						$('.CollapsiblePanelContent').html(rehtml).addClass('new');	
						$(this_id).toggleClass('trSelected');
				});
			}
		}