<?php
final class Image {
	private $file;
	private $image;
	private $info;
    private $isAnimated = false;
    private $imagick = null;

    private $backgroundColor = array(0, 0, 0);

	public function __construct($file,$gifCheck=true) {
		if (file_exists($file)) {
			$this->file = $file;

            if ( $gifCheck && $this->isGifAnimated( $this->file ) ) {
                $this->isAnimated = true;
            }

			$info = getimagesize($file);

			$this->info = array(
            	'width'  => $info[0],
            	'height' => $info[1],
            	'bits'   => $info['bits'],
            	'mime'   => $info['mime']
			);

			$this->image = $this->create($file);
		} else {
			exit('Error: Could not load image ' . $file . '!');
		}
	}

	private function create($image) {
		$mime = $this->info['mime'];

		if ($mime == 'image/gif') {
			return imagecreatefromgif($image);
		} elseif ($mime == 'image/png') {
			return imagecreatefrompng($image);
		} elseif ($mime == 'image/jpeg') {
			return imagecreatefromjpeg($image);
		}
	}

	public function save($file, $quality = 75) {
		$info = pathinfo($file);

		$extension = strtolower($info['extension']);
        $success = false;

        if ($extension == 'jpeg' || $extension == 'jpg') {
            $success = imagejpeg($this->image, $file, $quality);
        } elseif($extension == 'png') {
            $success = imagepng($this->image, $file, 0);
        } elseif($extension == 'gif') {
            if ($this->isAnimated) {
                if ($this->imagick) {
                    $success = $this->imagick->writeImages($file, true);
                    $this->imagick->clear();
                    $this->imagick->destroy();
                } else {
                    $success = rename($this->file, $file);
                }
            } else {
                $success = imagegif($this->image, $file);
            }
        }

		imagedestroy($this->image);

        return $success;
	}

    public function setBackgroundColor($r = 0, $g = 0, $b = 0) {
        $this->backgroundColor = array($r, $g, $b);
    }

    public function shrink($width = 0, $height = 0, $enlarge=false) {
        //$scale = $this->getScale($width, $height);

        //if ($scale > 1) {
        //    $scale = 1;
        //}

        //$this->resizeWithScale($this->info['width'] * $scale, $this->info['height'] * $scale, $scale);
        //$this->resizeWithScaleExact($width, $height, 1);

        //$this->resizeWithScale($width, $height, $scale);

		//$scale=$width/$height;
        //$this->resizeWithScale($this->info['width'] * $scale, $this->info['height'] * $scale, $scale);

		$s_ratio = $this->info['width']/$this->info['height'];
		$d_ratio = $width/$height;

        if ( $s_ratio > $d_ratio )
        {
            $cwidth = $this->info['width'];
            $cheight = round($this->info['width']*(1/$d_ratio));
        }
        elseif( $s_ratio < $d_ratio )
        {
            $cwidth = round($this->info['height']*$d_ratio);
            $cheight = $this->info['height'];
        }
        else
        {
            $cwidth = $this->info['width'];
            $cheight = $this->info['height'];
        }

		if ( ($this->info['width']<=$width) && ($this->info['height']<=$height)  && !$enlarge )
		{
			$this->resizeWithScaleExact($cwidth, $cheight, 1);
		}
		else
		{
	        $this->resizeWithScaleExact($width, $height, 1);
		}
    }
	//TODO
    public function crop($width = 0, $height = 0) {
        $scale = $this->getScale($width, $height);
        //
        //if ($scale > 1) {
        //    $scale = 1;
        //}
		//$scale=$width/$height;
        //$this->resizeWithScale($this->info['width'] * $scale, $this->info['height'] * $scale, $scale);

//		$s_ratio = $this->info['width']/$this->info['height'];
//		$d_ratio = $width/$height;
//
//        if ( $s_ratio > $d_ratio )
//        {
//            $cwidth = $this->info['width'];
//            $cheight = round($this->info['width']*(1/$d_ratio));
//        }
//        elseif( $s_ratio < $d_ratio )
//        {
//            $cwidth = round($this->info['height']*$d_ratio);
//            $cheight = $this->info['height'];
//        }
//        else
//        {
//            $cwidth = $this->info['width'];
//            $cheight = $this->info['height'];
//        }
//
//		if ( ($this->info['width']<=$width) && ($this->info['height']<=$height) )
//		{
//			$this->resizeWithScaleCrop($cwidth, $cheight, $scale);
//		}
//		else
//		{
	        $this->resizeWithScaleCrop($width, $height);
		//}
    }

