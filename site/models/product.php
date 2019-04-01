<?php
class ProductPage extends Page {
  public function cover() {
    return $this->content()->cover()->toFile();
  }
};
