<?php
/**
 *
 * LICENSE
 *
 * This source file is subject to the GNU LGPL 2.1 license that is bundled
 * with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://creativecommons.org/licenses/LGPL/2.1
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to annop@thaicyberpoint.com so we can send you a copy immediately.
 *
 * @package	   Hoffman
 * @author     Ford AntiTrust
 * @since	   Version 2008
 * @license    GNU LGPL 2.1 http://creativecommons.org/licenses/LGPL/2.1
 * @filesource
 */


/**
 * Hmf_Upload
 *
 * @package     Hmf
 * @category    Upload
 * @author      Ford AntiTrust
 * @link        http://www.fordantitrust.com
 *
 */

class Hmf_Upload {

    const ERR_FILE_SIZE = -1;

    const ERR_FILE_TYPE = -2;

    const ERR_FILE_INPUTNAME_NOT_USE_HTML_ARRAY = -3;

    /**
     * Desination uploaded directory
     *
     * @var string
     */
    private $dirUpload;

    /**
     * Allow uploaded file size
     *
     * @var unknown_type
     */
    private $fileAllowSize = "2097152"; // 2MB


    /**
     * List of allowed mime-type
     *
     * @var array
     */
    private $mimeType = array();

    /**
     * List of allowed extension files
     *
     * @var array
     */
    private $fileExtension = array();

    /**
     *List of filename for uploaded files to specify directory.
     *
     * @var array specify filename by index the upload box in HTML form
     */
    private $destinationFilesName = array();

    /**
     * List of status-text in action-upload
     *
     * @var array
     */
    private $uploadedStatusText = array();

    /**
     * List of source filenames
     *
     * @var array
     */
    private $sourceFilesNameUploaded = array();

    /**
     * List of destination filenames
     *
     * @var array
     */
    private $destinationFilesNameUploaded = array();
    /**
     * List of uploaded file sizes
     *
     * @var array
     */
    private $filesSizeUploaded = array();

    /**
     * List of mime-type in uploaded files
     *
     * @var array
     */
    private $filesMimeTypeUploaded = array();

    /**
     * List of extension file in uploaded files
     *
     * @var array
     */
    private $filesExtTypeUploaded = array();

    /**
     * List of desination path for uploaed files
     *
     * @var array
     */
    private $desinationPathFilesUploaded = array();

    /**
     * Name of HTML file selected control
     *
     * @var string
     */
    private $formInputName;

    /**
     * Overwrite destination files
     * @var boolean
     */
    private $overwrite = false;

    /**
     * Constructor
     */
    public function __construct() {

    }

    /**
     * Setting the desination uploaded directory
     *
     * @param string $value
     * @return Hmf_Components_Upload Provides a fluent interface
     */
    public function setDirUpload($value) {

        $this->dirUpload = $value;

        return $this;
    }

    /**
     * Getting the desination uploaded directory
     *
     * @return string
     */
    public function getDirUpload() {

        return $this->dirUpload;
    }

    /**
     * Setting Name of HTML file selected control
     *
     * @param string $inputName
     * @return Hmf_Components_Upload Provides a fluent interface
     */
    public function setInputName($inputName) {

        $this->formInputName = $inputName;

        return $this;
    }

    /**
     * Getting Name of HTML file selected control
     *
     * @return string
     */
    public function getInputName() {

        return $this->formInputName;
    }

    /**
     * Setting allow uploaded file size (in bytes)
     *
     * @param int $value (bytes)
     * @return Hmf_Components_Upload Provides a fluent interface
     */
    public function setAllowSize($value) {

        $this->fileAllowSize = $value;

        return $this;
    }

    /**
     * Getting allow uploaded file size (in bytes)
     *
     * @return int (bytes)
     */
    public function getAllowSize() {

        return $this->fileAllowSize;
    }

    /**
     * Setting allowed mime-type
     *
     * @param $mimeType1 [, $mimeTypeN] or array
     * @return Hmf_Components_Upload Provides a fluent interface
     */
    public function setAllowMimeType($mimeType1) {

        $args = func_get_args();

        if(func_num_args() == 1 and is_array($args[0]))
            $args = $args[0];

        $this->mimeType = array_merge($this->mimeType, $args);

        return $this;
    }

    /**
     * Getting allowed mime-type
     *
     * @return array
     */
    public function getAllowMimeType() {

        return $this->mimeType;
    }

    /**
     * Setting allowed extension files
     *
     * @param $fileExtension1 [, $fileExtensionN] or array
     * @return Hmf_Components_Upload Provides a fluent interface
     */
    public function setAllowFileExtension($fileExtension1) {

        $args = func_get_args();

        if(func_num_args() == 1 and is_array($args[0]))
            $args = $args[0];

        $this->fileExtension = array_merge($this->fileExtension, $args);

        return $this;
    }

