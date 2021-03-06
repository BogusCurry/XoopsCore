<?php
require_once(dirname(__FILE__).'/../../../../../../init.php');

/**
* PHPUnit special settings :
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/
class Plugins_Xoops_imagesTest extends \PHPUnit_Framework_TestCase
{
    protected $buffer = null;
    
    public function output_callback($buffer, $flags)
    {
        $this->buffer = $buffer;
        return '';
    }
    
    public function test_100()
    {
		ob_start(array($this,'output_callback')); // to catch output after ob_end_flush in Xoops::simpleFooter
		require_once (XOOPS_ROOT_PATH.'/class/xoopseditor/tinymce/tiny_mce/plugins/xoops_images/xoops_images.php');
		$this->assertTrue(is_string($this->buffer));
    }
}
