	function getXMLHttpRequest() {
		var xhr = null;
		if (window.XMLHttpRequest || window.ActiveXObject) {
			if (window.ActiveXObject) {
				try {
					xhr = new ActiveXObject("Msxml2.XMLHTTP");
				} catch(e) {
					xhr = new ActiveXObject("Microsoft.XMLHTTP");
				}
			} else {
				xhr = new XMLHttpRequest();
			}
		} else {
			alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
			return null;
		}
		return xhr;
	}

	function send_data_img(url, data) {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				window.location.href = url;
			}
		};
		var preview_datas = document.getElementsByClassName("img_preview")[0];
		xhttp.open("POST", "", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("img=" + data);
	};

	function fade_elem(elem) {
		if (document.getElementById(elem).classList.contains('not_faded')) {
			document.getElementById(elem).classList.remove('not_faded');
			document.getElementById(elem).classList.add('faded');
		}
	};

	function unfade_elem(elem) {
		if (document.getElementById(elem).classList.contains('faded')) {
			document.getElementById(elem).classList.remove('faded');
			document.getElementById(elem).classList.add('not_faded');
		}
	};