    /**
     * Getting allowed extension files
     *
     * @return array
     */
    public function getAllowFileExtension() {

        return $this->fileExtension;
    }

    /**
     * Setting the destination uploaded filenames
     *
     * @param int $index, index of uploaded files
     * @param string $value
     * @return Hmf_Components_Upload Provides a fluent interface
     */
    public function setDestinationFilesNameUploaded($index, $value) {

        $this->destinationFilesNameUploaded[$index] = $value;

        return $this;
    }

    /**
     * Getting the destination uploaded filenames
     *
     * @return array
     */
    public function getDestinationFilesNameUploaded() {

        return $this->destinationFilesNameUploaded;
    }

    /**
     * Setting the uploaded filenames
     *
     * @param int $index, index of uploaded files
     * @param string $value
     * @return Hmf_Components_Upload Provides a fluent interface
     */
    public function setSourceFilesNameUploaded($index, $value) {

        $this->sourceFilesNameUploaded[$index] = $value;

        return $this;
    }

    /**
     * Getting the uploaded filenames
     *
     * @return array
     */
    public function getSourceFilesNameUploaded() {

        return $this->sourceFilesNameUploaded;
    }

    /**
     * Setting uploaded file size
     *
     * @param int $index, index of uploaded files
     * @param int|double $value
     * @return Hmf_Components_Upload Provides a fluent interface
     */
    public function setFilesSizeUploaded($index, $value) {

        $this->filesSizeUploaded[$index] = $value;

        return $this;
    }

    /**
     * Getting uploaded file size
     *
     * @return array
     */
    public function getFilesSizeUploaded() {

        return $this->filesSizeUploaded;
    }

    /**
     * Setting uploaded mime-type
     *
     * @param int $index, index of uploaded files
     * @param string $value
     * @return Hmf_Components_Upload Provides a fluent interface
     */
    public function setFilesMimeTypeUploaded($index, $value) {

        $this->filesMimeTypeUploaded[$index] = $value;

        return $this;
    }

    /**
     * Getting uploaded mime-type
     *
     * @return array
     */
    public function getFilesMimeTypeUploaded() {

        return $this->filesMimeTypeUploaded;
    }

    /**
     * Setting uploaded extension file
     *
     * @param int $index, index of uploaded files
     * @param string $value
     * @return Hmf_Components_Upload Provides a fluent interface
     */
    public function setFilesExtensionUploaded($index, $value) {

        $this->filesExtTypeUploaded[$index] = strtolower($value);

        return $this;
    }

    /**
     * Getting uploaded extension file
     *
     * @return array
     */
    public function getFilesExtensionUploaded() {

        return $this->filesExtTypeUploaded;
    }

    /**
     * Setting destination uploaded file name
     *
     * @param string|array $name
     * @return Hmf_Components_Upload Provides a fluent interface
     */
    public function setDestinationFilesName($name) {

        if (is_array($name))
            $this->destinationFilesName = $name;

        $this->destinationFilesName[ ] = $name;

        return $this;
    }

    /**
     * Getting destination uploaded file name
     *
     * @return array
     */
    public function getDestinationFilesName() {

        return $this->destinationFilesName;
    }

    /**
     * Setting destination uploaded file path
     *
     * @param int $index, index of uploaded files
     * @param string $value
     * @return Hmf_Components_Upload Provides a fluent interface
     */
    public function setDestinationPathFilesUploaded($index, $path) {

        $this->desinationPathFilesUploaded[$index] = $path;

        return $this;
    }

    /**
     * Getting destination uploaded file path
     *
     * @return array
     */
    public function getDestinationPathFilesUploaded() {

        return $this->desinationPathFilesUploaded;
    }

    /**
     * Setting uploaded text status
     *
     * @param int $index, index of uploaded files
     * @param int $code, error code
     * @param string $text
     * @param bool $bool
     * @return Hmf_Components_Upload Provides a fluent interface
     */
    public function setUploadedTextStatus($index, $code, $text, $bool) {

        $this->uploadedStatusText[$index] = array('code' => $code, 'text' => $text, 'bool' => $bool);

        return $this;
    }

    /**
     * Getting uploaded text status
     *
     * @param int $index = null, index of uploaded files
     * @return array
     */
    public function getUploadedTextStatus($index = null) {

        if (is_null($index)) {
            return $this->uploadedStatusText;
        }
        return $this->uploadedStatusText[$index];
    }

    /**
     * Set upload files to destination with overwrite files
     * @return unknown_type
     */
    public function uploadOverwrite() {

        $this->overwrite = true;
        return $this;
    }

