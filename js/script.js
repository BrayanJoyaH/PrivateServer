function cambiar(){
    let pdrs = document.getElementById('file').files[0].name;
    len = pdrs.length;
	if (len > 15) {
		str = pdrs.substr(0, 9) + "..." + pdrs.substr(-7);
	} else {
		str = pdrs;
	}
	document.querySelector('#info').innerText = str;
}


