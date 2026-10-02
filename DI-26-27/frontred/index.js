const url="http://localhost/LMSGI-2026/DI-26-27/backend/sw_alumno.php";

const buttonObtener = document.getElementById("obtener");
//al boton de añadimos un escuchado tipo click
buttonObtener.addEventListener("click", (event) => {
    //button.textContent = Recuento de clics: ${event.detail};
    getAlumno();
});

function getAlumno(){
    console.log("Pulsado botón obtener");

    let alumnoObtener = {};
    alumnoObtener.dni = document.getElementById("dni").value; 

    let request = {};
    request.action= "get"; //ojo, "action", no "method"
    request.data = alumnoObtener;
   
    fetch(url, {
        method: "POST",
        body: JSON.stringify(request),
        headers: {
            "Content-Type": "application/json",
        },
    })

   //Mandamos una solicitud GET a la URL del backend para obtener los datos del alumno 
   .then(response => response.json())
   .then(data => {
       console.log(data);
       
        //ojo los datos vienen dentro de data.data
       if(data.success){
            document.getElementById("dni").value = data.data.dni;
            document.getElementById("nombre").value = data.data.nombre;
            document.getElementById("apellido_1").value = data.data.apellido_1;
            document.getElementById("localidad").value = data.data.localidad;
       } else {
            console.error("Error al obtener el alumno");
       }
    })
    .catch(function (error) {
        console.log("Hubo un problema con la peticion fetch:" + error.message);
    });
};  



//Ahora hacemos un boton el cual nos permite insertar un alumno en la base de datos
// El evento "click" se activa en el momento que hace click en el boton y llama a la funcion insertAlumno()
const buttonInsertar = document.getElementById("insertar");
buttonInsertar.addEventListener("click", (event) => {
    insertAlumno();
});

//A cada una de las funciones del objeto se le asigna un valor 
// que es el que se obtiene de la casilla del form correspondiente
function insertAlumno(){
        console.log("Pulsado botón insertar");

    let alumno = {}; //Creamos un objeto alumno que es el que vamos a enviar al backend
    alumno.dni = document.getElementById("dni").value;              //JS lee los inputs y prepara el mensaje
    alumno.nombre = document.getElementById("nombre").value;
    alumno.apellido_1 = document.getElementById("apellido_1").value;
    alumno.localidad = document.getElementById("localidad").value;

    //1. 
    let request = {} //Creamos un objeto/variable request que es el que vamos a enviar al backend
        request.action = "insert";// Declaramos la accion y le decimos que es tipo Insert
        request.data = alumno;  //Le pasamos los datos recogidos del formulario y los guardamos en la variable data

    fetch(url, {
        method: "POST", // or 'PUT'
        body: JSON.stringify(request), 
        headers: {
        "Content-Type": "application/json",
        }
    })
    .then((res) => res.json()) //recibe la respuesta del server y la convierte en JSON para trabajar con ella.
    .then((response) => { console.log("Success:", response); alert(response.msg); }) // Si el fetch se completa, se mostraraen la consola Success: con la respuesta deseada (el JSON con la informacion del alumno insertado).
    .catch((error) => console.error("Error:", error)); // A cualquier error que se produzca en la peticion fetch aparecera en la consola un texto Eroor: con el error que se haya producido

    //el fetch lo hacemos para enviar al servidor los datos del alumno en formato JSON,
    //ya que el backend espera recibir los datos en este formato para poder procesarlos correctamente
}

//----------------------------------------------------------------------------------------------------------//    
// Hacer que al pasar el raton por encima del input se colorease de azul 
/*const inputNombre = document.getElementById("nombre");

inputNombre.addEventListener("mousemove", function() {
    inputNombre.style.backgroundColor = "#969797"
    inputNombre.style.color = "black"    
});

inputNombre.addEventListener("mouseleave", function() {
    inputNombre.style.backgroundColor = ""
    inputNombre.style.color = ""    
});*/