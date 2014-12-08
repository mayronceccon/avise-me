<?php
/*
Plugin Name: Avise-me produtos fora do estoque
Plugin URI: http://mayronceccon.com.br/
Description: Avise-me produtos fora do estoque
Author: Mayron Ceccon
Version: 1.0
Author URI: http://mayronceccon.com.br/
*/

function criar_tabela()
{
	global $wpdb;	
	// Verifica se a nova tabela existe
	// "prefix" o prefixo escolhido na instalacao do WordPress
	$tablename = $wpdb->prefix . 'avise_me';
	
	// Se a tabela nao existe sera criada
	if ( $wpdb->get_var( "SHOW TABLES LIKE '$tablename'" ) != $tablename ) {
	
		$sql = "CREATE TABLE `{$tablename}` (
				`id` INT NOT NULL AUTO_INCREMENT,
				`email` VARCHAR(100) NOT NULL,
				`id_produto` INT NOT NULL,
				`avisado` CHAR(1) NOT NULL,
				PRIMARY KEY (`id`)
			)";
	
		// Ao usar a funcao dbDelta() e necessario carregar este ficheiro
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	
		// Funcao que cria a tabela na bd e executa as otimizacoes necessarias
		dbDelta( $sql );	
	}
	
	if(!get_option('avise_me_email_title') AND !get_option('avise_me_email_message')){
		add_option('avise_me_email_title' , "EM BRANCO");
		add_option('avise_me_email_message' , "EM BRANCO");
	}
}

function avise_me_menu()
{
	add_menu_page( 'Lista Avise-me', 'Avise-me', 10,'avise-me/lista.php' );
	add_submenu_page( 'avise-me/lista.php', 'Lista Avise-me','Dados Emails', 10, 'avise-me/dados_email.php' );
}

function campos_avise_me($id_produto)
{
	$html = '<div class="avise_produto" style="display:none;">
				<h4>Avise-me quando o produto chegar!</h4>
				<div id="aviso_email_cadastrado" style="display:none;">
					<p>Email cadastrado com sucesso!</p>
				</div>
				Email: <input type="email" name="email_produto_sem_estoque" id="email_produto_sem_estoque" size="30" maxlength="100"></br></br>
				<input type="button" value="Enviar" name="btn_produto_sem_estoque" id="btn_produto_sem_estoque" onclick="salvar_email_avise_me();">
				<input type="hidden" id="id_produto_sem_estoque" name="id_produto_sem_estoque" value="'.$id_produto.'" />
				<input type="hidden" id="path_plugin_sem_estoque" name="path_plugin_sem_estoque" value="'. plugins_url( '', __FILE__ ).'" />
			</div>';
	
	echo $html;
}

function load_js_avise_me(){
	wp_enqueue_script( 'aviseme_js', plugins_url( '/js/aviseme.js', __FILE__ ) );
}

add_action('wp_enqueue_scripts', 'load_js_avise_me');
add_action( 'init', 'criar_tabela' );
add_action( 'admin_menu', 'avise_me_menu' );
add_action( 'campos_avise_me', 'campos_avise_me');
?> 