<?php
	$erros = false;
	if(isset($_POST['btn_salvar_dados_email'])){
		if(!empty($_POST['avise_me_email_title']) AND !empty($_POST['avise_me_email_message'])){
			update_option('avise_me_email_title', $_POST['avise_me_email_title']);
			update_option('avise_me_email_message', $_POST['avise_me_email_message']);
		}else{
			$erros = true;
		}
	}	
?>
<div class="wrap">
	 <h2>Dados Emails</h2>
	 <form method="post" action="admin.php?page=avise-me/dados_email.php">
		<?php if($erros):?>
			<p>Preencha os dois campos!</p>
		<?php endif;?>
			
		<p>Use [nome_produto] para o nome do Produto.</p>
	 
		<div id="titlewrap">
			<label class="" id="title-prompt-text" for="avise_me_email_title">Título</label><br/>
			<input type="text" name="avise_me_email_title" size="30" value="<?php echo get_option('avise_me_email_title'); ?>" id="avise_me_email_title" autocomplete="off">
		</div>
		<br/>
		<div id="titlewrap">
			<label class="" id="message-prompt-text" for="avise_me_email_message">Mensagem</label><br/>
			<?php wp_editor(get_option('avise_me_email_message'), 'avise_me_email_message' ); ?>
		</div>				
		<p class="submit">
			<input type="submit" name="btn_salvar_dados_email" class="button-primary" value="Salvar" />
		</p>
	 </form>
</div> 