<?php
namespace App\Handlers;

use Image;//laravel扩展包发现, 在其vendor中composer.json中extra有设置facade

class ImageUploadHandler {
    protected $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    public function save($file, $folder, $filePrefix, $maxWidth = false) {
        $destFolder = 'uploads/images/' . $folder . '/' . date('YmdHis', time());
		$uploadPath = public_path() . '/' . $destFolder;
		$extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
		$filename = $filePrefix . '_' . time() . '_' . uniqid() . '.' . $extension;
	
		if(! in_array($extension, $this->allowed)) {
			return false;
		}

        $file->move($uploadPath, $filename);

		if($maxWidth && $extension != 'gif') {
			$this->reduceSize($destFolder . '/' . $filename, $maxWidth);
		}

		return [
			'path' => config('app.url') . '/' . $destFolder . '/' . $filename
		];
    }

	public function reduceSize($filePath, $maxWidth) {
		$image = Image::make($filePath);

		$image->resize($maxWidth, null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
				});

		$image->save();
	}
}
