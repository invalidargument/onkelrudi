<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;
use RudiBieller\OnkelRudi\Controller\UserAwareInterface;

class FleaMarketFlyerCreateAction extends AbstractJsonAction implements UserAwareInterface
{
    private $_errorMessage = 'Error uploading file';
    private $_errorCode = 200;
    private $_validExtensions = array();
    private $_validMimetypes = array();

    protected function getData()
    {
        $files = $this->request->getUploadedFiles();

        if (empty($files['flyer'])) {
            return false;
        }

        if ($files['flyer']->getError() === UPLOAD_ERR_OK) {
            $uploadFileName = $files['flyer']->getClientFilename();

            $user = $this->userService->getAuthenticationService()->getStorage()->read();
            $targetFolder = $this->app->getContainer()->get('config')->getSystemConfiguration()['upload-path']
                . $user->getIdentifier() . DIRECTORY_SEPARATOR;

            /** @var \Illuminate\Filesystem\Filesystem $filesystem */
            $filesystem = $this->app->getContainer()->get('Filesystem');
            if (!$filesystem->exists($targetFolder)) {
                $filesystem->makeDirectory($targetFolder, 0777, true);
            }

            try {
                $files['flyer']->moveTo($targetFolder . $uploadFileName);
                return true;
            } catch (\InvalidArgumentException $e) {
                // specified path is invalid
                if ($this->_isDevEnvironment()) {
                    $this->_errorMessage = $e->getMessage();
                    $this->_errorCode = 400;
                }
                return null;
            } catch (\RuntimeException $e) {
                if ($this->_isDevEnvironment()) {
                    $this->_errorMessage = $e->getMessage();
                    $this->_errorCode = 400;
                }
                return null;
            }

            return null;
        } else {
            if ($this->_isDevEnvironment()) {
                $this->_errorMessage = 'Error uploading file, UPLOAD_ERR_*: ' . $files['flyer']->getError();
                $this->_errorCode = 400;
            }
        }

        return null;
    }

    protected function getResponseErrorStatusMessage()
    {
        return $this->_errorMessage;
    }

    protected function getResponseErrorStatusCode()
    {
        return $this->_errorCode;
    }

    private function _isDevEnvironment()
    {
        return $this->app->getContainer()->get('config')->getSystemConfiguration()['environment'] === 'dev';
    }

    private function _isImage()
    {
        // check if file is an image
        // use getimagesize() to validate
        // if not, send to trash
    }
}
