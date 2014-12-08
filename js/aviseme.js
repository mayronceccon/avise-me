function ajax_salvar_dados(email, produto, path)
{
	var cAjax;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		cAjax=new XMLHttpRequest();
	}else{// code for IE6, IE5
		cAjax=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	cAjax.open('POST', path + '/salvar_dados.php', true);
	cAjax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
	cAjax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
	cAjax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
	cAjax.setRequestHeader("Pragma", "no-cache");
	
	var dados = "email="+email+"&produto="+produto;
	
	cAjax.onreadystatechange=function(){
		if (cAjax.readyState==4 && cAjax.status==200){
			document.getElementById("email_produto_sem_estoque").value = "";
			document.getElementById("aviso_email_cadastrado").style.display="block";			
		}
	}	
	cAjax.send(dados);
}

function valida_email(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 

function salvar_email_avise_me()
{
	var email = document.getElementById('email_produto_sem_estoque');
	var produto = document.getElementById('id_produto_sem_estoque');
	var path = document.getElementById('path_plugin_sem_estoque');
	
	if(email.value != "" && produto.value != ""){
		if(valida_email(email.value)){
			ajax_salvar_dados(email.value, produto.value, path.value);
		}else{
			alert('Email inválido!');
			email.focus();
		}		
	}else{
		alert('Digite o seu email!');
		email.focus();
	}
}