    /**
     * Take action for upload the files to destination directory
     *
     * @return Hmf_Components_Upload Provides a fluent interface
     */
    public function action() {

        $destinationFilesName = $this->getDestinationFilesName();
        $inputName = $this->getInputName();

		//print_r($_FILES[$inputName]);

        if (!is_array($_FILES[$inputName]["error"])) {

            //            TODO Fixed for not used HTML array, but it havn't good performance.
            //

            $tmp = $_FILES[$inputName];
			//print_r($tmp);

            unset($_FILES[$inputName]['name']);
            unset($_FILES[$inputName]['type']);
            unset($_FILES[$inputName]['size']);
            unset($_FILES[$inputName]['error']);
            unset($_FILES[$inputName]['tmp_name']);

            $_FILES[$inputName]['name'][0]      = $tmp['name'];
            $_FILES[$inputName]['type'][0]      = $tmp['type'];
            $_FILES[$inputName]['size'][0]      = $tmp['size'];
            $_FILES[$inputName]['error'][0]     = $tmp['error'];
            $_FILES[$inputName]['tmp_name'][0]  = $tmp['tmp_name'];


//            $this->setSourceFilesNameUploaded(0, null);
//            $this->setFilesSizeUploaded(0, null);
//            $this->setFilesMimeTypeUploaded(0, null);
//            $this->setFilesExtensionUploaded(0, null);
//            $this->setDestinationPathFilesUploaded(0, null);
//            $this->isUploaded(0, self::ERR_FILE_INPUTNAME_NOT_USE_HTML_ARRAY);

//            return $this;
        }

        foreach ($_FILES[$inputName]["error"] as $index => $error) {
            /**
             * Assign the file-name and file-extension
             */
            $fileName = $_FILES[$inputName]["name"][$index];

            $fileExt = self::getFileExtension($fileName);

            if ($error != 4) {
                /**
                 * Check error handle with PHP error
                 */
                if ($this->isUploaded($index, $error)) {
                    /**
                     * Check valid mime-type or check extension-file
                     */
                    if ($this->isAllowFileMimeType($_FILES[$inputName]["type"][$index]) or $this->isAllowFileExtension($fileExt)) {

                        /**
                         * Check file size not exceeds
                         */
                        if ($this->isAllowSize($_FILES[$inputName]["size"][$index])) {

                            $tmpPath = $_FILES[$inputName]["tmp_name"][$index];

                            if (array_key_exists($index, $destinationFilesName))
                                $fileName = $destinationFilesName[$index] . '.' . $fileExt;

                            $fileCreate = $this->createFilename($fileName, $this->getDirUpload());

                            copy($tmpPath, $fileCreate['path']);

                            $this->setDestinationPathFilesUploaded($index, $fileCreate['path']);

                        } else {

                            $this->isUploaded($index, self::ERR_FILE_SIZE);
                        }
                    } else {
                        $this->isUploaded($index, self::ERR_FILE_TYPE);
                    }
                }
                $this->setDestinationFilesNameUploaded($index, $fileCreate['name']);
                $this->setSourceFilesNameUploaded($index, $_FILES[$inputName]["name"][$index]);
                $this->setFilesSizeUploaded($index, $_FILES[$inputName]["size"][$index]);
                $this->setFilesMimeTypeUploaded($index, $_FILES[$inputName]["type"][$index]);
                $this->setFilesExtensionUploaded($index, $fileExt);
            }
        }

        return $this;
    }

    /**
     * Getting informations or details from upload action
     *
     * @return unknown
     */
    public function getActionInfo() {

        $result_details['name'] = $this->getSourceFilesNameUploaded();
        $result_details['namedest'] = $this->getDestinationFilesNameUploaded();
        $result_details['destination'] = $this->getDestinationPathFilesUploaded();
        $result_details['size'] = $this->getFilesSizeUploaded();
        $result_details['ext'] = $this->getFilesExtensionUploaded();
        $result_details['mime'] = $this->getFilesMimeTypeUploaded();
        $result_details['status'] = $this->getUploadedTextStatus();

        return $result_details;
    }

    /**
     * Check allow file extension
     *
     * @param string $fileExtension
     * @return bool
     */
    public function isAllowFileExtension($fileExtension) {

        $ext = $this->getAllowFileExtension();
        return in_array(strtolower($fileExtension), $ext);
    }

    /**
     * Check allow file mime type
     *
     * @param string $fileMimeType
     * @return bool
     */
    public function isAllowFileMimeType($fileMimeType) {

        $mimeType = $this->getAllowMimeType();
        return in_array($fileMimeType, $mimeType);
    }

    /**
     * Check allow file size
     *
     * @param int $value
     * @return bool
     */
    public function isAllowSize($value) {

        return ($value <= $this->getAllowSize() ? true : false);
    }

