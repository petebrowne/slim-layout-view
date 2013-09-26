<?php
namespace Slim;

/**
 * Extends Slim's default View class to include the ability
 * to wrap views with layouts. The rendered, nested view will
 * be available to the layout as `$yield`. Variable data will
 * be shared between the layout and the nested view.
 */
class LayoutView extends View {
  /**
   * The default layout template.
   */
  const DEFAULT_LAYOUT = 'layout.php';

  /**
   * Unsets the data for the given key.
   *
   * @param string $key
   */
  public function remove($key) {
    $this->data->remove($key);
  }

  /**
   * Override the default fetch mechanism to render a layout if set.
   *
   * @param string $template Path to template file relative to templates directory
   * @return string          The fully rendered view as a string.
   */
  public function fetch($template) {
    $layout = $this->getLayout();
    $this->remove('layout');
    $result = $this->render($template);
    if (is_string($layout)) {
      $result = $this->renderLayout($layout, $result);
    }

    return $result;
  }

  /**
   * Returns the layout for this view. This will be either
   * the 'layout' data value, the applications 'layout' configuration
   * value, or 'layout.php'.
   *
   * @return string|null
   */
  public function getLayout() {
    $layout = $this->get('layout');
    if (is_null($layout)) {
      $app = Slim::getInstance();
      if (isset($app)) {
        $layout = $app->config('layout');
      }
    }
    if (is_null($layout)) {
      $layout = self::DEFAULT_LAYOUT;
    }

    return $layout;
  }

  protected function renderLayout($layout, $yield) {
    $currentTemplate = $this->templatesDirectory;
    $this->set('yield', $yield);
    $result = $this->render($layout);
    $this->templatesDirectory = $currentTemplate;
    $this->remove('yield');

    return $result;
  }
}
