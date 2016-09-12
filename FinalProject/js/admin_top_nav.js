function admin_top_nav(j) {
	for (i=1;i<7;i++) {
		document.getElementById('nav'+i).style.backgroundPosition = 'left bottom';
		document.getElementById('nav'+i).style.color = '#fff';
	}
	document.getElementById('nav'+j).style.backgroundPosition = 'right bottom';
	document.getElementById('nav'+j).style.color = '#3b6ea5';
}
