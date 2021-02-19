
window.onload = function () {
	var form = document.getElementById('contacto-form');
	var msjeNombre = document.createElement('span');
	document.getElementById('pNombre').appendChild(msjeNombre);
	var msjeEmail = document.createElement('span');
	document.getElementById('pEmail').appendChild(msjeEmail);
	var msjeMensaje = document.createElement('span');
	document.getElementById('pMensaje').appendChild(msjeMensaje);
	var msjeCaptcha = document.createElement('span');
	document.getElementById('pCaptcha').appendChild(msjeCaptcha);

	form.onsubmit = function () {
		form.btnEnviar.disabled = true;

		var contError = 0;
		var foco = '';

		form.txtMensaje.value = form.txtMensaje.value.trim();
		if (form.txtMensaje.value.length < 1 || form.txtMensaje.value.length > 1000) {
			contError++;
			form.txtMensaje.style.border = '3px solid #a00';
			msjeMensaje.style.color = '#a00';
			msjeMensaje.innerHTML = "Requerido, hasta 1000 caracteres.";
			foco = 'txtMensaje';
		} else {
			form.txtMensaje.style.removeProperty('border');
			msjeMensaje.innerHTML = '';
		}

		form.txtEmail.value = form.txtEmail.value.trim();
		if (form.txtEmail.value.length < 1 || form.txtEmail.value.length > 254) {
			contError++;
			form.txtEmail.style.border = '3px solid #a00';
			msjeEmail.style.color = '#a00';
			msjeEmail.innerHTML = "Requerido, hasta 254 caracteres.";
			foco = 'txtEmail';
		} else {
			form.txtEmail.style.removeProperty('border');
			msjeEmail.innerHTML = '';
		}

		form.txtNombre.value = form.txtNombre.value.trim();
		if (form.txtNombre.value.length < 1 || form.txtNombre.value.length > 50) {
			contError++;
			form.txtNombre.style.border = '3px solid #a00';
			msjeNombre.style.color = '#a00';
			msjeNombre.innerHTML = "Requerido, hasta 50 caracteres.";
			foco = 'txtNombre';
		} else {
			form.txtNombre.style.removeProperty('border');
			msjeNombre.innerHTML = '';
		}

		var response = grecaptcha.getResponse();
		if (response.length == 0){
			contError++;
			msjeCaptcha.style.color = '#a00';
			msjeCaptcha.innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;reCAPTCHA requerido";
		}else {
			msjeCaptcha.innerHTML = '';
		}

		if (contError > 0) {
			form.elements[foco].focus();
			form.btnEnviar.disabled = false;
			return false;
		}

		return true;

	}

} 