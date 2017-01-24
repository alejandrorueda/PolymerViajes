/*
Copyright (c) 2015 The Polymer Project Authors. All rights reserved.
This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
Code distributed by Google as part of the polymer project is also
subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
*/

(function(document) {
  'use strict';

  // Grab a reference to our auto-binding template
  // and give it some initial binding values
  // Learn more about auto-binding templates at http://goo.gl/Dx1u2g
  var app = document.querySelector('#app');

  
  // Sets app default base URL
  //Establecemos el objeto "indexedDB" para que sea compatible con las versiones específicas de los navegadores
/*window.indexedDB = window.indexedDB || window.webkitIndexedDB || window.mozIndexedDB;
//WebKit necesita adaptar algunos elementos de más
if ('webkitIndexedDB' in window) {
    window.IDBTransaction = window.webkitIDBTransaction;
    window.IDBKeyRange = window.webkitIDBKeyRange;
}*/

var GDev={}  //Creamos el objeto donde almacenaremos todo lo relacionado con esta prueba
GDev.IDB={} //Aquí añadiremos el objeto de la DB, donde meteremos la respuesta de la API y las funciones relacionadas



GDev.IDB.open=function(){    //Establecemos la función que abre la DB
    var AccesoAPI=indexedDB.open("PruebaGDev")    //De esta forma accedemos a la API y abrimos esta DB
    AccesoAPI.onsuccess=function(e){    //Esta API asíncrona cuando recibe la respuesta ejecutará esta función
        GDev.IDB.db=e.target.result //Esta es la respuesta de la API con el acceso a la DB
        //Cuando tenemos la base de datos ejecutamos la
        //función encargada de comprobar si la base de datos
        //está vacía y si es la misma que vamos a insertar
        GDev.IDB.versiones()
    }
    AccesoAPI.onerror=GDev.IDB.error    //Función en caso de error
}

//Establecemos la función que comprueba las versiones de la base de datos
GDev.IDB.versiones=function(){
    var base_datos=GDev.IDB.db  //Cogemos la respuesta de la base de datos
    var Version=1   //Esta es la versión de la base de datos (cuando hagamos cambios debemos de incrementarla para saber que tiene la DB)
    if(Version!=base_datos.version){
        //Si no es la misma versión añadiremos un par de cosas antes de seguir
        //con la ejecución y si fuese idéntico el contenido (por tener la misma versión)
        //no hubiese hecho falta añadirlas
        var rVersion=base_datos.setVersion(Version) //Establecemos la nueva versión (Nos devuelve la respuesta)
        rVersion.onerror=GDev.IDB.error //Función en caso de error
        rVersion.onsuccess=function(e){ //Se ejecutará cuando recibamos la respuesta de la nueva versión
            if(base_datos.objectStoreNames.contains("Productos")) {
                base_datos.deleteObjectStore("Productos") //Si ya existe el almacén "Productos" lo quitamos antes
            }
            base_datos.createObjectStore("Productos",{keyPath:"ID"})
            //Con esto acabamos de crear el almacén "Productos" en la
            //base de datos "PruebaGDev" y está en su versión "1.00"
            e.target.transaction.oncomplete=GDev.IDB.anadirProductos
            //Al completar la implementación del nuevo almacén se ejecuta la función
        }
    }else{
        GDev.IDB.anadirProductos()  //Al tener la misma versión no hace falta volver a crear el almacén
    }
}


//En esta función añadiremos varios productos de ejemplo
GDev.IDB.anadirProductos=function(){
    var base_datos=GDev.IDB.db  //Cogemos la respuesta de la base de datos
    var trans=base_datos.transaction("Productos",'readwrite')
    //Creamos una transacción con la DB y cogemos el almacén "Productos" con derecho de lectura y escritura
    var Almacen=trans.objectStore("Productos")    //"Almacen" nos da acceso a "Productos"
    //Ahora añadiremos 3 productos que recibimos supuestamente por AJAX
    var AJAX=[
        {id:21992,name:"Memoria RAM"},
        {id:21261,name:"Cable Ethernet"},
        {id:21390,name:"Tarjeta WIFI"},
        {id:22082,name:"Tarjeta miniSD"}
    ]
    //Con este objeto recibido haremos un bucle y añadiremos los 4 productos,
    //al ser asíncrona la respuesta mandaremos a la función final el número de
    //productos para añadir y así seguir la cuenta para ejecutarse al completarlas
    GDev.IDB.nProducto=AJAX.length  //Establecemos el número de productos
    GDev.IDB.contProducto=0 //Establecemos en 0 el contador
    for(var i=0;i<AJAX.length;i++){
        var RespNuevo=Almacen.put({ //Añadimos un nuevo registro en la DB
            "ID":AJAX[i].id,
            name:AJAX[i].name
        })
        RespNuevo.onerror=GDev.IDB.error    //Función en caso de error
        RespNuevo.onsuccess=GDev.IDB.mostrarProductos   //Al añadir los elementos llamamos a la función
    }
}

//Esta es la función que al haber añadido todos los elementos en la BD nos muestra el resultado
GDev.IDB.mostrarProductos=function(){
    GDev.IDB.contProducto++
    if(GDev.IDB.contProducto>=GDev.IDB.nProducto){   //Ya sabemos que se han añadido los productos
        //Ahora recogeremos los datos de nuestro almacén "Productos"
        var base_datos=GDev.IDB.db
        var trans=base_datos.transaction("Productos",'readwrite')
        var Almacen=trans.objectStore("Productos")
        //Hemos abierto como antes el almacén "Productos"
        var rangoSel = IDBKeyRange.lowerBound(0)    //Al establecer 0 coge todos los elementos
            var Busqueda = Almacen.openCursor(rangoSel) //Cogemos los elementos
            Busqueda.onerror=GDev.IDB.error //Función en caso de error
            //Con los elementos que nos devuelve añadiremos una lista en el <body>
            document.body.innerHTML=''  //Eliminamos el contenido de <body> (por si las moscas)
            Busqueda.onsuccess = function(e) {
            var resultado = e.target.result //Es el resultado del primer elemento
            if(!!resultado == false) return false   //Si no hay un elemento para la acción
            GDev.IDB.escribir(resultado.value)  //Mandamos el contenido a la función que lo muestra
            resultado.continue()    //El "continue" hace repetir esta acción con el siguiente elemento
        }
    }
}
//Esta función escribe en el <body> los elementos insertados
GDev.IDB.escribir=function(elemento){
    document.body.innerHTML+=
        '<b>ID</b>: '+elemento.ID+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
        '<b>Producto</b>: '+elemento.name+'<br>'
}

GDev.IDB.error=function(){alert("Ha ocurrido un error")}
GDev.IDB.open()

})(document);
