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
 * Hmf_Img
 *
 * @package     Hmf
 * @category    Img
 * @author      Ford AntiTrust
 * @link        http://www.fordantitrust.com
 *
 */
class Hmf_Img {

    private $filePath;

    private $hasFile = false;

    public function __construct($filePath = '.') {

        self::setFilePath($filePath);
    }

    /**
     * Call this method to specified the path of the image file
     *
     * @param string $file the path of the image file
     * @return Hmf_Components_Img Provides a fluent interface
     */
    public function setFilePath($file) {

        if (file_exists($file)) {
            $this->filePath = $file;
            $this->hasFile = true;
        } else {
            $this->hasFile = false;
        }
        return $this;
    }

    /**
     * Call this method to retrieve the path of a specified file.
     *
     * @return string the path of specify by Constructor method or setFilePath method
     */
    public function getFilePath() {

        return $this->filePath;
    }

    /**
     * Checked the file path exist.
     *
     * @return bool TRUE if file exist OR FALSE file not exist.
     */
    public function hasFile() {

        return $this->hasFile;
    }

    /**
     * The scale method for enlarges or reduces the image.
     * It changes the scale of the image content.
     * It also gives you informations about the size
     * and the resolution your image will have when printed.
     *
     * @param int $width Width of the output image
     * @param int $height Height of the output image
     * @param string $outputFilePath file path for the result
     * @return bool TRUE on success or FALSE on failure.
     */
    public function scale($width, $height, $outputFilePath) {

        if (!$this->hasFile())
            return false;

        $inputFilePath = $this->getFilePath();
        // Get image file info
        $imageInfo = getImageSize($inputFilePath);
        // Get new dimensions
        $widthOriginal = $imageInfo[0]; // width
        $heightOriginal = $imageInfo[1]; // height
        if ($width && ($widthOriginal < $heightOriginal)) {
            $width = ($height / $heightOriginal) * $widthOriginal;
        } else {
            $height = ($width / $widthOriginal) * $heightOriginal;
        }
        // Content type
        switch ($imageInfo['mime']) {
            case 'image/gif' :
                $image_p = imagecreatetruecolor($width, $height);
                $image = imagecreatefromgif($inputFilePath);
                if (imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $widthOriginal, $heightOriginal)) { // Resample
                    if (imagegif($image_p, $outputFilePath, 100)) { // Output
                        return true;
                    }
                }
                break;
            case 'image/jpeg' :
                $image_p = imagecreatetruecolor($width, $height);
                $image = imagecreatefromjpeg($inputFilePath);
                if (imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $widthOriginal, $heightOriginal)) { // Resample
                    if (imagejpeg($image_p, $outputFilePath, 100)) { // Output
                        return true;
                    }
                }
                break;
            case 'image/png' :
                $image_p = imagecreatetruecolor($width, $height);
                if (imagealphablending($image_p, false)) {
                    $image = imagecreatefrompng($inputFilePath);
                    if (imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $widthOriginal, $heightOriginal)) { // Resample
                        if (imagesavealpha($image_p, true)) { //  full alpha channel
                            if (imagepng($image_p, $outputFilePath, 0)) { // Output
                                return true;
                            }
                        }
                    }
                }
                break;
        }
        return false;
    }
}
?>