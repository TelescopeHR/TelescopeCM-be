<?php
namespace App\Traits;

use Image;
use DateTime;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    /**
     * @param array $options
     * @return mixed
     * @throws \Exception
     */
    public function save(array $options = [])
    {
        $this->fillFiles(request()->allFiles());

        return parent::save($options);
    }

    /**
     * @return mixed
     */
    public function delete()
    {
        $this->deleteDirectory();

        return parent::delete();
    }

    /**
     * @param $field
     * @return bool
     */
    public function isFileField($field)
    {
        return !empty($this->files[$field]);
    }

    /**
     * @param $field
     * @return bool
     */
    public function isImageField($field)
    {
        $type = $this->files[$field] ?? null;

        return !empty($type) && $type == 'image';
    }

    /**
     * @param $field
     * @return object
     */
    public function getUrls($field)
    {
        return (object) [
            'file' => $this->getFileUrl($field),
            'thumbnail' => $this->getThumbnailUrl($field),
        ];
    }

    /**
     * @param $field
     * @return mixed
     */
    public function getFileUrl($field)
    {
        return $this->getAttribute($field)
            ? Storage::url($this->getFilePath($field))
            : null;
    }

    /**
     * @param $field
     * @return mixed
     */
    public function getThumbnailUrl($field)
    {
        return $this->getAttribute($field)
            ? Storage::url($this->getThumbnailPath($field))
            : null;
    }

    /**
     * @param $files
     * @return $this
     * @throws \Exception
     */
    public function fillFiles($files)
    {
        if (empty($this->files)) {
            return $this;
        }

        foreach ($this->files as $field => $type) {
            if (!empty($files[$field])) {
                $this->deleteFile($field);
                $this->saveFile($files[$field], $field, $type);
            }
        }

        return $this;
    }

    /**
     * @param $file
     * @param $field
     * @param $type
     * @return string
     * @throws \Exception
     */
    public function saveFile($file, $field, $type)
    {
        $fileName = $this->getFileName($file, $field);

        $file->storeAs($this->getDirectoryPath(), $fileName);
        $this->$field = $fileName;

        if ($type == 'image') {
            $this->saveThumbnail($file, $field);
        }

        return $fileName;
    }

    /**
     * @param $file
     * @param $field
     */
    public function saveThumbnail($file, $field)
    {
        $image = Image::make($file);
        $width = $image->width();
        $height = $image->height();

        $newSize = config('files.thumbnails');
        $newWidth = $newSize['width'];
        $newHeight = $newSize['height'];

        if ($width > $height) {
            $newHeight = (int) ($newWidth / $width * $height);
        } else {
            $newWidth = (int) ($newHeight / $height * $width);
        }

        $image->resize($newWidth, $newHeight)
            ->save($this->getThumbnailPath($field, false));
    }

    /**
     * @param $field
     */
    public function deleteFile($field)
    {
        if (!empty($this->$field)) {
            Storage::delete([$this->getFilePath($field), $this->getThumbnailPath($field)]);
        }
    }

    /**
     * return null
     */
    public function deleteDirectory()
    {
        Storage::deleteDirectory($this->getDirectoryPath());
    }

    /**
     * @param bool $public
     * @return string
     */
    public function getDirectoryPath($public = true)
    {
        $paths = config('files.paths');

        return ($public ? $paths['public'] : $paths['storage']) . '/'
            . $this->getDirectoryName() . '/'
            . $this->getRecordKey();
    }

    /**
     * @param $field
     * @return string
     */
    public function getFilePath($field)
    {
        return $this->getDirectoryPath() . '/'
            . $this->$field;
    }

    /**
     * @param $field
     * @param bool $public
     * @return string
     */
    public function getThumbnailPath($field, $public = true)
    {
        $prefix = config('files.thumbnails.prefix');

        return $this->getDirectoryPath($public) . '/'
            . $prefix . $this->$field;
    }

    /**
     * @return string
     */
    public function getDirectoryName()
    {
        return Str::lower(class_basename(get_class($this)));
        //return Str::lower(get_class($this))->basename();
    }

    /**
     * @param $file
     * @param $field
     * @return string
     * @throws \Exception
     */
    public function getFileName($file, $field)
    {
        $time = new DateTime('now');
        $timestamp = $time->getTimestamp() ;

        return $field . '-' . $timestamp . '.' . $file->extension();
    }

    /**
     * @return mixed
     */
    public function getNextKey()
    {
        $statement = DB::select("SHOW TABLE STATUS LIKE '" . $this->getTable() . "'");
        return $statement[0]->Auto_increment;
    }

    /**
     * @return mixed
     */
    public function getRecordKey()
    {
        return $this->getKey() ?? $this->getNextKey();
    }
}