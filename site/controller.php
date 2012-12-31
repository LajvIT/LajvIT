<?php
/**
 * @package    LajvIT
 */

defined('_JEXEC') or die('Restricted access');

/**
 * LajvIT Component Controller.
 */
class LajvITController extends JControllerLegacy {
  /**
  * Method to display the view
  *
  * @access    public
  */
  public function display($cachable = FALSE, $urlparams = FALSE) {
    $document = JFactory::getDocument();
    $viewType = $document->getType();
    $viewName = JRequest::getCmd('view', $this->default_view);
    $viewLayout = JRequest::getCmd('layout', 'default');

    $view = $this->getView($viewName, $viewType, '',
        array('base_path' => $this->basePath, 'layout' => $viewLayout));

    if ($model = $this->getModel("LajvIT")) {
      $view->setModel($model, TRUE);
    }
    if ($model = $this->getModel($viewName)) {
      $view->setModel($model, TRUE);
    }

    $view->assignRef('document', $document);
    $view->setLayout($viewLayout);

    $conf = JFactory::getConfig();

    // Display the view
    if ($cachable && $viewType != 'feed' && $conf->get('caching') >= 1) {
      $option = JRequest::getCmd('option');
      $cache = JFactory::getCache($option, 'view');

      if (is_array($urlparams)) {
        $app = JFactory::getApplication();

        if (!empty($app->registeredurlparams)) {
          $registeredurlparams = $app->registeredurlparams;
        } else {
          $registeredurlparams = new stdClass;
        }

        foreach ($urlparams as $key => $value) {
          // Add your safe url parameters with variable type as value {@see JFilterInput::clean()}.
          $registeredurlparams->$key = $value;
        }

        $app->registeredurlparams = $registeredurlparams;
      }

      $cache->get($view, 'display');
    } else {
      $view->display();
    }

    return $this;
  }

  function mypages() {
    JRequest::setVar('view', 'mypages');
    //    JRequest::setVar('layout', 'edit');
    //    JRequest::setVar('hidemainmenu', 1);

    $this->display();
  }

  function saveimage($fieldname) {
    switch ($_FILES[$fieldname]['error']) {
      case 1:
        echo 'File larger than php.ini allows.';
        return FALSE;
      case 2:
        echo 'File larger than html form allows.';
        return FALSE;
      case 3:
        echo 'Partial upload.';
        return FALSE;
      case 4:
        echo 'No file';
        return FALSE;
    }

    if ($_FILES[$fieldname]['size'] > 2000000) {
      echo 'File bigger than 2 Mb.';
      return FALSE;
    }

    $filename = $_FILES[$fieldname]['name'];
    $extension = array_pop(explode('.', $filename));

    $validextensions = array('jpg', 'jpeg', 'png', 'gif');

    $extok = FALSE;
    foreach ($validextensions as $ext) {
      if (strcasecmp($ext, $extension) == 0) {
        $extok = TRUE;
        break;
      }
    }

    if (!$extok) {
      echo 'Invalid file extension.';
      return FALSE;
    }

    $tempfile = $_FILES[$fieldname]['tmp_name'];

    $imageinfo = getimagesize($tempfile);

    $validmimetypes = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/gif');

    if (!is_int($imageinfo[0]) || !is_int($imageinfo[1]) ||
        !in_array($imageinfo['mime'], $validmimetypes)) {
      echo 'Invalid file type';
      return FALSE;
    }

    if ($imageinfo[0] > 300 || $imageinfo[1] > 300) {
      echo 'Image area too big.';
      return FALSE;
    }

    $filename = uniqid('', TRUE).'_' . preg_replace('/[^A-Za-z0-9.]/', '_', $filename);
    $path = 'images'.DS.'stories'.DS.$filename;

    if (!JFile::upload($tempfile, JPATH_SITE.DS.$path)) {
      echo 'Error moving file.';
      return FALSE;
    }

    return $path;
  }
}
