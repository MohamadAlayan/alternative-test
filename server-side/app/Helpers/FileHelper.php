<?php

namespace App\Helpers;

use App\Enums\AttachmentType;
use App\Models\Attachment\Attachment;
use App\Repositories\Attachment\AttachmentRepository;
use Exception;
use Intervention\Image\Facades\Image;


class FileHelper
{
    /**
     * This function is used to upload image
     * @param $file
     * @param $user_id
     * @param $attachment_type_id
     * @param bool $is_private
     * @return Attachment
     * @throws Exception
     */
    public static function uploadImage($file, $user_id, $attachment_type_id, bool $is_private = false): Attachment
    {
        try {
            // Get file contents
            $contents = file_get_contents($file);

            // Generate a hash of the file
            $hash = md5($contents);

            // get original file name and extension
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $typePath = AttachmentType::getPath($attachment_type_id);

            // path
            $path = public_path('/storage/' . $typePath . '/' . $hash . '/');
            $attachmentRepository = new AttachmentRepository();
            $attachment = $attachmentRepository->getAttachment($filename, $hash, $attachment_type_id);

            // if directory exist
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // check if file exist
            if (!file_exists($path . $filename . '.' . $extension)) {
                $fileNameToStore = $filename . '.' . $extension;

                // save file
                $file->move($path, $fileNameToStore);

                // Create thumbnail
                $thumbnail = Image::make($path . $fileNameToStore);
                $thumbnail->resize(150, 150);
                $thumbnail->save($path . $filename . '_thumb.' . $extension);

                // if image extension is not webp
                if ($extension != 'webp') {
                    // convert to webp
                    $webp = Image::make($path . $fileNameToStore);
                    $webp->encode('webp');
                    $webp->save($path . $filename . '.webp');

                    // create thumbnail for webp
                    $webpThumbnail = Image::make($path . $fileNameToStore);
                    $webpThumbnail->resize(150, 150);
                    $webpThumbnail->encode('webp');
                    $webpThumbnail->save($path . $filename . '_thumb.webp');
                }
                if (!$attachment) {
                    $attachment = $attachmentRepository->create([
                        'filename' => $filename,
                        'file_hash' => $hash,
                        'file_path' => $path,
                        'mime_type' => $file->getClientMimeType(),
                        'size' => $file->getSize(),
                        'extension' => $extension,
                        'attachment_type_id' => $attachment_type_id,
                        'user_id' => $user_id,
                        'is_private' => $is_private
                    ]);
                }

            }
            return $attachment;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
