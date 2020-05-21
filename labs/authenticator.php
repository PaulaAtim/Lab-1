<?php
    interface Authencicator{
    	public function hashPassword();
    	public function isPasswordCorrect();
    	public function login();
    	public function logout();
    	public function createFormErrorSessions();
    	public function createUserSession();
    }
?>