    /**
     * Assign status in uploaded file to text status.
     *
     * @param int $index, index of uploaded file
     * @param int $value, error code
     * @return bool
     */
    public function isUploaded($index, $errorCode) {

        switch ($errorCode) {
            case UPLOAD_ERR_OK :
                $this->setUploadedTextStatus($index, $errorCode, $this->_t("Upload completed."), true);
                return true;
            case UPLOAD_ERR_INI_SIZE :
                $upload_max_filesize = ini_get('upload_max_filesize');
                $this->setUploadedTextStatus($index, $errorCode, $this->_s("The uploaded file size exceeds, limit of %1s.", self::fileSizeConvert($upload_max_filesize)), false);
                return false;
            case UPLOAD_ERR_FORM_SIZE :
                $this->setUploadedTextStatus($index, $errorCode, $this->_t("The uploaded file size exceeds from MAX_FILE_SIZE in HTML/XHTML form"), false);
                return false;
            case UPLOAD_ERR_PARTIAL :
                $this->setUploadedTextStatus($index, $errorCode, $this->_t("The uploaded file was only partially uploaded."), false);
                return false;
            case UPLOAD_ERR_NO_FILE :
                $this->setUploadedTextStatus($index, $errorCode, $this->_t("No file was uploaded."), false);
                return false;
            case UPLOAD_ERR_NO_TMP_DIR :
                $this->setUploadedTextStatus($index, $errorCode, $this->_t("Missing a temporary directory."), false);
                return false;
            case UPLOAD_ERR_CANT_WRITE :
                $this->setUploadedTextStatus($index, $errorCode, $this->_t("Failed to write file to disk."), false);
                return false;
            case UPLOAD_ERR_EXTENSION :
                $this->setUploadedTextStatus($index, $errorCode, $this->_t("File upload stopped by extension."), false);
                return false;
            case self::ERR_FILE_SIZE :
                $this->setUploadedTextStatus($index, $errorCode, $this->_s("The uploaded file size exceeds, limit of %1s.", self::fileSizeConvert($this->getAllowSize())), false);
                return false;
            case self::ERR_FILE_TYPE :
                $this->setUploadedTextStatus($index, $errorCode, $this->_t("ไฟล์ประกอบชนิดนี้ไม่อนุญาติให้อัพโหลด"), false);
                return false;
            case self::ERR_FILE_INPUTNAME_NOT_USE_HTML_ARRAY :
                $this->setUploadedTextStatus($index, $errorCode, $this->_t("The HTML file control not use HTML array."), false);
                return false;
            default :
                $this->setUploadedTextStatus($index, null, $this->_t("An unknown file upload error occured."), false);
                return false;
        }
    }

    /**
     * Get file extension
     *
     * @param string $filename
     * @return string
     */
    public static function getFileExtension($filename) {

        return getFileExtension($filename);
    }

    /**
     * Get convert file size from something (default byte(s)) to International System of Units (SI) (byte(s), KB, MB, GB, TB, PB, EB)
     *
     * @param integer $value
     * @param string $fromType
     * @return string
     */
    public static function fileSizeConvert($size, $fromType = "b") {

        return fileSizeConvert($size, $fromType);
    }

    /**
     * Create a full file path from a directory and filename. If a file with the
     * specified name already exists, an alternative will be used.
     *
     * @param string $baseName filename
     * @param string $directory directory
     * @return
     */
    public function createFilename($baseName, $directory) {

        $out['path'] = $directory .'/'. $baseName;
        $out['name'] = $baseName;

        if($this->overwrite and file_exists($out['path']))
            unlink($out['path']);

        if (file_exists($out['path'])) {
            // Destination file already exists, generate an alternative.
            if ($pos = strrpos($baseName, '.')) {
                $name = substr($baseName, 0, $pos);
                $ext = substr($baseName, $pos);
            } else {
                $name = $baseName;
            }

            $counter = 0;
            do {

                $out['name'] = $name .'_'. $counter++ . $ext;

                $out['path'] = $directory .'/'. $out['name'];

            } while (file_exists($out['path']));

        }

        return $out;
    }

    /**
     * Translate string
     * @param $str
     * @return string
     */
    public static function _t($str) {

        return $str;
    }
    /**
     * Formatting translation string
     *
     * @param string $s1 format for sprintf function
     * @param string $s2[,... $sN] unlimited number of additional argument for sprintf function
     * @return string
     */
    public static function _s() {

        $numArgs = func_num_args();
        if ($numArgs > 0) {
            $args = func_get_args();
            $args[0] = self::_t($args[0]);
            return call_user_func_array('sprintf', $args);
        }
        return null;
    }
}