(()=>{
	let a = document.querySelectorAll('a');
	for(let i = 0; i < a.length; i++){
		a[i].addEventListener(
	    'click', e =>{
	    	e.preventDefault();
	    	// return false;
	    }, false
		);
	}
})();

////////////////////////////open popap

(()=>{
	let cross = document.querySelector('.cross'),
			popap = document.querySelector('.lucid-popap'),
			button = document.querySelectorAll('.btn-b'),
			open = ()=>{
				popap.classList.add('open');
			},
			closs = ()=>{
				popap.classList.remove('open');
			};

	for(let i = 0; i < button.length; i++){
			button[i].addEventListener('click',open);
	}

	cross.addEventListener('click',closs);
})();

//////////////////////////////////scroll arrow

(()=>{
	let arrowTop = document.querySelector('.arrowTop');

	arrowTop.addEventListener('click',()=>{
		window.scrollTo(pageXOffset,0);
	});

	window.addEventListener('scroll',()=>{
		arrowTop.hidden = (pageYOffset < document.documentElement.clientHeight);
	});
	

})();



////////////////////////////////////



/////////////////////////////////////
$('.carousel').carousel({
  interval: false
})

