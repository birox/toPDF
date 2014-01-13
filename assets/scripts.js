jQuery(function($)
{
	//pdf popup on editor page
	$(document).on('click', '#edit-pdf-download', function() {
		$('#filePdfDownload').modal('show');
	});
	//download pdf files
	$(document).on('click', '#download-pdf-file', function() {
		
		var $this = $(this),
		file = $("#md-file").val(),
		source = encodeURIComponent($("#md-editor").val()),
		template = $("#template").val(),
		path = '';
		
		if(file != '')
			path = '&path='+ file;
		
		$this.button('loading');
				
		MyTimestamp = new Date().getTime(); // Meant to be global var
		$.get(download_url,'timestamp='+MyTimestamp+'&action=pdf'+ path +'&template='+ template +'&source='+ source, function(){
			
			document.location.href = download_url +'?timestamp='+MyTimestamp+'&action=pdf'+ path +'&template='+ template +'&source='+ source;
			$this.button('reset');
			
		});
	});
	
	//download pdf folder zipped
	$(document).on('click', '#download-pdf-folder', function() {
		
		var $this = $(this),
		file = $("#md-folder").val(),
		template = $("#folder-pdf-template").val(),
		path = '';
		
		if(file != '')
			path = '&path='+ file;
		
		$this.button('loading');
				
		MyTimestamp = new Date().getTime(); // Meant to be global var
		$.get(download_url,'timestamp='+MyTimestamp+'&action=folder_pdf'+ path +'&template='+ template, function(){
			
			document.location.href = download_url +'?timestamp='+MyTimestamp+'&action=folder_pdf'+ path +'&template='+ template;
			$this.button('reset');
			
		});
	});
	
});