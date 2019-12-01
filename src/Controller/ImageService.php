<?php
namespace App\Controller;

use \Imagine;
use \Imagine\Image\Point;
use \Imagine\Image\ImageInterface;


class ImageService{

    /**
     * @var string $outputDir
     */
    static $outputDir = "resize/";

    /**
     * @var string $sourceDir
     */
    static $sourceDir = "data/images/";


    /**
     * @var string $sourceFile
     */
    private $sourceFile;

    /**
     * @var int height
     * 
     */
    private $height;

    /**
     * @var int width
     * 
     */
    private $width;

    public function __construct($sourceFile, $width, $height){        

        $this->sourceFile = $sourceFile;
        $this->height = $height;
        $this->width = $width;

    }

    public static function generate($sourceFile, $width, $height){                
        if(file_exists('data/resize/' . basename($sourceFile))) return;
        else return;
        $newImage = new Imagine\Gd\Imagine();
        $newImage->open($sourceFile)
        ->resize(new Imagine\Image\Box($width,$height))
        ->save('data/resize/' . basename($sourceFile));
    }

} 