<?php
use \Michelf\Markdown;
function downloadPDFFile($vars) {
	
	$path = $vars['path'];
	$template = $vars['template'];
	
	$plugin_path = plugin_path(__FILE__);
	
	if(isset($_REQUEST['path']) && file_exists($path)) {
			$text = file_get_contents($path);
			$html = Markdown::defaultTransform($text);
			$name = basename(str_replace('.md', '', $path));
	}
	else {
		$text = urldecode($_REQUEST['source']);
		$html = Markdown::defaultTransform($text);
		preg_match_all('|<h[^>]+>(.*)</h[^>]+>|iU', $html, $headings);
		if(is_array($headings[0])) {
			$title = $headings[0];
			if(is_array($title))
				$name = strip_tags($title[0]);
		}
		else {
			$name = _t('readme');
		}
	}
	
	$layout = file_get_contents('templates' . DIRECTORY_SEPARATOR  . $template .'.html');
	
	$search = array('[TITLE]', '[CONTENT]');
	$replace = array($name, $html);
	$output = str_replace($search, $replace, $layout);

	header("Last-Modified: " . @gmdate("D, d M Y H:i:s",$_REQUEST['timestamp']) . " GMT");
	header('Content-Transfer-Encoding: binary');
	header('Accept-Ranges: bytes');
	header('Content-Encoding: none');
	header('Content-type: application/pdf');
	header('Content-disposition: attachment; filename='. $name .'.pdf');
	
	include($plugin_path . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'MPDF' . DIRECTORY_SEPARATOR . 'mpdf.php');
	$mpdf=new mPDF();
	// Buffer the following html with PHP so we can store it to a variable later
	ob_start();
	
	echo $output;
	
	// Now collect the output buffer into a variable
	$html = ob_get_contents();
	ob_end_clean();
	
	// send the captured HTML from the output buffer to the mPDF class for processing
	$mpdf->SetTitle($name);
	$mpdf->WriteHTML($html);
	
	$mpdf->Output();
	
}
hook('download_pdf', null, 'downloadPDFFile');

function downloadPDFFolder($vars) {
	
	$path = $vars['path'];
	$template = $vars['template'];

	$plugin_path = plugin_path(__FILE__);
	
	if(isset($_REQUEST['path']) && file_exists($path)) {
			
		include($plugin_path . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'MPDF' . DIRECTORY_SEPARATOR . 'mpdf.php');
		
		$folder_name = basename($path);
		
		if(!file_exists($_REQUEST['path']))
		$temp = $folder_name;
		else
		$temp = $folder_name . '_' . uniqid();
		
		$assets_url = DOC_URL . DIRECTORY_SEPARATOR . 'assets'. DIRECTORY_SEPARATOR . 'fonts' . DIRECTORY_SEPARATOR;
		
		mkdir($temp, 0777, true);
		
		$files = glob($path . DIRECTORY_SEPARATOR .'*.{md}', GLOB_BRACE);
		$list = '';
		foreach($files as $file) {
			
			$text = file_get_contents($file);
			$html = Markdown::defaultTransform($text);
			$name = basename(str_replace('.md', '', $file));
			if($name == 'readme')
				$name = 'index';
			
			$layout = file_get_contents('templates' . DIRECTORY_SEPARATOR . $template .'.html');
			
			$search = array('[TITLE]', '[CONTENT]');
			$replace = array($name, $html);
			$output = str_replace($search, $replace, $layout);
			
			$newFile = $temp . DIRECTORY_SEPARATOR . $name . '.pdf';
			
			$mpdf=new mPDF();
			
			$mpdf->SetTitle($name);
			$mpdf->WriteHTML($output);
			
			$mpdf->Output($newFile,'F');
			
		}
		
		$files = glob($temp . DIRECTORY_SEPARATOR .'*.{pdf}', GLOB_BRACE);
		$zipname = $folder_name .'.zip';
		$zip = new ZipArchive;
		$zip->open($zipname, ZipArchive::CREATE);
		foreach ($files as $file) {
		  $zip->addFile($file);
		}
		$zip->close();
		
		header("Last-Modified: " . @gmdate("D, d M Y H:i:s",$_REQUEST['timestamp']) . " GMT");
		header('Content-Type: application/zip');
		header('Content-disposition: attachment; filename='. $zipname);
		readfile($zipname);
		
		doc_delete($temp);
		doc_delete($zipname);
		
	}
	else {
		
	}
	
}
hook('download_folder_pdf', null, 'downloadPDFFolder');















