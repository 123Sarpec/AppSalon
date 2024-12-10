let paso = 1;
let pasoInicial = 1;
let pasoFinal = 3;

// para validar o selecionar cita 
const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: [],

}

document.addEventListener("DOMContentLoaded", function () {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); // Mostrar y oculatar secciones7
    tabs(); //cambia la seccion de redireccionamiento
    botonPaginador();//buton para pagia siguiente
    botonAnterior(); //buton para pagina anterior
    botonSiguiente(); //buton para pagina siguiente
    consultarApi(); //consltar api desde la base de datos

    idCliente(); // 
    nombrecliente(); //nombre cliente

    selecionarFecha(); //selecionar fecha para
    selecionarHora(); //selecionar horas para


    mostrarResumen(); //mostrar el resumen de la cita
}

function mostrarSeccion() {

    // oculatar la secion 
    const seccionAnterior = document.querySelector('.mostrar')
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }

    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    // quita la clase actual al seccionAnterior
    const tabsAnteriores = document.querySelector('.actual');
    if (tabsAnteriores) {
        tabsAnteriores.classList.remove('actual');
    }

    // resalta el tab actual 
    const tab = document.querySelector(`[data-paso="${paso}"]`)
    tab.classList.add('actual');
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function (e) {
            paso = parseInt(e.target.dataset.paso);

            mostrarSeccion();

            botonPaginador();

        });
    });
}

function botonPaginador() {

    const botonAnterior = document.querySelector('#anterior');
    const botonSiguiente = document.querySelector('#siguiente');

    if (paso === 1) {
        botonAnterior.classList.add('ocultar');
        botonSiguiente.classList.remove('ocultar');
    } else if (paso === 3) {
        botonSiguiente.classList.add('ocultar');
        botonAnterior.classList.remove('ocultar');

        mostrarResumen();

    } else {
        botonAnterior.classList.remove('ocultar');
        botonSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function botonAnterior() {
    const botonAnterior = document.querySelector('#anterior');
    botonAnterior.addEventListener('click', function () {
        if (paso <= pasoInicial) return;
        paso--;
        botonPaginador();
    })
}

function botonSiguiente() {
    const botonSiguiente = document.querySelector('#siguiente');
    botonSiguiente.addEventListener('click', function () {
        if (paso >= pasoFinal) return;
        paso++;
        botonPaginador();
    })
}

async function consultarApi() {
    try {
        const url = '/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostarServicios(servicios);

    } catch (error) {
        console.log(error);
    }
}

function mostarServicios(servicios) {
    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;

        servicioDiv.onclick = function () {
            selecionarServicio(servicio);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv);

    });
}

function selecionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;
    // conprar servicio selecionado o elminado
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    // identifica el elemento para elminar o seleccornar 
    if (servicios.some(agregado => agregado.id === id)) {
        //eliminar
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
        divServicio.classList.remove('seleccionado');
    } else {
        //agregar
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');

    }

}

function idCliente (){
    cita.id = document.querySelector('#id').value;
}

function nombrecliente() {
    cita.nombre = document.querySelector('#nombre').value;


}

function selecionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function (e) {

        const dia = new Date(e.target.value).getUTCDay(); //;     

        if ([6, 0].includes(dia)) {
            mostrarAlerta('No atendemos los Fines de Semana', 'error', '.formulario');
            e.target.value = '';
        } else {
            cita.fecha = e.target.value;
        }
    });
}
function selecionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function (e) {


        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];
        if (hora < 9 || hora > 17) {
            mostrarAlerta('Hora no validas', 'error', '.formulario');
        } else {
            cita.hora = e.target.value;
        }
    })
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
    // eviata el mensaje de alerta que se muestre varias veces en pantalla 
    const alertaPrevia = document.querySelector('.alerta')
    if (alertaPrevia) {
        alertaPrevia.remove();
    };

    // validar alerta en funcion de la fecha 
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if (desaparece) {
        // validacion de alerta en 3 segundos
        setTimeout(() => {
            alerta.remove();
        }, 3000);

    }

}


function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    // Limpiar el contenido anterior del resumen
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    // Verificar si faltan datos
    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Falta datos de Servicio, Fecha u Hora', 'error', '.contenido-resumen');
        return;
    }

    // Formatear el contenido del div resumen
    const { nombre, fecha, hora, servicios } = cita; // corregido servicios

    // headin para servicio de resumnen
    const headingSercicios  = document.createElement('H3');
    headingSercicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingSercicios);

    servicios.forEach(servicio => {

        const { id, precio, nombre } = servicio;
        const contenedorServicios = document.createElement('DIV');
        contenedorServicios.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> ${precio}`; //

        contenedorServicios.appendChild(textoServicio);
        contenedorServicios.appendChild(precioServicio);

        resumen.appendChild(contenedorServicios);
    })
        // headin para cita de resumnen
        const headingCita  = document.createElement('H3');
        headingCita.textContent = 'Resumen e Informacion de Cita';
        resumen.appendChild(headingCita);
    
    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

      //formatear la fecha en español

      const fechaObj = new Date(fecha);
      const mes = fechaObj.getUTCMonth();
      const dia = fechaObj.getUTCDate() + 2;
      const year = fechaObj.getUTCFullYear();


      const fechaUTC = new Date(Date.UTC(year,mes,dia));

    const opciones = { weekday: 'long', year:'numeric', month: 'long', day: 'numeric' };
    const fechaFormateado = fechaUTC.toLocaleDateString('es-MX', opciones)

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateado}`; // corregido a fechaCita

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas `; // corregido a horaCita


    // boton para enviar cita 
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservaCita;


    // Añadir los elementos al resumen
    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(botonReservar);

}

async function reservaCita() {
    const { id, fecha, hora, servicios} = cita;

const idServicios = servicios.map(servicio => servicio.id);
// console.log(idServicios);


    const datos= new FormData();
    datos.append('usuarioId', id);
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('servicios', idServicios);
//         console.log([...datos]);
// return;
    //peticion hacia la api

    try {
        const url = '/api/citas';
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
    
        });
        const resultado = await respuesta.json();
        console.log(resultado,resultado);
        if(resultado.resultado){
            Swal.fire({
                icon: "success",
                title: "Cita creada",
                text: "Tu Cita ha sido Reservada!",
                button: 'OK'
              }).then(() => {
                setTimeout(() => {
                window.location.reload();
                }, 2000);
              })
        }
        
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error de Reserva",
            text: "Hubo un Problema,Tu Cita no fue Creada!",
        });
    }


    // console.log([...datos]);


}
