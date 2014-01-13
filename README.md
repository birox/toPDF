#toPDF
![](http://documentator.org/assets/img/toPDF_shoot.png)  
***
*Plugin Name:* toPDF  
*Author:* Biro Florin  
*Author Website:* [documentator.org](http://documentator.org)  
*Created:* 1/12/2014 23:58:49  
*Version:* 1.0.0  
*Download source:*  [GitHub](#)  
***

**toPDF** is a plugin for Documentator that allows you and your documentation readers to export files in .pdf format.

This plugin includes the [mPDF library](http://mpdf.bpm1.com/) and the size of the plugin is quite large (30 Mb).

toPDF is also a good example on how to build your own plugins for Documentator.

>Hooks in use:

1. <code>hook('js', null, 'toPDF\_js');</code>
2. <code>hook('css', null, 'toPDF\_css');</code>
3. <code>hook('translate', null, 'toPDF\_translate');</code>
4. <code>hook('user\_file\_download_menu', null, 'user\_file\_download\_li');</code>
5. <code>hook('user\_folder\_download_menu', null, 'user\_folder\_download\_li');</code>
6. <code>hook('public\_file\_download\_menu', null, 'public\_file\_download\_li');</code>
7. <code>hook('public\_folder\_download\_menu', null, 'public\_folder\_download\_li');</code>
8. <code>hook('editor\_file\_menu', null, 'editor\_file\_li');</code>
9. <code>hook('after\_content', null, 'pdf\_modals');</code>
10. <code>hook('download\_pdf', null, 'downloadPDFFile');</code>
11. <code>hook('download\_folder\_pdf', null, 'downloadPDFFolder');</code>

***

>Functions in use:

* <code>plugin\_path(\_\_FILE\_\_)</code>
* <code>plugin\_url(\_\_FILE\_\_)</code>
* <code>path()</code>
* <code>Markdown::defaultTransform($text)</code>
* <code>doc\_delete($temp);</code>
* <code>\_t($translate)</code>

***

>Plugin structure:

* assets  
  * scripts.js  
  * style.css  
* libs  
  * MPDF  
     * [mPDF library files](http://mpdf1.com/manual/index.php?page=introduction)  
* translate  
  * en.ini  
* index.php  
* download.php

