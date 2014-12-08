<?php

global $product, $woocommerce, $wpdb;

$tablename = $wpdb->prefix . 'avise_me';
$sql = "SELECT * FROM {$tablename} WHERE avisado = 0";
$results = $wpdb->get_results($sql);

if(isset($_GET['btn_enviar_email'])){
	foreach($results as $result){
		$produto = get_product($result->id_produto);
		$em_estoque = $produto->is_in_stock();
		
		if($em_estoque){
			$sqlUpdate = "UPDATE {$tablename} SET avisado = '1' WHERE id = {$result->id}";
			$wpdb->get_results($sqlUpdate);
			
			$email = $result->email;
			
			$subject = get_option('avise_me_email_title');
			$subject =  str_replace('[nome_produto]', $produto->post->post_title, $subject);
			#$subject =  str_replace('[link_produto]', $produto->post->guid, $subject);
			
			$message = get_option('avise_me_email_message');
			$message =  str_replace('[nome_produto]', $produto->post->post_title, $message);
			#$message =  str_replace('[link_produto]', $produto->post->guid, $message);
			
			wp_mail( $email, $subject, $message );
		}
	}
}
$results = $wpdb->get_results($sql);
?>
<div class="wrap">
	<h2>Lista de Pedidos</h2>
	<form action="" method="get">
		<input type="hidden" name="page" value="avise-me/lista.php">
		<table class="wp-list-table widefat fixed users">
			<thead>
				<tr>
					<th scope="col" class="manage-column column-posts num"><span>Produto</span></td>
					<th scope="col" class="manage-column column-posts num"><span>Email</span></td>
					<th scope="col" class="manage-column column-posts num"><span>Em estoque?</span></td>
				</tr>
			</thead>
			<?php $cont = 0;?>
			<?php foreach($results as $result): ?>
			<tbody>
				<?php
					$class = null;
					if(($cont % 2) == 0){
						$class = "class='alternate'";
					}
					$cont++;
				?>
				<tr <?php echo $class;?>>
					<?php
						$produto = get_product($result->id_produto);
						$em_estoque = $produto->is_in_stock();
					?>
					<td class="posts column-posts num"><a href="<?php echo $produto->post->guid?>" target="_blank"><?php echo $produto->post->post_title;?></a></td>
					<td class="posts column-posts num"><?php echo $result->email;?></td>
					<td class="posts column-posts num">
						<?php 
							$estoque = "NÃO";
							if($em_estoque){
								$estoque = "SIM";
							}
							echo $estoque;			
						?>		
					</td>
				</tr>
			</tbody>
			<?php endforeach;?>
			<tfoot>
				<tr>
					<th scope="col" class="manage-column column-posts num"><span>Produto</span></td>
					<th scope="col" class="manage-column column-posts num"><span>Email</span></td>
					<th scope="col" class="manage-column column-posts num"><span>Em estoque?</span></td>
				</tr>
			</tfoot>
		</table>
		<div class="tablenav bottom">
			<div class="alignleft actions bulkactions">				
				<input type="submit" name="btn_enviar_email" id="btn_enviar_email" class="button action" value="Enviar Email">
			</div>
		</div>
	</form>
</div>