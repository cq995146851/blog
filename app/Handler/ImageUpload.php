<?php
/**
 * Created by PhpStorm.
 * User: 陈骞
 * Date: 2018/11/13
 * Time: 14:47
 */

namespace App\Handler;

use Intervention\Image\ImageManagerStatic as Image;

class ImageUpload
{
    //允许的图片类型
    protected $allowed_ext = ["png", "jpg", "gif", 'jpeg'];

    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        //文件存储路径
        $folder_name = "uploads/images/$folder/" . date("Ym",
                time()) . '/'.date("d", time()).'/';
        //硬盘完整存储路径
        $upload_path = public_path() . '/' . $folder_name;
        //确保文件后缀存在
        $ext = strtolower($file->getClientOriginalExtension()) ?: 'png';
        //拼接文件名
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $ext;
        // 如果上传的不是图片将终止操作
        if (!in_array($ext, $this->allowed_ext)) {
            return false;
        }
        // 将图片移动到我们的目标存储路径中
        $file->move($upload_path, $filename);
        // 如果限制了图片宽度，就进行裁剪
        if ($max_width && $ext != 'gif') {
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }
        return [
            'path' => asset($folder_name . '/' . $filename),
        ];
    }

    private function reduceSize($file_path, $max_width)
    {
        // 先实例化，传参是文件的磁盘物理路径
        Image::make($file_path)
            ->resize($max_width, null, function ($constraint) {
                // 设定宽度是 $max_width，高度等比例双方缩放
                $constraint->aspectRatio();
                // 防止裁图时图片尺寸变大
                $constraint->upsize();
            })
            ->save();
    }

}