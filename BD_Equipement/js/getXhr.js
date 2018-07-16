function getXhr(){
	var xhr = null;
	if(window.XMLHttpRequest) // pour voir avec Firefox et les autres
	   xhr = new XMLHttpRequest();
	else if(window.ActiveXObject){ // pour Internet Explorer pourri
	   try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
	}
	else { // XMLHttpRequest non support� par le navigateur
	   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
	   xhr = false;
	}
					return xhr;
	}
