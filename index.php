<?php
#
# Documentator toPDF plugin
# Use of hooks: footer_right
#
$plugin_path = plugin_path(__FILE__);

include($plugin_path . DIRECTORY_SEPARATOR . 'download.php');

//Start js register
function toPDF_js($scripts) {
	
	$plugin_url = plugin_url(__FILE__);
	
	$scripts[] = array(
		$plugin_url . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'scripts.js'
	);
	return $scripts;
	
}
hook('js', null, 'toPDF_js');
//End js register

//Start css register
function toPDF_css($styles) {
	
	$plugin_url = plugin_url(__FILE__);
	
	$styles[] = array(
		$plugin_url . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'style.css'
	);
	return $styles;
	
}
hook('css', null, 'toPDF_css');
//End css register

//Start language folder
function toPDF_translate($translate) {
	
	$plugin_path = plugin_path(__FILE__);
	
	$translate[] = $plugin_path. DIRECTORY_SEPARATOR . 'translate';
	return $translate;
	
}
hook('translate', null, 'toPDF_translate');
//End language folder

//Start Set menu items
function user_file_download_li() {
	echo '<li><a id="menu-pdf-download" href="#filePdfDownload" data-toggle="modal"><span class="label label-danger">PDF</span> '. _t('Download file') .'</a></li>';
}
hook('user_file_download_menu', null, 'user_file_download_li');

function user_folder_download_li() {
	echo '<li><a id="menu-pdf-download-folder" href="#folderPdfDownload" data-toggle="modal"><span class="label label-danger">PDF</span>  '. _t('Download folder') .'</a></li>';
}
hook('user_folder_download_menu', null, 'user_folder_download_li');

function public_file_download_li() {
	echo '<li><a id="menu-pdf-download" href="#filePdfDownload" data-toggle="modal"><span class="label label-danger">PDF</span> '. _t('Download file') .'</a></li>';
}
hook('public_file_download_menu', null, 'public_file_download_li');

function public_folder_download_li() {
	echo '<li><a id="menu-pdf-download-folder" href="#folderPdfDownload" data-toggle="modal"><span class="label label-danger">PDF</span> '. _t('Download file') .'</a></li>';
}
hook('public_folder_download_menu', null, 'public_folder_download_li');
//End Set menu items

//Start editor file menu
function editor_file_li() {
	echo '<li><a id="edit-pdf-download" href="javascript:void(0)"><span class="label label-danger">PDF</span> '. _t('Download') .'</a></li>';
}
hook('editor_file_menu', null, 'editor_file_li');
//End editor file menu

//Start modals
function pdf_modals() {
	?>
    	<!--Download file (pdf) modal-->
        <div class="modal fade" id="filePdfDownload">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-download"></i> <?php echo _t('Download pdf file'); ?></h4>
              </div>
              <div class="modal-body">
                <div class="alert alert-info editor-saving4"></div>
                <form role="form">
                  <div class="form-group">
                    <label for="save-folder"><?php echo _t('Select template'); ?></label>
                    <select class="form-control" name="template" id="template">
                        <option value="github"><?php echo _t('Default github style'); ?></option>
                        <?php
                            $count = count(glob('includes' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . '*'));
            
                            if($count > 0) {
                                if ($handle = opendir('includes' . DIRECTORY_SEPARATOR . 'templates')) {	
                                    $blacklist = array('.', '..');
                                    while (false !== ($file = readdir($handle))) {
                                        if (!in_array($file, $blacklist)) {
                                            if(preg_match("/_folder/i", $file))
                                                continue;
                                                
                                            $name = basename(str_replace('.html', '', $file));
                                            
                                            if($name == 'github')
                                                continue;
                                            
                                            printf('<option value="%1$s">%1$s</option>', $name);
                                        }
                                    }
                                }
                            }
                        ?>
                    </select>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _t('Close'); ?></button>
                <button id="download-pdf-file" type="button" class="btn btn-primary" data-loading-text="<img src='<?php path(); ?>/assets/img/loading.gif' style='height: 12px' />"><?php echo _t('Download'); ?></button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
        <!--Download folder (pdf) modal-->
        <div class="modal fade" id="folderPdfDownload">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-download"></i> <?php echo _t('Download pdf folder'); ?></h4>
              </div>
              <div class="modal-body">
                <div class="alert alert-info editor-saving4"></div>
                <form role="form">
                  <div class="form-group">
                    <label for="save-folder"><?php echo _t('Select template'); ?></label>
                    <select class="form-control" name="folder-pdf-template" id="folder-pdf-template">
                        <option value="github"><?php echo _t('Default github style'); ?></option>
                        <?php
                            $count = count(glob('includes' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . '*'));
            
                            if($count > 0) {
                                if ($handle = opendir('includes' . DIRECTORY_SEPARATOR . 'templates')) {	
                                    $blacklist = array('.', '..');
                                    while (false !== ($file = readdir($handle))) {
                                        if (!in_array($file, $blacklist)) {
                                            if(preg_match("/_folder/i", $file))
                                                continue;
                                                
                                            $name = basename(str_replace('.html', '', $file));
                                            
                                            if($name == 'github')
                                                continue;
                                            
                                            printf('<option value="%1$s">%1$s</option>', $name);
                                        }
                                    }
                                }
                            }
                        ?>
                    </select>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _t('Close'); ?></button>
                <button id="download-pdf-folder" type="button" class="btn btn-primary" data-loading-text="<img src='<?php path(); ?>/assets/img/loading.gif' style='height: 12px' />"><?php echo _t('Download'); ?></button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    <?php
}
hook('after_content', null, 'pdf_modals');
//End modals