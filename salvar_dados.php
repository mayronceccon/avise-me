<?php

require_once( dirname( dirname( dirname(dirname( __FILE__) ) ) ) . '/wp-load.php' );

function salvar_dados($email = null, $produto = null)
{
	global $wpdb;
		
	if(!is_null($email) AND !is_null($produto)){
		$tablename = $wpdb->prefix . 'avise_me';
		$sql = "INSERT INTO {$tablename}(email, id_produto, avisado) VALUES ('{$email}', {$produto}, '0');";		
		$wpdb->query($sql);
	}
}

$email = isset($_POST['email']) ? $_POST['email'] : null;
$produto = isset($_POST['produto']) ? (int) $_POST['produto'] : null;

salvar_dados($email, $produto);
