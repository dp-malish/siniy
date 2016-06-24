function logo(){
	logofront.addEventListener('mouseenter',function(){card.classList.add("flip");})
	logoback.addEventListener('mouseleave',function(){card.classList.remove("flip");})
	logoback,addEventListener('click',function(){location.href='/';})
}
document.addEventListener("DOMContentLoaded", logo);