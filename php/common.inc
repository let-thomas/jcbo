<?php
$CTX_PREFIX=$_SERVER['CONTEXT_PREFIX'];
if (!isset($CTX_PREFIX) || $CTX_PREFIX === '')
{
	$CTX_PREFIX = "/php"; // on server context is not set :-(
}
?>