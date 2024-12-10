document.addEventListener('DOMContentLoaded', function(){
    inicarApp();
});

function inicarApp(){
    buscarporfecha();
}

 function buscarporfecha(){
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', function(e){
        const fechaSeleccionada = e.target.value;


        window.location = `?fecha=${fechaSeleccionada}`;
    })
 }
