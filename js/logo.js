function mainPage(){location.href='/'}
function logo(){
	logofront.addEventListener('mouseenter',function(){card.classList.add("flip");})
	logoback.addEventListener('mouseleave',function(){card.classList.remove("flip");})
	logofront.addEventListener('click',mainPage)
	logoback.addEventListener('click',mainPage)
}
document.addEventListener("DOMContentLoaded", logo);