	public function resizeWithBackground($width = 0, $height = 0) {
        $scale = $this->getScale($width, $height);
		//if ($scale == 1) {
		//	return;
		//}
        $this->resizeWithScale($width, $height, $scale);
	}

    public function resizeWithNoBackground($width, $height) {
        $scale = $this->getScale($width, $height);
		if ($scale == 1) {
			return;
		}
        $this->resizeWithScale($this->info['width'] * $scale, $this->info['height'] * $scale, $scale);
    }

    public function getWidth() {
        return $this->info['width'];
    }

    public function getHeight() {
        return $this->info['height'];
    }

    private function getScale($width, $height) {
        return min($width / $this->info['width'], $height / $this->info['height']);
    }

    private function resizeWithScale($width, $height, $scale) {
		$new_width = (int)($this->info['width'] * $scale);
		$new_height = (int)($this->info['height'] * $scale);
		$xpos = (int)(($width - $new_width) / 2);
		$ypos = (int)(($height - $new_height) / 2);

        if (isset($this->info['mime']) && $this->info['mime'] == 'image/gif' && $this->isAnimated) {
            $this->imagick = new Imagick($this->file);
            $this->imagick = $this->imagick->coalesceImages();
            foreach ($this->imagick as $frame) {
                $frame->thumbnailImage($new_width, $new_height);
                $frame->setImagePage($new_width, $new_height, 0, 0);
            }
        } else {
            $image_old = $this->image;
            $this->image = imagecreatetruecolor($width, $height);
            $bcg = $this->backgroundColor;

            if (isset($this->info['mime']) && $this->info['mime'] == 'image/png') {
                imagealphablending($this->image, false);
                imagesavealpha($this->image, true);
                $background = imagecolorallocatealpha($this->image, $bcg[0], $bcg[1], $bcg[2], 127);
                imagecolortransparent($this->image, $background);
            } else {
                $background = imagecolorallocate($this->image, $bcg[0], $bcg[1], $bcg[2]);
            }

            imagefilledrectangle($this->image, 0, 0, $width, $height, $background);
            imagecopyresampled($this->image, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $this->info['width'], $this->info['height']);
            imagedestroy($image_old);
        }

		$this->info['width']  = $width;
		$this->info['height'] = $height;
    }

