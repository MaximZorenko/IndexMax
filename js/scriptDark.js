(function(){
	var button = document.querySelector('.button'),
			form = document.forms.headerMenu;
	var showForm = function(){
		form.classList.toggle('formOpen');
	};
	button.addEventListener('click',showForm);
})();

(function(){
	var menu = document.querySelector('.dark--header__nav--logo'),
			menunav = document.querySelector('.dark--header__nav--ul');
	var showMenu = function(){
		menunav.classList.toggle('open');
	};
	menu.addEventListener('click',showMenu);
})();
//////////////////slider
(function(){
	var lists = document.getElementsByClassName('dark--header__slider--list');
			indicators = document.getElementsByClassName('slider--indicator'),
			scrolLeft = document.getElementsByClassName('slider--scrol')[0],
			scrolRight = document.getElementsByClassName('slider--scrol')[1],
			x = 0;
	var showList = function(){
		if(x < 0){x = lists.length - 1;}
		if(x > lists.length - 1){x = 0;}
		for(var i = 0; i < lists.length; i++){
			lists[i].style.opacity = '0';
		}
		lists[x].style.opacity = '1';
		for(var y = 0; y < indicators.length; y++){
		indicators[y].style.backgroundColor = '#282a2e';
		}
		indicators[x].style.backgroundColor = 'rgba(255,255,255,.4)';
	};
	var ShowHHHH = function(a){
		indicators[a].addEventListener('click',function(){
		x = a;
		showList();
		});
	};
	showList();

	scrolLeft.addEventListener('click',function(){
		x--;
		showList();
	});

	scrolRight.addEventListener('click',function(){
		x++;
		showList();
	});
	
	for(var i = 0; i < indicators.length; i++){
		ShowHHHH(i);
	}
})();

//////////////animetionIcons/////////////////////
// var icons = document.getElementsByClassName('slider--icon'),
// 		wrapper = document.querySelector('.dark--header__slider--icon');
// var showIcons = function(event){
// 	var rect = this.getBoundingClientRect();
// 	var left = event.clientX - rect.left - icons[3].clientWidth/2;
// 	var bottom = rect.bottom - event.clientY - icons[3].clientHeight/2;
// 	icons[3].style.left = left + 'px';
// 	icons[3].style.bottom = bottom + 'px';
// };
// wrapper.addEventListener('mousemove',showIcons);


$(document).ready(function(){

//parallax
$.stellar({
	responsive: true,
	horizontalOffset: 50
});


});










