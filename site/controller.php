<?php
/**
 * @package    LajvIT
 */

// No direct access

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');

/**
 * LajvIT Component Controller.
 */
class LajvITController extends JController {
  /**
  * Method to display the view
  *
  * @access    public
  */
  function display( $cachable = FALSE) {
    $document = &JFactory::getDocument();

    $viewType = $document->getType();
    $viewName = JRequest::getCmd('view', $this->getName());
    $viewLayout = JRequest::getCmd('layout', 'default');

    $user = &JFactory::getUser();
    if (!$user || $user->guest) {
      $redirectUrl = 'index.php?option=com_lajvit&view=' . $viewName . '&layout=' . $viewLayout;
      $redirectUrl .= '&Itemid='.JRequest::getInt('Itemid', 0);
      $this->setRedirect('index.php?option=com_user&view=login&return='.base64_encode($redirectUrl));
      return;
    }

    $view = &$this->getView($viewName, $viewType, '', array('base_path' => $this->_basePath));

    // Get/Create the model
    //    if ($model = &$this->getModel($viewName)) {
    if ($model = &$this->getModel($this->getName())) {
      // Push the model into the view (as default)
      $view->setModel($model, TRUE);
    }

    if ($viewName != 'person' || $viewLayout != 'edit') {
      $person = &$model->getPerson();

      if (!$person || $person->_nodata) {
        $this->setRedirect('index.php?option=com_lajvit&view=person&layout=edit&Itemid='.JRequest::getInt('Itemid', 0));
        return;
      }
    }

    // Set the layout
    $view->setLayout($viewLayout);

    // Display the view
    if ($cachable && $viewType != 'feed') {
      $option = JRequest::getCmd('option');
      $cache =& JFactory::getCache($option, 'view');
      $cache->get($view, 'display');
    } else {
      $view->display();
    }
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

    if (!is_int($imageinfo[0]) || !is_int($imageinfo[1]) || !in_array($imageinfo['mime'], $validmimetypes)) {
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
