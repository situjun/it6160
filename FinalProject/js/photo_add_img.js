window.onload = function () {
	var up = document.getElementById('up');
	up.onclick = function () {
		centerWindow('upimg.php?dir='+this.title,'up','100','400');
	};
	var fm = document.getElementsByTagName('form')[0];
	
};

function centerWindow(url,name,height,width) {
	var left = (screen.width - width) / 2;
	var top = (screen.height - height) / 2;
	window.open(url,name,'height='+height+',width='+width+',top='+top+',left='+left);
}




function checkSubmit() {
    var name = document.getElementById('dishName').value;
    var price = document.getElementById('price').value;
    var img = document.getElementById('url').value;
    if(name == ''){
        alert('Enter name,please');
        return false;
    }else if(price == ''){
        alert('Enter price,please');
        return false;
    }else if(img == ''){
        alert('Select picture,please');
        return false;
    }
    
    
}
