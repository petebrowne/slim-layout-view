<?php

class LayoutViewTest extends PHPUnit_Framework_TestCase {
  public function setUp() {
    $this->view = new \Slim\LayoutView();
    $this->view->setTemplatesDirectory(__DIR__ . '/templates');
  }

  public function testRendersTemplateWrappedWithLayout() {
    $output = $this->view->fetch('simple.php');
    $this->assertEquals("<h1>Hello World\n</h1>", trim($output));
  }

  public function testDefaultLayoutFromAppConfiguration() {
    \Slim\Environment::mock();
    $this->app = new \Slim\Slim(array('layout' => 'layout_from_app.php'));
    $output = $this->view->fetch('simple.php');
    $this->assertEquals("<div>Hello World\n</div>", trim($output));
  }

  public function testLayoutFromData() {
    $this->view->setData('layout', 'layout_from_data.php');
    $output = $this->view->fetch('simple.php');
    $this->assertEquals("<p>Hello World\n</p>", trim($output));
  }

  public function testRendersWithoutLayout() {
    $this->view->setData('layout', false);
    $output = $this->view->fetch('simple.php');
    $this->assertEquals('Hello World', trim($output));
  }

  public function testLayoutSharesData() {
    $output = $this->view->setData(array(
      'title' => 'Hello',
      'content' => 'World',
      'layout' => 'layout_with_data.php'
    ));
    $output = $this->view->fetch('template_with_data.php', array());
    $this->assertEquals("<h1>Hello</h1>\n<p>World</p>", trim($output));
  }

  public function testAdditionalDataInFetch() {
    $output = $this->view->fetch('template_with_data.php', array(
      'title' => 'Hello',
      'content' => 'World',
      'layout' => 'layout_with_data.php'
    ));
    $this->assertEquals("<h1>Hello</h1>\n<p>World</p>", trim($output));
  }
}
