<?php
namespace ITECH\Cdn\Controller;

class ImageController extends \ITECH\Cdn\Controller\BaseController
{
    public function uploadMediaAction()
    {
        $response = array();

        $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_SUCCESS;
        $response['message'] = 'Success.';

        if ($this->request->isPost()) {

            $resource = $this->request->getPost('resource');
            $content = $this->request->getPost('content');

            if ($content == '' || $resource == '') {
                $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR;
                $response['message'] = 'Parameter is invalid.';
            }  else {
                @mkdir(ROOT . $this->config->application->dir_upload . date('Y'), 0777);
                @mkdir(ROOT . $this->config->application->dir_upload . date('Y') . '/' . date('m'), 0777);
                @mkdir(ROOT . $this->config->application->dir_upload . '/' . 'thumbnail/' . date('Y'), 0777);
                @mkdir(ROOT . $this->config->application->dir_upload . '/' . 'thumbnail/' . date('Y') . '/' . date('m'), 0777);

                $dir = ROOT . $this->config->application->dir_upload . date('Y') . '/' . date('m');
                $dir_thumbnail = ROOT . $this->config->application->dir_upload . '/' . 'thumbnail/' . date('Y') . '/' . date('m');
                $file_name = uniqid() . '_' . time();
                $extension = '.' . $resource['extension'];

                $file = $dir . '/org' . $file_name . $extension;

                if (isset($file)) {
                    $h = fopen($file, 'w');

                    if (!$h) {
                        $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR;
                        $response['message'] = 'Error, cannot create file.';
                    } else {
                        if (!fwrite($h, $content)) {
                            $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR;
                            $response['message'] = 'Error, cannot create file.';
                        } else {
                            fclose($h);
                            $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_SUCCESS;
                            $response['message'] = 'Create file successfully.';
                            $response['file_name'] = $file_name . $extension;

                            $response['result'] = $this->processImage($file, $dir, $dir_thumbnail, $file_name, $extension);
                        }
                    }
                } else {
                    $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR;
                    $response['message'] = 'Error, cannot create file.';
                }
            }
        } else {
            $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR;
            $response['message'] = 'Invalid POST request.';
        }

        parent::outputJSON($response);
    }

    function processImage($file, $dir, $dir_thumbnail, $file_name, $extension)
    {
        $newFile = '';
        if (file_exists($file)) {
            $newFile = $dir.  $file_name. '.' . $extension;
            copy($file, $newFile);
        }
        if (file_exists($newFile)) {
            $u = new \ITECH\Data\Lib\Upload($newFile);

            $u->allowed = array('image/*');
            $u->forbidden = array('application/*');
            $fileName = $file_name;
            $scaleX = 2048;
            $sizeThumbnail = 500;

            $_width = $u->image_src_x;

            try {
                if (!$u->uploaded) {
                    $response = array(
                        'status' => \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR,
                        'message' => 'Lỗi, không thể upload.'
                    );
                } else {
                    if ($u->file_is_image) {
                        if ($scaleX < $_width) {
                            $u->image_resize = true;
                            $u->image_x = $scaleX;
                            $u->image_ratio_y = true;
                        }
                        $u->jpeg_quality = 100;
                        $u->file_new_name_body = $fileName;
                        $u->image_watermark = ROOT . $this->config->application->dir_upload . '/' . 'wtm.png';
                        $u->image_watermark_x = 5;
                        $u->image_watermark_y = 5;
                        $u->process($dir);

                        if ($u->processed) {
                            $_fileName = $fileName . '.' . $u->file_src_name_ext;

                            $response = array(
                                'status' => \ITECH\Data\Lib\Constant::STATUS_CODE_SUCCESS,
                                'message' => 'Upload thành công.',
                                'result' => array(
                                    'full' => $_fileName,
                                    'thumbnail' => ''
                                )
                            );
                        } else {
                            $response = array(
                                'status' => \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR,
                                'message' => 'Lỗi, không thể xử lý hình ảnh',
                                'result' => array(
                                    'full' => 'Xủ lý hình lớn bị lỗi',
                                    'thumbnail' => ''
                                )
                            );
                        }

                        $u->image_resize = true;
                        $u->file_new_name_body = $fileName;
                        $u->image_x = $sizeThumbnail;
                        $u->image_ratio_y = true;
                        $u->process($dir_thumbnail);

                        if ($u->processed) {
                            $fileName .= '.' . $u->file_src_name_ext;
                            $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_SUCCESS;
                            $response['result']['thumbnail'] = $fileName;

                        } else {
                            $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR;
                            $response['message'] = 'Lỗi, không thể xử lý hình ảnh';
                            $response['result']['thumbnail'] = 'Xử lý hình nhỏ bị lỗi';
                        }

                    } else {
                        $response = array(
                            'status' => \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR,
                            'message' => 'Lỗi, không đúng định dạng hình ảnh.'
                        );
                    }

                    $u->clean();
                }
            } catch (\Phalcon\Exception $e) {
                $this->logger->log('[BaseController][uploadImageToLocal] ' . $e->getMessage(), \Phalcon\Logger::ERROR);
                throw new \Phalcon\Exception($e->getMessage());
            }
        } else {
            $response = array(
                'status' => \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR,
                'message' => 'File chưa được tạo.'
            );
        }

        return $response;
    }

