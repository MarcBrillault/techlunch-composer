<?php

namespace Techlunch;

class Gallery
{
    const DIR = __DIR__ . '/../resources/images/';

    /**
     * Lists all images in the given directory
     *
     * @return array
     */
    public function list()
    {
        $return = [];
        $list   = scandir(self::DIR);
        sort($list, SORT_NUMERIC);
        foreach ($list as $file) {
            if (is_dir(self::DIR . $file)) {
                continue;
            }
            if (exif_imagetype(self::DIR . $file) !== false) {
                $imageNumber = intval($file);
                $return[]    = [
                    'thumbnail' => $this->_getFilename($imageNumber, true),
                    'image'     => $this->_getFilename($imageNumber, false),
                ];
            }
        }

        return $return;
    }

    private function _getFilename(int $id, bool $thumbnail = false): string
    {
        $prefix = ($thumbnail) ? 'thumbnail' : 'image';

        return sprintf('/%s-%d.jpg', $prefix, $id);
    }
}