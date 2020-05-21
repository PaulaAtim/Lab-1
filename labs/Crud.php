<?php
  /*
   functions to be imlemented by classes that implement this interface
   */
  interface Crud
  {
    public function save();
    public function readAll();
    public function readUnique();
    public function search();
    public function update();
    public function removeOne();
    public function removeAll();

    public function valiteForm();
    public function createFormErrorSessions();
  }

?>