    public function uploadAction()
    {
        $response = array();

        $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_SUCCESS;
        $response['message'] = 'Success.';

        if ($this->request->isPost()) {
            $content = $this->request->getPost('content');
            $folder = $this->request->getPost('folder', array('striptags', 'trim'), '');
            $filename = $this->request->getPost('filename', array('striptags', 'trim'), '');

            if ($content == '' || $folder == '' || $filename == '') {
                $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR;
                $response['message'] = 'Parameter is invalid.';
            } else {
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/project/' . date('Y'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/project/' . date('Y') . '/' . date('m'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/project/' . date('Y') . '/' . date('m') . '/' . date('d'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/project/thumbnail/' . date('Y'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/project/thumbnail/' . date('Y') . '/' . date('m'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/project/thumbnail/' . date('Y') . '/' . date('m') . '/' . date('d'), 0777);

                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/block/' . date('Y'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/block/' . date('Y') . '/' . date('m'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/block/' . date('Y') . '/' . date('m') . '/' . date('d'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/block/thumbnail/' . date('Y'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/block/thumbnail/' . date('Y') . '/' . date('m'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/block/thumbnail/' . date('Y') . '/' . date('m') . '/' . date('d'), 0777);

                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/apartment/' . date('Y'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/apartment/' . date('Y') . '/' . date('m'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/apartment/' . date('Y') . '/' . date('m') . '/' . date('d'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/apartment/thumbnail/' . date('Y'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/apartment/thumbnail/' . date('Y') . '/' . date('m'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/apartment/thumbnail/' . date('Y') . '/' . date('m') . '/' . date('d'), 0777);

                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/attribute/' . date('Y'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/attribute/' . date('Y') . '/' . date('m'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/attribute/' . date('Y') . '/' . date('m') . '/' . date('d'), 0777);

                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/category/' . date('Y'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/category/' . date('Y') . '/' . date('m'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/category/' . date('Y') . '/' . date('m') . '/' . date('d'), 0777);

                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/article/' . date('Y'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/article/' . date('Y') . '/' . date('m'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/article/' . date('Y') . '/' . date('m') . '/' . date('d'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/article/thumbnail/' . date('Y'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/article/thumbnail/' . date('Y') . '/' . date('m'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/article/thumbnail/' . date('Y') . '/' . date('m') . '/' . date('d'), 0777);

                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/banner/' . date('Y'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/banner/' . date('Y') . '/' . date('m'), 0777);
                @mkdir(ROOT . '/web/cdn/asset/frontend/upload/banner/' . date('Y') . '/' . date('m') . '/' . date('d'), 0777);

                switch ($folder) {
                    case 'project':
                        $file = ROOT . '/web/cdn/asset/frontend/upload/project/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $filename;
                        $file_thumbnail = ROOT . '/web/cdn/asset/frontend/upload/project/thumbnail/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $filename;
                    break;

                    case 'avatar':
                        $file = ROOT . '/web/cdn/asset/frontend/upload/avatar/'. $filename;
                    break;

                    case 'block':
                        $file = ROOT . '/web/cdn/asset/frontend/upload/block/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $filename;
                        $file_thumbnail = ROOT . '/web/cdn/asset/frontend/upload/block/thumbnail/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $filename;
                    break;

                    case 'apartment':
                        $file = ROOT . '/web/cdn/asset/frontend/upload/apartment/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $filename;
                        $file_thumbnail = ROOT . '/web/cdn/asset/frontend/upload/apartment/thumbnail/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $filename;
                    break;

                    case 'attribute':
                        $file = ROOT . '/web/cdn/asset/frontend/upload/attribute/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $filename;
                    break;

                    case 'category':
                        $file = ROOT . '/web/cdn/asset/frontend/upload/category/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $filename;
                    break;

                    case 'article':
                        $file = ROOT . '/web/cdn/asset/frontend/upload/article/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $filename;
                        $file_thumbnail = ROOT . '/web/cdn/asset/frontend/upload/article/thumbnail/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $filename;
                    break;

                    case 'banner':
                        $file = ROOT . '/web/cdn/asset/frontend/upload/banner/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $filename;
                    break;
                }

                if (isset($file)) {
                    $h = fopen($file, 'w');
                    if (!$h) {
                        $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR;
                        $response['message'] = 'Error, cannot create file.';
                    } else {
                        if (!fwrite($h, $content)) {
                            $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR;
                            $response['message'] = 'Error, cannot create file.';
                        } else {
                            fclose($h);
                            $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_SUCCESS;
                            $response['message'] = 'Create file successfully.';
                        }
                    }
                } else {
                    $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR;
                    $response['message'] = 'Error, cannot create file.';
                }

                if (isset($file_thumbnail)) {
                    /*
                    $t = fopen($file_thumbnail, 'w');
                    if ($t) {
                        if (fwrite($t, $content)) {
                            fclose($t);
                        }
                    }
                    */

                    $big_image = null;
                    $array = pathinfo($file);

                    if (isset($array['extension']) && $array['extension'] != '') {
                        switch (strtolower($array['extension'])) {
                            default:
                            case 'jpg':
                            case 'jpeg':
                                $big_image = @imagecreatefromjpeg($file);
                                break;

                            case 'png':
                                $big_image = @imagecreatefrompng($file);
                                break;

                            case 'gif':
                                $big_image = @imagecreatefromgif($file);
                                break;
                        }
                    }

                    if ($big_image) {
                        $thumb_width = 300;
                        $thumb_height = 325;

                        if ($thumb_width / imagesx($big_image) * imagesy($big_image) > $thumb_height) {
                            $thumb_width = round($thumb_height * imagesx($big_image) / imagesy($big_image));
                        } else {
                            $thumb_height = round($thumb_width * imagesy($big_image) / imagesx($big_image));
                        }

                        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
                        imagecopyresampled($thumb, $big_image, 0, 0, 0, 0, $thumb_width, $thumb_height, imagesx($big_image), imagesy($big_image));

                        if (isset($array['extension']) && $array['extension'] != '') {
                            switch (strtolower($array['extension'])) {
                                default:
                                case 'jpg':
                                case 'jpeg':
                                    @imagejpeg($thumb, $file_thumbnail, 85);
                                    @imagedestroy($thumb);
                                break;

                                case 'png':
                                    @imagepng($thumb, $file_thumbnail, 8);
                                    @imagedestroy($thumb);
                                break;

                                case 'gif':
                                    @imagegif($thumb, $file_thumbnail);
                                    @imagedestroy($thumb);
                                break;
                            }
                        }
                    }
                }
            }
        } else {
            $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR;
            $response['message'] = 'Invalid POST request.';
        }

        return parent::outputJSON($response);
    }

    public function deleteAction()
    {
        $response = array();

        $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_SUCCESS;
        $response['message'] = 'Success.';

        $folder = $this->request->getQuery('folder', array('striptags', 'trim'), '');
        $filename = $this->request->getQuery('filename', array('striptags', 'trim'), '');

        if ($folder == '' || $filename == '') {
            $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR;
            $response['message'] = 'Parameter is invalid.';
        } else {
            switch ($folder) {
                case 'project':
                    $file = ROOT . '/web/cdn/asset/frontend/upload/project/' . $filename;
                    $file_thumbnail = ROOT . '/web/cdn/asset/frontend/upload/project/thumbnail/' . $filename;
                break;

                case 'block':
                    $file = ROOT . '/web/cdn/asset/frontend/upload/block/' . $filename;
                    $file_thumbnail = ROOT . '/web/cdn/asset/frontend/upload/block/thumbnail/' . $filename;
                break;

                case 'apartment':
                    $file = ROOT . '/web/cdn/asset/frontend/upload/apartment/' . $filename;
                    $file_thumbnail = ROOT . '/web/cdn/asset/frontend/upload/apartment/thumbnail/' . $filename;
                break;

                case 'attribute':
                    $file = ROOT . '/web/cdn/asset/frontend/upload/attribute/' . $filename;
                break;

                case 'category':
                    $file = ROOT . '/web/cdn/asset/frontend/upload/category/' . $filename;
                break;

                case 'article':
                    $file = ROOT . '/web/cdn/asset/frontend/upload/article/' . $filename;
                break;

                case 'banner':
                    $file = ROOT . '/web/cdn/asset/frontend/upload/banner/' . $filename;
                break;

                case 'avatar':
                    $file = ROOT . '/web/cdn/asset/frontend/upload/avatar/' . $filename;
                break;
            }

            if (isset($file)) {
                if (!file_exists($file)) {
                    $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR;
                    $response['message'] = 'File is not existed.';
                } else {
                    @chmod($file, 0777);

                    if (!@unlink($file)) {
                        $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR;
                        $response['message'] = 'Error, cannot delete file.';
                    } else {
                        $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_SUCCESS;
                        $response['message'] = 'Delete file successfully.';
                    }
                }
            } else {
                $response['status'] = \ITECH\Data\Lib\Constant::STATUS_CODE_ERROR;
                $response['message'] = 'File is not existed.';
            }

            if (isset($file_thumbnail)) {
                if (file_exists($file_thumbnail)) {
                    @chmod($file_thumbnail, 0777);
                    @unlink($file_thumbnail);
                }
            }
        }

        parent::outputJSON($response);
    }
}