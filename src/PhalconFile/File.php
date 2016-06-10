<?php
namespace PhalconFile;

use Phalcon\Mvc\User\Component;

/**
 * PhalconFile\File
 */
class File extends Component
{

  /**
   * Serve files to browser
   *
   * @param string $key
   */
  public function serve($path)
  {
  
    $meta = getimagesize($path);

    if (is_array($meta)) {

      $this->response->setHeader('Content-Type', $meta['mime']);

    } else {

      $this->response->setHeader('Content-Description', 'File Transfer');
      $this->response->setHeader('Content-Type', 'application/octet-stream');
      $this->response->setHeader('Content-Transfer-Encoding', 'binary');

    }

    $this->response->setHeader('Expires', 0);
    $this->response->setHeader('Cache-Control', 'must-revalidate');
    $this->response->setHeader('Pragma', 'public');
    $this->response->setHeader('Content-Length', filesize($path));
    $this->response->setContent(readfile($path));
    $this->dispatcher->setReturnedValue($this->response);

  }


  /**
   * Serve & download a PDF file to browser
   *
   * @param string $path
   */
  public function servePdf($path)
  {

    $filename = preg_replace('/^.*\//', '', $path);

    // Headers
    $this->response->setHeader('Cache-Control', 'private');
    $this->response->setHeader('Content-Type', 'application/csv');
    $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '";');
    $this->response->setHeader('Content-Transfer-Encoding', 'binary');
    $this->response->setHeader('Expires', 0);
    $this->response->setHeader('Pragma', 'public');
    $this->response->setHeader('Content-Length', filesize($path));
    $this->response->setContent(readfile($path));
    $this->dispatcher->setReturnedValue($this->response);

  }

}
