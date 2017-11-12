<?php

namespace Techlunch;

use Intervention\Image\ImageManager;

class Image
{
    /**
     * @var int
     */
    private $number;

    /**
     * @var bool
     */
    private $isThumbnail;

    /**
     * @var \Intervention\Image\ImageManager
     */
    private $imageManager;

    const THUMBNAIL_SIZE = [
        'x' => 400,
        'y' => 300,
    ];

    const IMAGE_SIZE = [
        'x' => 800,
        'y' => 600,
    ];

    const DIR       = __DIR__ . '/../resources/images/';
    const IMAGEPATH = '%d.jpg';

    /**
     * Image constructor.
     *
     * @param int  $number
     * @param bool $thumbnail
     * @return void
     */
    public function __construct(int $number, bool $thumbnail = false)
    {
        $this->number       = $number;
        $this->isThumbnail  = $thumbnail;
        $this->imageManager = new ImageManager();
    }

    public function render()
    {
        $sizes = ($this->isThumbnail) ? self::THUMBNAIL_SIZE : self::IMAGE_SIZE;
        $image = $this->imageManager->make($this->_getFileName($this->number));

        if ($this->isThumbnail) {
            return $image
                ->fit(self::THUMBNAIL_SIZE['x'], self::THUMBNAIL_SIZE['y'])
                ->response('jpg', 100);
        }

        return $image
            ->resize(self::IMAGE_SIZE['x'], self::IMAGE_SIZE['y'], function ($constraint) {
                $constraint->aspectRatio();
            })
            ->response('jpg', 100);
    }

    private function _getFileName(int $number): string
    {
        return self::DIR . sprintf(self::IMAGEPATH, $number);
    }
}