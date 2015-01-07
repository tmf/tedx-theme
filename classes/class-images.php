<?php
/**
 * @autor     Tom Forrer <tom.forrer@gmail.com>
 * @copyright Copyright (c) 2014 Tom Forrer (http://github.com/tmf)
 */

namespace TEDxZurich\Theme;
use Tmf\Wordpress\Container\HookableService;

/**
 * Class Images
 *
 * @package TEDxZurich\Theme
 */
class Images extends HookableService
{
    public function initialize()
    {
        add_image_size('wide-1x', 188, 85, true);
        add_image_size('wide-2x', 376, 170, true);
        add_image_size('wide-3x', 564, 255, true);
        add_image_size('wide-4x', 752, 340, true);
        add_image_size('wide-5x', 940, 425, true);
        add_image_size('wide-10x', 1860, 850, true);
        add_image_size('normal-1x', 146, 100, true);
        add_image_size('normal-2x', 292, 200, true);
        add_image_size('normal-3x', 438, 300, true);
        add_image_size('normal-4x', 584, 400, true);

        add_image_size('legacy-gallery-image', 770, 578, true);
        add_image_size('legacy-thumbnail-sidebar', 138, 138, true);
        add_image_size('legacy-post-featured-image', 410, 210, true);
        add_image_size('legacy-post-full-image', 586, 210, true);
        add_image_size('legacy-talk-front', 940, 425, true);
        add_image_size('legacy-talk-thumbnail', 394, 270, true);
    }

    /**
     * get the attachment html with responsive sizes and srcsets for the picturefill (or browsers supporting srcset/sizes)
     *
     * @see http://scottjehl.github.io/picturefill/
     * @see http://martinwolf.org/2014/05/07/the-new-srcset-and-sizes-explained/
     *
     * @param int $attachmentId the attachment id
     * @param string $size the default size in the src attribute
     * @param array $imageSizes all the sizes to include
     * @param array $sizeLengths all the responsive sizes where the key is a mediaquery (without parentheses) and the value the corresponding image size (commonly referred to as 'length')
     * @return string the image html
     */
    public function getResponsiveAttachment($attachmentId, $size, $imageSizes = array(), $sizeLengths = array())
    {
        $responsiveImage = '';
        if ($attachmentId) {
            $intermediateSizes = $this->getIntermediateImageSizes();
            $srcSets = [];
            foreach ($imageSizes as $aSize) {
                list($url, $width, $height) = wp_get_attachment_image_src($attachmentId, $aSize);
                // require image width to be equal to the configured width, but not height if the configured height is 0
                if ($url && intval($width) > 0 && $width == $intermediateSizes[$aSize]['width'] && (intval($intermediateSizes[$aSize]['height']) == 0 ||  $height == $intermediateSizes[$aSize]['height'])) {
                    $srcSets[] = sprintf('%s %sw', $url , $width);
                }
            }

            $attributes = [
                'srcset' => implode(', ', $srcSets),
                'sizes' => implode(', ', $sizeLengths),
            ];

            $responsiveImage = wp_get_attachment_image($attachmentId, $size, false, $attributes);
            list($url, $width, $height) = wp_get_attachment_image_src($attachmentId, $size);
            $responsiveImage = str_replace(image_hwstring($width, $height), '', $responsiveImage);
        }
        return $responsiveImage;
    }

    /**
     * @return array
     */
    public function getIntermediateImageSizes(){
        global $_wp_additional_image_sizes;
        return $_wp_additional_image_sizes;
    }
}