    private function resizeWithScaleExact($width, $height, $scale) {
		//$new_width = (int)($this->info['width'] * $scale);
		//$new_height = (int)($this->info['height'] * $scale);
		$new_width = $width * $scale;
		$new_height = $height * $scale;
		$xpos = 0;//(int)(($width - $new_width) / 2);
		$ypos = 0;//(int)(($height - $new_height) / 2);

        if (isset($this->info['mime']) && $this->info['mime'] == 'image/gif' && $this->isAnimated) {
            $this->imagick = new Imagick($this->file);
            $this->imagick = $this->imagick->coalesceImages();
            foreach ($this->imagick as $frame) {
                $frame->thumbnailImage($new_width, $new_height);
                $frame->setImagePage($new_width, $new_height, 0, 0);
            }
        } else {
            $image_old = $this->image;
            $this->image = imagecreatetruecolor($width, $height);
            $bcg = $this->backgroundColor;

            if (isset($this->info['mime']) && $this->info['mime'] == 'image/png') {
                imagealphablending($this->image, false);
                imagesavealpha($this->image, true);
                $background = imagecolorallocatealpha($this->image, $bcg[0], $bcg[1], $bcg[2], 127);
                imagecolortransparent($this->image, $background);
            } else {
                $background = imagecolorallocate($this->image, $bcg[0], $bcg[1], $bcg[2]);
            }

            imagefilledrectangle($this->image, 0, 0, $width, $height, $background);
            imagecopyresampled($this->image, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $this->info['width'], $this->info['height']);
            imagedestroy($image_old);
        }

		$this->info['width']  = $width;
		$this->info['height'] = $height;
    }
	//TODO
    private function resizeWithScaleCrop($width, $height) {
		//$new_width = (int)($this->info['width'] * $scale);
		//$new_height = (int)($this->info['height'] * $scale);
		//$new_width = $width * $scale;
		//$new_height = $height * $scale;
		//$xpos = (int)(($width - $new_width) / 2);
		//$ypos = (int)(($height - $new_height) / 2);

		$d_ratio = $width / $height;
		$s_ratio = $this->info['width'] / $this->info['height'];
		if ( $s_ratio > 1 )
		{
			//if ( $s_ratio < 1 )
			//{
				$scale = $width / $this->info['width'];
				$new_width = $width;
				$new_height = $new_width / $scale;
				$xpos = 0;
				$ypos = ($height - $new_height) / 2;
			//}
			//elseif( $s_ratio > 1 )
			//{
			//	$scale = $width / $this->info['width'];
			//	$new_width = $width;
			//	$new_height = $new_width / $d_ratio;
			//	$xpos = 0;
			//	$ypos = ($height - $new_height) / 2;
			//}
		}
		elseif ( $s_ratio < 1 )
		{
			$scale = $height / $this->info['height'];
			$new_width = $new_height * $scale;
			$new_height = $height;
			$xpos = ($width - $new_width) / 2;
		}

        if (isset($this->info['mime']) && $this->info['mime'] == 'image/gif' && $this->isAnimated) {
            $this->imagick = new Imagick($this->file);
            $this->imagick = $this->imagick->coalesceImages();
            foreach ($this->imagick as $frame) {
                $frame->thumbnailImage($new_width, $new_height);
                $frame->setImagePage($new_width, $new_height, 0, 0);
            }
        } else {
            $image_old = $this->image;
            $this->image = imagecreatetruecolor($width, $height);
            $bcg = $this->backgroundColor;

            if (isset($this->info['mime']) && $this->info['mime'] == 'image/png') {
                imagealphablending($this->image, false);
                imagesavealpha($this->image, true);
                $background = imagecolorallocatealpha($this->image, $bcg[0], $bcg[1], $bcg[2], 127);
                imagecolortransparent($this->image, $background);
            } else {
                $background = imagecolorallocate($this->image, $bcg[0], $bcg[1], $bcg[2]);
            }

            imagefilledrectangle($this->image, 0, 0, $width, $height, $background);
            imagecopyresampled($this->image, $image_old, 0, 0, $xpos, $ypos, $new_width, $new_height, $this->info['width'], $this->info['height']);
            //imagecopyresized($this->image, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $this->info['width'], $this->info['height']);
            imagedestroy($image_old);
        }

		$this->info['width']  = $width;
		$this->info['height'] = $height;
    }

    private function isGifAnimated($filename) {
        if(!($fh = @fopen($filename, 'rb')))
            return false;
        $count = 0;
        //an animated gif contains multiple "frames", with each frame having a
        //header made up of:
        // * a static 4-byte sequence (\x00\x21\xF9\x04)
        // * 4 variable bytes
        // * a static 2-byte sequence (\x00\x2C) (some variants may use \x00\x21 ?)

        // We read through the file til we reach the end of the file, or we've found
        // at least 2 frame headers
        while(!feof($fh) && $count < 2) {
            $chunk = fread($fh, 1024 * 100); //read 100kb at a time
            $count += preg_match_all('#\x00\x21\xF9\x04.{4}\x00(\x2C|\x21)#s', $chunk, $matches);
        }

        fclose($fh);
        return $count > 1;
    }
}
